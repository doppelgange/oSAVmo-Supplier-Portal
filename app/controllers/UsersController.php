<?php
class UsersController extends BaseController {
	public function __construct() {
	    $this->beforeFilter('csrf', array('on'=>'post'));
	    $this->beforeFilter('auth', array('only'=>array('getDashboard')));
	}

    protected $layout = "layouts.main";

    public function getNew() {
    	$suppliers= Supplier::getManageable(); 
	    $this->layout->content = View::make('users.new',array('suppliers'=>$suppliers));

	}


	public function getEnquire(){
		$users = User::all();
		$suppliers= Supplier::getManageable(); 
		$this->layout->content = View::make('users.enquire',array('users'=>$users,'suppliers'=>$suppliers)); 
	}

	public function profile($id){
		$user = User::find($id);
		$suppliers= Supplier::getManageable(); 
		$this->layout->content = View::make('users.profile',array('user'=>$user,'suppliers'=>$suppliers)); 
	}

	public function postCreate() {
		$validator = Validator::make(Input::all(), User::$rules);
	    if ($validator->passes()) {
		    $user = new User;
		    $user->firstname = Input::get('firstname');
		    $user->lastname = Input::get('lastname');
		    $user->supplierID = Input::get('supplierID');
		    $user->email = Input::get('email');
		    $user->password = Hash::make(Input::get('password'));
		    $user->save();
		    return Redirect::to('users/login')->with('message', 'New user is created successfully!');
		} else {
		    return Redirect::to('users/new')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
		}
	}


	public function postAmend() {
		$currentRules = User::$rules;
		unset($currentRules['password'],$currentRules['password_confirmation']);
		$validator = Validator::make(Input::all(), $currentRules);
	    if ($validator->passes()) {
		    $user = User::find(Input::get('id'))->first();
		    $user->firstname = Input::get('firstname');
		    $user->lastname = Input::get('lastname');
		    $user->supplierID = Input::get('supplierID');
		    $user->email = Input::get('email');
		    $user->save();
		    return Redirect::to('users/enquire')->with('message', 'User is created successfully!');
		} else {
		    return Redirect::to('users/enquire/'.Input::get('id'))->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
		}
	}

	public function getLogin() {
	    $this->layout->content = View::make('users.login');
	}

	public function postSignin() {
		if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
		    return Redirect::to('users/dashboard')->with('message', 'You are now logged in!');
		} else {
		    return Redirect::to('users/login')
		        ->with('message', 'Your username/password combination was incorrect')
		        ->withInput();
		}
             
	}

	public function getDashboard() {
	    $this->layout->content = View::make('users.dashboard');
	}

	public function getLogout() {
	    Auth::logout();
	    return Redirect::to('users/login')->with('message', 'Your are now logged out!');
	}

}

	Route::get('users/enquire/{id}', 'UsersController@profile');
	//Route::post('users/amend', 'UsersController@amend');
?>