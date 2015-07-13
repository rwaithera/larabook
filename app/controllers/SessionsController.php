<?php

use Larabook\Forms\SignInForm;


class SessionsController extends \BaseController {

    private $signInForm;

    public function __construct(SignInForm $signInForm){

        $this->signInForm = $signInForm;

        //except filter everywhere except for the destroy method
        $this->beforeFilter('guest', ['except' => 'destroy']);

    }

    //return view
	public function create(){

		return View::make('sessions.create');
	}

    public function store(){

        //fetch form input
        $formData = Input::only('email', 'password');

        //validate form
        $this->signInForm->validate($formData);

        //if not valid go back - global.php takes care of this

        //if valid signin
        if (Auth::attempt($formData)){
            //redirect to statuses
            Session::flash('message', 'Welcome back!');
            return Redirect::intended('statuses');
        } else{
            return Redirect::back()->withInput();
        }

    }

    //logout user
    public function destroy(){

        Session::flash('message', 'Goodbye');
        Auth::logout();
        return Redirect::to('/');

    }

}
