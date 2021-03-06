<?php namespace Larabook\Statuses;

use Larabook\Users\User;


class StatusRepository {

    public function getAllForUser(User $user){

        return $user->statuses()->with('user')->latest()->get();

    }

    /**
     * Get the feed for a user
     * @param User $user
     * @return mixed
     */
    public function getFeedForUser(User $user){

        $userIds = $user->followedUsers() ->lists('followed_id');
        $userIds[] = $user->id;

        return Status::with('comments')->whereIn('user_Id', $userIds)->latest()->get();
    }

    //save a new status for a user
    public function save(Status $status, $userId){

        return User::findOrFail($userId)
            ->statuses()
            ->save($status);

        //return statuses()->save($status);
        //$status->save();

        //associate a status with a user
        //Auth::user()->statuses()->save($status);
    }

    public function leaveComment($userId, $statusId, $body){

        $comment = Comment::leave($body, $statusId);

        User::findOrFail($userId)->comments()->save($comment);

        return $comment;

    }

}