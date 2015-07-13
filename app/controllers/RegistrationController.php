<?php

use Larabook\Forms\RegistrationForm;

class RegistrationController extends \BaseController {

    private $registrationForm;

    function __construct(RegistrationForm $registrationForm){

        $this->registrationForm = $registrationForm;
        //only guests can register
        //filter all request through the guest filter
        $this->beforeFilter('guest');

    }

	/**
	 * Show the form to register the user.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('registration.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()

	{
        $this->registrationForm->validate(Input::all());

        $user = $this->execute('Larabook\Registration\RegisterUserCommand');
        //or you could also do $this->execute(RegisterUserCommand::class);

        Auth::login($user); //manually login a user

		return Redirect::home();
    }

    public function register_path(){

    }

}
