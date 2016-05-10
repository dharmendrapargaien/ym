<?php

namespace App\Http\Controllers\Api\Buyer\V1;

use Mail;
use App\Models\Buyer;

use App\Transformers\Api\V1\Buyer\AuthenticateTransformer;
use App\Transformers\Api\V1\Buyer\BuyerTransformer;

use App\Http\Requests\Api\V1\Buyer\SignUpRequest;
use App\Http\Requests\Api\V1\Buyer\AuthenticationRequest;
use App\Http\Requests\Api\V1\Buyer\ForgotPasswordRequest;
use App\Http\Requests\Api\V1\Buyer\ActiveAcountRequest;

use Authorizer, Auth;

use League\Fractal;

class AuthController extends BaseController
{
	/**
	 * Buyer model instance
	 * @var App\Models\Buyer
	 */
	protected $sellerModel;

	public function __construct(Buyer $buyer)
	{
		parent::__construct();
		$this->buyerModel = $buyer;
	}

	/**
	 * Checks buyer credentials and provide them with an authorization token for subsequent requests
	 * @param  \App\Http\Requests\Api\V1\Buyer\AuthenticationRequest $request
	 * @return json
	 */
	public function authenticate(AuthenticationRequest $request)
	{
		//request for oauth authorization
		$authorizer = Authorizer::issueAccessToken();
		$buyer     = $this->buyerModel->getBuyerData($request->input('email'));
		
		//add buyer data 
		$authorizer['id']    = $buyer['id'];
		$authorizer['email'] = $buyer['email'];
		$authorizer['name']  = $buyer['name'];

		// We have an access token. Now we need to return that.
        $resource = new \App\Fractal\Item($authorizer, new AuthenticateTransformer);
        
        return response()->json($resource->getSuccess(), 200);
    }

	/**
	 * Sends a temporary password to buyer
	 * @param  ForgotPasswordRequest $request
	 * @return json
	 */
	public function forgotPassword(ForgotPasswordRequest $request)
	{
		\DB::beginTransaction();

		$email = $request->email;
		$buyer  = $this->buyerModel->whereEmail($email)->first();

		$this->sendTemporaryPassword($buyer);

		\DB::commit();
	
		// We have an API key. Now we need to return that.
        $resource = new \App\Fractal\Item($buyer, new BuyerTransformer);
        return response()->json($resource->getSuccess(), 200);
	}

	/**
	 * Generates a temporary password and send and email
	 * @param  App\Models\Buyer $buyer
	 * @return boolean
	 */
	public function sendTemporaryPassword($buyer)
	{
		$chars    = "abcdefghjkmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789!@#&";
		$password = substr( str_shuffle( $chars ), 0, 6 );

		$buyer->temporary_password = $password;
		$buyer->save();

    	return Mail::send('auth.emails.api.v1.buyer.temporary_password', ['buyer' => $buyer], function ($m) use ($buyer) {
    		$m->to($buyer->email, $buyer->name)->subject('Test Api Password');
    	});
	}

	/**
	 * Signup a new buyer
	 * @param  \App\Http\Requests\Api\V1\Buyer\SignUpRequest $request
	 * @return json
	 */
	public function signup(SignUpRequest $request)
	{
		\DB::beginTransaction();

		$request_data = $request->all();

		$request_data['email']    = trim($request->email);
		$request_data['password'] = bcrypt(trim($request->password));
		$request_data['phone_no'] = trim($request->phone_no);
		$request_data['name']     = trim($request->get('name'));
		
		$buyer = $this->buyerModel->create($request_data);
		$this->sendActivationCode($buyer);

		\DB::commit();

		// We have an API key. Now we need to return that.
        $resource = new \App\Fractal\Item($buyer, new BuyerTransformer);
        return response()->json($resource->getSuccess(), 200);
	}

	/**
	 * Create and send activation code to newly registered buyer
	 * @param  \App\Models\Buyer $buyer
	 * @return boolean
	 */
	private function sendActivationCode($buyer)
	{

		$confirmation_code = mt_rand(100000, 999999);
		$buyer->confirmation_code = $confirmation_code;
		$buyer->save();

		// Send an email about this
		return Mail::send('auth.emails.api.v1.buyer.activation', ['buyer' => $buyer], function ($m) use ($buyer) {
			$m->to($buyer->email, $buyer->name)->subject('app activation code');
		});
	}

	/**
	 * Activate buyer with confirmation code
	 * @param  int $confirmation_code [Confirmation code which buyer got in email]
	 * @return json
	 */
	public function activate(ActiveAcountRequest $request)
	{
		
		$buyer =  $this->buyerModel->getSellerConfirmationData($request->input('email'), $request->input('confirmation_code'));
		
		$buyer->status            = 1;
		$buyer->confirmation_code = null;
		$buyer->save();

		//request for oauth authorization
		$authorizer = Authorizer::issueAccessToken();
		$buyer     = $this->buyerModel->getSellerData($request->input('email'));
		
		//add buyer data 
		$authorizer['id']    = $buyer->id;
		$authorizer['email'] = $buyer->email;
		$authorizer['name']  = $buyer->name;

		// We have an access token. Now we need to return that.
        $resource = new \App\Fractal\Item($authorizer, new AuthenticateTransformer);
        
        return response()->json($resource->getSuccess(), 200);
	}
}