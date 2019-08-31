<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function posttype() {
        return $this->belongsTo(PostType::class, 'post_type');
    }
    public function comments()
    {
    	return $this->hasMany(PostComment::class);
    }
    public function options(){
        return $this->hasMany(PostOption::class);
    }
}