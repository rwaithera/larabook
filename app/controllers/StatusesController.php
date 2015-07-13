<?php

//use Laracasts\Commander\CommandBus;
use Larabook\Forms\PublishStatusForm;
use Larabook\Statuses\PublishStatusCommand;
use Larabook\Statuses\StatusRepository;

class StatusesController extends \BaseController {

    protected  $statusRepository;
    /**
     * @var PublishStatusForm
     */
    private $publishStatusForm;

    function __construct(PublishStatusForm $publishStatusForm,StatusRepository $statusRepository){

        $this->statusRepository = $statusRepository;
        $this->publishStatusForm = $publishStatusForm;
    }

	public function index()
	{
        $statuses = $this->statusRepository->getFeedForUser(Auth::user());

		return View::make('statuses.index', compact('statuses'));
	}

    //store new status
    public function store(){

        /*$input = Input::get();
        $input['userId'] = Auth::id();*/

        $input = array_add(Input::get(), 'userId', Auth::id());

        $this->publishStatusForm->validate($input);

        $this->execute(PublishStatusCommand::class, $input);

        /*$this->execute(
            new PublishStatusCommand(Input::get('body'), Auth::user()->id)
        );*/

        //$command = PublishStatusCommand(Input::get('body'));

        //flash message
        return Redirect::back();

    }

}
