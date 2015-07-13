<?php namespace Larabook\Statuses;

use Laracasts\Commander\Events\EventGenerator;
use Larabook\Statuses\Events\StatusWasPublished;

class Status extends \Eloquent{

    use EventGenerator;

    protected $fillable = ['body'];

    //status belongs to a user
    public function user(){

        return $this->belongsTo('Larabook\Users\User');
    }

    public static function publish($body){

        $status = new static(compact('body'));

        $status->raise(new StatusWasPublished($body));

        return $status;
    }

    /**
     * @return mixed
     */
    public function comments(){

        return $this->hasMany('Larabook\Statuses\Comment');
    }

}