<?php  namespace Larabook\Users; 

class FollowUserCommandHandler {

    protected $userRepo;

    function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function handle($command){
        $user =  $this->userRepo->findById($command->userId);

        $this->userRepo->follow($command->userIdToFollow, $user);

        return $user;
    }

}