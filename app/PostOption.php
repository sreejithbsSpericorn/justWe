<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostOption extends Model
{
	public function post() {
		return $this->belongsTo(Post::class, 'post_id');
	}
}