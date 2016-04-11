<?php

namespace App\Http\Controllers\Api\V1;

use Mail;
use App\Models\User;

use App\Transformers\AuthenticateTransformer;
use App\Transformers\UserTransformer;

use App\Http\Requests\Api\User\SignUpRequest;
use App\Http\Requests\Api\User\AuthenticationRequest;
use App\Http\Requests\Api\User\ForgotPasswordRequest;
use Authorizer, Auth;

use League\Fractal;

class AuthController extends BaseController
{
	/**
	 * User model instance
	 * @var App\Models\User
	 */
	protected $userModel;

	public function __construct(User $user)
	{
		parent::__construct();
		$this->userModel = $user;
	}

	/**
	 * Checks user credentials and provide them with an authorization token for subsequent requests
	 * @param  \App\Http\Requests\Api\User\AuthenticationUserRequest $request
	 * @return json
	 */
	public function authenticate(AuthenticationRequest $request)
	{
		
		// //request for oauth authorization
        $authorizer = Authorizer::issueAccessToken();

        // We have an API key. Now we need to return that.
        $resource = new \App\Fractal\Item($authorizer, new AuthenticateTransformer);
        
        return response()->json($resource->getSuccess(), 200);
    }

	/**
	 * Log in a user by temporary password
	 * @param  array $credentials [Original credentials supplied]
	 * @return boolean
	 */
	public function loginUsingTemporaryPassword($credentials)
	{
		$user = $this->userModel->whereEmail($credentials['email'])->whereTemporaryPassword($credentials['password'])->first();

		if (is_null($user)) {
			return false;
		}

		Auth::loginUsingId($user->id);

		return true;
	}

	/**
	 * Signup a new user
	 * @param  \App\Http\Requests\Api\User\SignUpRequest $request
	 * @return json
	 */
	public function signup(SignUpRequest $request)
	{
		\DB::beginTransaction();

		$request_data = $request->all();
		$request_data['password'] = bcrypt($request->password);
		$request_data['status'] = 1;
		$request_data['username'] = strtolower($request->get('username'));

		$user = $this->userModel->create($request_data);
		$this->sendActivationCode($user);

		\DB::commit();
		return $this->response->withItem($user, new UserTransformer);
	}

	

	/**
	 * Sends a temporary password to user
	 * @param  ForgotPasswordRequest $request
	 * @return json
	 */
	public function forgotPassword(ForgotPasswordRequest $request)
	{
		\DB::beginTransaction();

		$email = $request->email;
		$user = $this->userModel->whereEmail($email)->first();

		$this->sendTemporaryPassword($user);

		\DB::commit();
		return $this->response->withItem($user, new UserTransformer);
	}

	/**
	 * Generates a temporary password and send and email
	 * @param  App\Models\User $user
	 * @return boolean
	 */
	public function sendTemporaryPassword($user)
	{
		$chars = "abcdefghjkmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789!@#&";
		$password = substr( str_shuffle( $chars ), 0, 6 );

		$user->temporary_password = $password;
		$user->save();

    	return Mail::send('auth.emails.temporary_password', ['user' => $user], function ($m) use ($user) {
    		$m->to($user->email, $user->name)->subject('Bump App Password');
    	});
	}

	/**
	 * Create and send activation code to newly registered user
	 * @param  \App\Models\User $user
	 * @return boolean
	 */
	private function sendActivationCode($user)
	{
		$confirmation_code = mt_rand(100000, 999999);
		$user->confirmation_code = $confirmation_code;
		$user->save();

		// Send an email about this
		return Mail::send('auth.emails.activation', ['user' => $user], function ($m) use ($user) {
			$m->to($user->email, $user->name)->subject('Bump Account Activation');
		});
	}

	/**
	 * Activate user with confirmation code
	 * @param  int $confirmation_code [Confirmation code which user got in email]
	 * @return json
	 */
	public function activate($confirmation_code)
	{
		if (!$confirmation_code) {
			return $this->response->errorWrongArgs("Invalid confirmation code");
		}
		$user = $this->userModel->whereConfirmationCode($confirmation_code)->first();

		if (!$user) {
			return $this->response->errorUnauthorized('Wrong confirmation code');
		}

		$user->confirmed = 1;
		$user->confirmation_code = null;
		$user->save();

		\Auth::loginUsingId($user->id, true);

		$apiKey = $this->generateApiToken($user);

		if (!$apiKey->save()) {
			return $this->response->errorInternalError("Failed to create an API key. Please try again.");
		}

		return $this->response->withItem($apiKey, new ApiKeyTransformer);
	}
}