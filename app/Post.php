<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	//change Table Name
	protected $table = 'posts';
	//primary key
	public $primaryKey = 'id';
	//timestamps
	public $timestamps = true;

    // a post belongs to a user
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
