<?php

class WechatController extends \BaseController {

	public function __construct()
    {
        //$this->beforeFilter('wechat', array('on' => 'get|post'));
    }

	//protected $layout = "layouts.main";
	/**
	 * Display a listing of the resource.
	 * GET /wechat
	 *
	 * @return Response
	 */
	public function index()
	{
		//return Input::get('echostr');
		ActionLog::Create(array(
			'module' => 'wechat',							
			'type' => 'test',
			'notes' => 'get index page'.json_encode(Input::all()),
			'from' =>'',
			'to' => '',
			'user' => 'wechat'
		));
		return json_encode(Input::all());
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /wechat/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /wechat
	 *
	 * @return Response
	 */
	public function store()
	{	
		$message = file_get_contents('php://input');		
		ActionLog::Create(array(
			'module' => 'wechat',							
			'type' => 'test',
			'notes' => 'post store page'.$message,
			'from' =>'',
			'to' => '',
			'user' => 'wechat'
		));

		return 'store';
	}

	/**
	 * Display the specified resource.
	 * GET /wechat/{id}
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
	 * GET /wechat/{id}/edit
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
	 * PUT /wechat/{id}
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
	 * DELETE /wechat/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}