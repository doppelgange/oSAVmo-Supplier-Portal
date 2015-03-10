<?php

class WxMessage extends \Eloquent {
	protected $fillable = [
		'id',
		'toUserName',
		'fromUserName',
		'createTime',
		'msgType',
		'content',
		'msgId',
		'picUrl',
		'mediaId',
		'thumbMediaId',
		'url',
		'title',
		'description'
		];
}