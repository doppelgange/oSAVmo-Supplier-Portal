<?php

class ActionLogsController extends \BaseController {

	protected $layout = "layouts.main";

	/**
	 * Display a listing of the resource.
	 * GET /logs
	 *
	 * @return Response
	 */
	public function index()
	{
		$actionLogs = ActionLog::paginate(10);
		$this->layout->content = View::make('actionLogs.index',array('actionLogs'=>$actionLogs)); 
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /logs/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /logs
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /logs/{id}
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
	 * GET /logs/{id}/edit
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
	 * PUT /logs/{id}
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
	 * DELETE /logs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}