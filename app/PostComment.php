<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{

    protected $fillable = [
        'user_id', 'post_id', 'comments','created_at'
    ];
   
    public function getCreatedAtAttribute($date){
        try {
            $data = Carbon::parse($date)->diffForHumans();
            
        } catch (\Exception $e) {
            $data = $date;
        }

       return ($data);
    }
}
