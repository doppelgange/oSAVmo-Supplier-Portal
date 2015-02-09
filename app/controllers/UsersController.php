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
		if(Auth::user()->isSupplier()){
			$users = User::where('supplierID','=',Auth::user()->supplierID)->get();
			$suppliers = array(Auth::user()->supplierID =>Auth::user()->supplier->fullName);
		}else{
			$users = User::all();
			$suppliers= Supplier::getManageable(); 
		}
		
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

		if(Auth::user()->isSupplier()){
			$supplierName= Supplier::getManageable()[$user->supplierID]; 
		}else{
			$supplierName= 'All Supplier';
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
		if(Auth::user()->isSupplier()){
			$suppliers = array(Auth::user()->supplierID =>Auth::user()->supplier->fullName);
		}else{
			$suppliers= Supplier::getManageable(); 
		}
		$user = User::find($id);
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
		$user = User::find($id);
		$validator = Validator::make(Input::all(), User::$rulesBasicInfo);
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
	 * Change Password
	 * PUT /users/changePassword/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function changePassword($id)
	{
		//return $id;
		$user = User::find($id);
		$validator = Validator::make(Input::all(), User::$rulesPassword);
	    if ($validator->passes()) {
		    $user->password = Hash::make(Input::get('password'));
		    $user->save();
		    return Redirect::to('users/'.$id)->with('message', 'Password is update successfully!');
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
		    return Redirect::to('/')->with('message', 'You are now logged in!');
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