<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SignerInfoModel extends Model
{
  
    protected $table = 'Singer_Info';
    protected $fillable = ['Item_id','user_id','sequence'];

    public $timestamps = false ;

    protected $casts = [
        'divisions' => 'array',
    ];
    
}
