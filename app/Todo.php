<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    //
    protected $table = 'todo';
    protected $fillable = ['title','content','attachment','done_at','user_id'];
}
