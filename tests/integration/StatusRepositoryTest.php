<?php

use Larabook\Statuses\StatusRepository;
use Laracasts\TestDummy\Factory as TestDummy;

class StatusRepositoryTest extends \Codeception\TestCase\Test
{
    /**
     * @var \IntegrationTester
     */
    protected $tester;

    protected $repo;

    protected function _before()
    {
        $this->repo = new StatusRepository;
    }


    // behaviour you want to test
    public function test_it_gets_all_statuses_for_a_user()
    {
        //given  I have 2 users
        $users = TestDummy::times(2)->create('Larabook\Users\User');

        //and statuses for both of them
        TestDummy::times(2)->create('Larabook\Statuses\Status', [
            'user_id' => $users[0]->id,
            'body' => 'My status'
        ]);

        TestDummy::times(2)->create('Larabook\Statuses\Status', [
            'user_id' => $users[1]->id,
            'body' => 'His status'
        ]);

        //when I fetch statuses for one user
        $statusesForUser = $this->repo->getAllForUser($users[0]);

        //then I should receive only the relevant ones
        $this->assertCount(2, $statusesForUser);
        //$this->assertEquals('My status', $statusesForUser[0]->body);
        //$this->assertEquals('My status', $statusesForUser[1]->body);
    }


    public function test_it_saves_a_status_for_a_user(){

        //given I have an unsaved status
        $status = TestDummy::create('Larabook\Statuses\Status', [
            'user_id' => null,
            'body' => 'My status'
        ]);

        //and an existing user
        $user = TestDummy::create('Larabook\Users\User');

        //when I try to persist this status
        $savedStatus = $this->repo->save($status, $user->id);

        //then it should be saved
        $this->tester->seeRecord('statuses', [
            'body' => 'My status'
        ]);

        //and the status should have the correct user id
        $this->assertEquals($user->id, $savedStatus->user_id);

    }

}