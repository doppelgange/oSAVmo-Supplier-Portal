<?php

class WxMessagesController extends \BaseController {

	protected $layout = "layouts.main";
	/**
	 * Display a listing of the resource.
	 * GET /wxmessages
	 *
	 * @return Response
	 */
	public function index()
	{
		$wxMessages = WxMessage::paginate(10);
  		$this->layout->content = View::make('wxMessages.index',array('wxMessages'=>$wxMessages));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /wxmessages/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /wxmessages
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /wxmessages/{id}
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
	 * GET /wxmessages/{id}/edit
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
	 * PUT /wxmessages/{id}
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
	 * DELETE /wxmessages/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}