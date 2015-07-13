<?php namespace Larabook\Users;


class UserRepository {

    //persist a user
    public function save(User $user){

        return $user->save();
    }

    public function getPaginated($howMany = 25){

        return User::orderBy('username', 'asc')->paginate($howMany);
    }

    /**
     * Fetch a user by their username
     * @param $username
     * @return mixed
     */
    public function findByUsername($username){

        //get your user object and get an array of statuses associated with that user
        return User::with('statuses')->whereUsername($username)->first();
    }

    /**
     * Find a user by their id
     * @param $id
     * @return mixed
     */
    public function findById($id){

        return User::findOrFail($id);
    }

    /**
     * Follow a Larabook user
     * @param $userIdToFollow
     * @param User $user
     * @return mixed
     */
    public function follow($userIdToFollow, User $user){

        return $user->followedUsers()->attach($userIdToFollow);

    }

    /**
     * Unfollow a Larabook user
     * @param $userIdToUnFollow
     * @param User $user
     * @return mixed
     */
    public function unfollow($userIdToUnFollow, User $user){

        return $user->followedUsers()->detach($userIdToUnFollow);

    }

}
