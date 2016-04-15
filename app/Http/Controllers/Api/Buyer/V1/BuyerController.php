<?php

namespace App\Http\Controllers\Api\Buyer\V1;

use File;
use Storage;
use Carbon\Carbon;
use App\Models\Buyer;
use App\Transformers\UserTransformer;
use App\Http\Requests\Api\User\ProfileUpdateRequest;
use App\Http\Requests\Api\User\UserSettingRequest;

class BuyerController extends BaseController
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
}
