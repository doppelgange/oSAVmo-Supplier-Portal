<?php

class ActionLog extends \Eloquent {
	protected $fillable = ['module','type','from','to','notes','user','date'];
}