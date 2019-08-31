<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    // public function getCreatedAtAttribute($date){
    //     try {
    //         $data = Carbon::parse($date)->diffForHumans();

    //     } catch (\Exception $e) {
    //         $data = $date;
    //     }

    //    return ($data);
    // }
}