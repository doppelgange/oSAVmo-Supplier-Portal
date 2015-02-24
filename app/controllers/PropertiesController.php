<?php

class PropertiesController extends \BaseController {

	protected $layout = "layouts.main";
	/**
	 * Display a listing of the resource.
	 * GET /properties
	 *
	 * @return Response
	 */
	public function index()
	{
		$properties = Property::paginate(10);
  		$this->layout->content = View::make('properties.index',array('properties'=>$properties));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /properties/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$properties = Property::all();
		$this->layout->content = View::make('properties.create',array('properties'=>$properties));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /properties
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), Property::$rules);
		//dd($validator) ;
	    if ($validator->passes()) {
		    $property = new Property;
		    $property->name = Input::get('name');
		    $property->key = Input::get('key');
		    $property->value = Input::get('value');
		    $property->remarks = Input::get('remarks');
		    $property->save();
		    return Redirect::to('properties/create')->withInput()->with('message', 'New property is added successfully!');
		} else {
		    return Redirect::to('properties/create')->withInput()->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
		}
	}

	/**
	 * Display the specified resource.
	 * GET /properties/{id}
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
	 * GET /properties/{id}/edit
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
	 * PUT /properties/{id}
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
	 * DELETE /properties/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}