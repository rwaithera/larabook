<?php namespace Larabook\Users;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Hash;
use Laracasts\Commander\Events\EventGenerator;
use Larabook\Registration\Events\UserRegistered;
use Laracasts\Presenter\PresentableTrait;

class User extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, EventGenerator, PresentableTrait, FollowableTrait;


    protected $fillable = ['username', 'email', 'password'];
    protected $hidden = array('password', 'remember_token');

	protected $table = 'users';

    /**
     * Path to the presenter for a user
     * @var string
     */
    protected $presenter = 'Larabook\Users\UserPresenter';


    public function setPasswordAttribute($password){
        $this->attributes['password'] = Hash::make($password);
    }


    //a user has many statuses
    public function statuses(){
        return $this->hasMany('Larabook\Statuses\Status')->latest();
    }


    //register user
    public static function register($username, $email, $password){

        //in eloquent, when you pass params to instantiate an object
        //you need to pass it through as an array
        $user = new static(compact('username', 'email', 'password'));

        $user->raise(new UserRegistered($user));

        return $user;

    }

    /**
     * Determine if the given user is the same as the current one
     * @param User $user
     * @return bool
     */
    public function is(User $user){

        if(is_null($user)) return false;

        return $this->username == $user->username;
    }

    /**
     * @return mixed
     */
    public function comments(){
        return $this->hasMany('Larabook\Statuses\Comment');
    }

}