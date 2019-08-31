<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PostComment extends Model
{
	protected $fillable = [
        'user_id', 'post_id', 'comments','created_at'
    ];

	public function post() {
		return $this->belongsTo(Post::class, 'post_id');
	}

	public function getCreatedAtAttribute($date){
	    try {
	        $data = Carbon::parse($date)->diffForHumans();

	    } catch (\Exception $e) {
	        $data = $date;
	    }

	   return ($data);
	}
}