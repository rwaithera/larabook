<?php

use Larabook\Users\FollowUserCommand;
use Larabook\Users\UnfollowUserCommand;

class FollowsController extends \BaseController {

	/**
	 * Follow a user
	 *
	 * @return Response
	 */
	public function store()
	{
		//id of user to follow
        //id of authenticated user
        $input = array_add(Input::get(), 'userId', Auth::id());

        $this->execute(FollowUserCommand::class, $input);

        return Redirect::back();

    }

	/**
	 * Unfollow a user
	 *
	 * @param  int  $userIdToUnfollow
	 * @return Response
	 */
	public function destroy($userIdToUnfollow)
	{
        //id of user to unfollow
        //id of authenticated user
        $input = array_add(Input::get(), 'userId', Auth::id());

        $this->execute(UnfollowUserCommand::class, $input);

        return Redirect::back();
	}


}
