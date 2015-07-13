<?php namespace Codeception\Module;

use Laracasts\TestDummy\Factory as TestDummy;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{

    public function signIn(){
        //have set up dummy data to use in our tests
        $username = "Foobar";
        $email = 'foo@example.com';
        $password = 'foo';

        $this->haveAnAccount(compact('username', 'email', 'password'));

        $I = $this->getModule('Laravel4');

        $I->amOnPage('/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click('Sign In');
    }

    public function  postAStatus($body){
        $I = $this->getModule('Laravel4');

        $I->fillField('body', $body);
        $I->click('Post Status');
        //$this->have('Larabook\Statuses\Status', $overrides);
    }

    public function have($model, $overrides = []){
        return TestDummy::create($model, $overrides);
    }

    public function haveAnAccount($overrides = []){

        return $this->have('Larabook\Users\User', $overrides);

    }

}
