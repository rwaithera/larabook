<?php namespace Larabook\Registration;

use Larabook\Users\User;
use Larabook\Users\UserRepository;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class RegisterUserCommandHandler implements CommandHandler{

    use DispatchableTrait;

    protected $repository;

    //initialize repository
    function __construct(UserRepository $repository){
        $this->repository = $repository;
    }

    public function handle($command){

        //register a user
        $user = User::register(
            $command->username, $command->email, $command->password
        );

        //persist user in the db
        //$user->raise(new UserRegistered);
        $this->repository->save($user);

        //$events = $user->releaseEvents();

        $this->dispatchEventsFor($user);

        return $user;
    }
}
