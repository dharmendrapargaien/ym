<?php

namespace App\Http\Controllers\Api\V1;

use File;
use Storage;
use Carbon\Carbon;
use App\Models\User;
use App\Transformers\UserTransformer;
use App\Http\Requests\Api\User\ProfileUpdateRequest;
use App\Http\Requests\Api\User\UserSettingRequest;

class UserController extends BaseController
{
	/**
	 * User model instance
	 * @var App\Models\User
	 */
	protected $userModel;

	/**
	 * Api guard configurations
	 * @var array
	 */
	protected $apiMethods = [];

	public function __construct(User $user)
	{
		parent::__construct();
		$this->userModel = $user;
	}

	/**
	 * Updates user profile
	 * @param  ProfileUpdateRequest $request
	 * @param  User                 $user    [description]
	 * @return json
	 */
	public function profileUpdate(ProfileUpdateRequest $request, User $user)
	{
		if ($request->hasFile('avatar')) {
			$user = $this->imageUpload($request->file('avatar'), $user);
		}

		$user->update($request->only(['name', 'bio', 'phone']));

		return $this->response->withItem($user, new UserTransformer);
	}

	/**
	 * Uploads an avatar for user
	 * @param  file
	 * @param  $user \App\Models\User
	 * @return \App\Models\User
	 */
	private function imageUpload($file, $user)
	{
		$oldFile = $user->getOriginal('avatar');

		// Create a unique file name
		$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
		$name = $timestamp. '-' .$file->getClientOriginalName();

		//update path
		$user->avatar = $name;

		$avatar_uri = url('/') . '/uploads/avatars/' . $name;

		try {
			$file->move(public_path() . '/uploads/avatars/', $name);

		} catch(\Exception $e) {
			return $this->response->errorInternalError("Unable to store image");
		}

		if (!is_null($oldFile) && Storage::disk('avatars')->has($oldFile)) {

			Storage::disk('avatars')->delete($oldFile);
		}

		return $user;
	}

	/**
	 * Updates secondary social account information
	 * @param  SocialAccountUpdateRequest $request
	 * @param  User                       $user
	 * @return json
	 */
	public function socialAccountUpdate(SocialAccountUpdateRequest $request, User $user)
	{
		$socialAccount = $user->socialAccount ? : new SocialAccount;

		$socialAccount->fill($request->only(['facebook', 'snapchat', 'instagram', 'twitter', 'linkedin', 'tumblr', 'vine', 'phone', 'secondary_email']));
		$user->socialAccount()->save($socialAccount);

		return $this->response->withItem($socialAccount, new SocialAccountTransformer);
	}

	/**
	 * Search a contact by username
	 * @return json
	 */
	public function addContact(User $user)
	{
		$username = $this->inputs['username'];

		$userTo = User::whereUsername($username)->first();

		if (is_null($userTo)) {
			return $this->response->errorNotFound('User not found');
		}


		if ( $user->sentTo()->whereToId($userTo->id)->count() !== 0 ) {
			return $this->response->errorWrongArgs('Request already exists');
		}

		$userRequest = new UserContact(['to_id' => $userTo->id, 'status' => 0]);

		$user->sentTo()->save($userRequest);

		return response()->json(['data' => ['status' => true]]);
	}

	/**
	 * Sends a friend request
	 * @param  User   $user
	 * @return json
	 */
	public function sendRequest(User $user)
	{
		$to = $this->inputs['to'];

		if ( $user->sentTo()->whereToId($to)->count() !== 0 ) {
			return $this->response->errorWrongArgs('Request already exists');
		}

		$userRequest = new UserContact(['to_id' => $to, 'status' => 0]);

		$user->sentTo()->save($userRequest);

		return response()->json(['data' => ['status' => true]]);
	}

	/**
	 * Get all friend requests which is sent from a user
	 * @param  User   $user
	 * @return json
	 */
	public function getRequestsSent(User $user)
	{
		$requests = $user->sentTo()->pluck('to_id');

		$users = User::whereIn('id', $requests)->get();

		return $this->response->withCollection($users, new UserTransformer);
	}

	/**
	 * Get friend requests
	 * @param  User   $user [description]
	 * @return [type]       [description]
	 */
	public function getRequests(User $user)
	{
		$requests = $user->recievedFrom()->pluck('from_id');

		$users = User::whereIn('id', $requests)->get();

		return $this->response->withCollection($users, new UserTransformer);
	}

	/**
	 * Accept a friend request
	 * @param  User   $user
	 * @param  User   $contact
	 * @return json
	 */
	public function acceptRequest(User $to, User $from)
	{
		\DB::beginTransaction();

		// Accept request
		$from->sentTo()->whereToId($to->id)->update(['status' => 1]);

		// Handshaking
		UserContact::create(['to_id' => $from->id, 'from_id' => $to->id, 'status' => 1]);

		\DB::commit();

		return response()->json(['data' => ['status' => true]]);
	}

	/**
	 * Decline a friend request
	 * @param  User   $user
	 * @param  User   $contact
	 * @return json
	 */
	public function declineRequest(User $to, User $from)
	{
		\DB::beginTransaction();

		// Accept request
		$from->sentTo()->whereToId($to->id)->delete();

		\DB::commit();

		return response()->json(['data' => ['status' => true]]);
	}

	/**
	 * Updates user settings
	 * @param  User                 $user    [description]
	 * @return json
	 */
	public function settings(UserSettingRequest $request, User $user)
	{
		\DB::beginTransaction();

		$user->update($request->only(['show_name', 'discoverable']));
		\DB::commit();

		return response()->json(['data' => ['status' => true]]);
	}
}
