<?php

use Larabook\Users\UserRepository;
use Laracasts\TestDummy\Factory as TestDummy;

class UserRepositoryTest extends \Codeception\TestCase\Test
{
    /**
     * @var \IntegrationTester
     */
    protected $tester;

    protected $repo;

    protected function _before()
    {
        $this->repo = new UserRepository;
    }


    public function test_it_paginates_all_users(){

        TestDummy::times(4)->create('Larabook\Users\User');

        $results = $this->repo->getPaginated(2);

        $this->assertCount(2, $results);
    }

    public function test_it_finds_a_user_with_statuses_by_their_username(){

        //given
        $statuses = TestDummy::times(3)->create('Larabook\Statuses\Status');
        $username = $statuses[0]->user->username;

        //when
        $user = $this->repo->findByUsername($username);

        //then
        $this->assertEquals($username, $user->username);
        $this->assertCount(3, $user->statuses);

    }

    public function test_it_follows_another_user(){

        //given I have 2 usres
        list($john, $susan) = TestDummy::times(2)->create('Larabook\Users\User');

        //and one user follows another user
        $this->repo->follow($susan->id, $john);

        //then I should see that user in the list of those that $users[0] follows
        //$this->assertCount(1, $users[0]->followedUsers);
        //$this->assertTrue($users[0]->followedUsers->contains($users[1]->id));

        $this->tester->seeRecord('follows', [
            'follower_id' => $john->id,
            'followed_id' => $susan->id
        ]);

    }

    public function test_it_unfollows_another_user(){

        //given I have 2 usres
        list($john, $susan) = TestDummy::times(2)->create('Larabook\Users\User');

        //and one user follows another user
        $this->repo->follow($susan->id, $john);

        //when one user unfollows another user
        $this->repo->unfollow($susan->id, $john);

        //then I should not see that user in the list of those that $users[0] follows

        $this->tester->dontSeeRecord('follows', [
            'follower_id' => $john->id,
            'followed_id' => $susan->id
        ]);

    }

}