<?php
class UsersController extends BaseController {
	public function __construct() {
	    $this->beforeFilter('csrf', array('on'=>'post'));
	    $this->beforeFilter('auth', array('only'=>array('getDashboard')));
	}

    protected $layout = "layouts.main";

	/**
	 * Display a listing of the resource.
	 * GET /sessions
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();
		$suppliers= Supplier::getManageable(); 
		$this->layout->content = View::make('users.index',array('users'=>$users,'suppliers'=>$suppliers)); 
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$suppliers= Supplier::getManageable(); 
	    $this->layout->content = View::make('users.create',array('suppliers'=>$suppliers));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store()
	{
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

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::find($id);

		if($user->supplierID==0){
			$supplierName= 'All Supplier';
		}else{
			$supplierName= Supplier::getManageable()[$user->supplierID]; 
		}
		$this->layout->content = View::make('users.show',array('user'=>$user,'supplierName'=>$supplierName)); 
		
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /users/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

		$user = User::find($id);
		$suppliers= Supplier::getManageable(); 
		$this->layout->content = View::make('users.edit',array('user'=>$user,'suppliers'=>$suppliers)); 
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//if(''==Input::get('password')) {return 'xxxx';}else{return 'YYY';}
		$currentRules = User::$rules;
		$user = User::find(Input::get('id'));
		//Do validation for password only when user input them
		if((Input::get('password')=='')&&(Input::get('password_confirmation')=='')){
			unset($currentRules['password'],$currentRules['password_confirmation']);
		}{
			$user->password = Hash::make(Input::get('password'));
		}
		
		$validator = Validator::make(Input::all(), $currentRules);
	    if ($validator->passes()) {
		    $user->firstname = Input::get('firstname');
		    $user->lastname = Input::get('lastname');
		    $user->supplierID = Input::get('supplierID');
		    $user->email = Input::get('email');
		    $user->save();
		    return Redirect::to('users/'.$id)->with('message', 'User is update successfully!');
		} else {
		    return Redirect::to('users/'.$id)->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	/**
	 * Below functions are used for user authentication.
	 * Login/Logout/Signin/Dashboard 
	 *
	 */

	public function login() {
	    $this->layout->content = View::make('users.login');
	}

	public function signin() {
		$rememberMe= Input::get('rememberMe')? true:false;
		if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')),$rememberMe)) {
		    return Redirect::to('users/dashboard')->with('message', 'You are now logged in!');
		} else {
		    return Redirect::to('users/login')
		        ->with('message', 'Your username/password combination was incorrect')
		        ->withInput();
		}
             
	}

	public function logout() {
	    Auth::logout();
	    return Redirect::to('users/login')->with('message', 'Your are now logged out!');
	}

	public function dashboard() {
	    $this->layout->content = View::make('users.dashboard');
	}


}


?>