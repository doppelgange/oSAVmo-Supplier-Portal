<?php
class SuppliersController extends BaseController {
	public function __construct() {
	    //$this->beforeFilter('csrf', array('on'=>'post'));
	    //$this->beforeFilter('auth', array('only'=>array('getDashboard')));
	}

    protected $layout = "layouts.main";

	public function sync(){
		$option['days'] = Input::get('days');
		if(SyncHelper::syncSuppliers($option)){
			return Redirect::to('suppliers')->with('message', 'Sync supplier successfuly!');
		}else{
			return Redirect::to('suppliers')->with('message', 'Fail to sync supplier!');
		}
	}

	public function batchAmend(){
		$manageables = Input::get('manageable');
		$erplyIDs = Input::get('erplyID');
		$reslut='';
		foreach($manageables as $k => $v){
			$supplier = Supplier::where('supplierID', '=', $erplyIDs[$k])->first();
			$supplier -> manageable = $v;
			$supplier -> save();
		}

		// return $reslut;
		return Redirect::to('suppliers')->with('message', 'Amend Successfuly!');	
	}



	 	/**
	 * Display a listing of the resource.
	 * GET /suppliers
	 *
	 * @return Response
	 */
	public function index()
	{
		//Check search criteria

		$q=Input::get('q')==null? '':Input::get('q');
		$manageable=Input::get('manageable')==null? '':Input::get('q');
		$pagecount = is_numeric(Input::get("pagecount"))? Input::get("pagecount"):10;

		//Init query
		$suppliers =Supplier::where('supplierType', '=','COMPANY');

		//Filter by query
		if($q!=''){
			$suppliers = $suppliers->where('fullName', 'like','%'.$q.'%');
		}
		if($manageable!=''){
			$suppliers = $suppliers->where('manageable', '=',$manageable);
		}
		//Order and Paginate
		$suppliers = $suppliers->orderBy('manageable','desc')
			->orderBy('fullName','asc')
			->paginate($pagecount);

		//Create view
		$this->layout->content = View::make('suppliers.index',
			array(
				'suppliers'=>$suppliers,
				'q'=>$q)
		); 

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /suppliers/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /suppliers
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /suppliers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /suppliers/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /suppliers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /suppliers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
?>