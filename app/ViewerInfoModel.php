<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewerInfoModel extends Model
{
    protected $table = 'viewer_Info';

    protected $fillable = ['Item_id', 'user_id'];
    public $timestamps = false;
}
