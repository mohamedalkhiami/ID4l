<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageLogModel extends Model
{
    protected $table = 'message_log';
    protected $primaryKey = 'log_id';

    protected $fillable = ['Item_id', 'user_id', 'message'];

    public $timestamps = false;


    public function messagelog()
    {
        return $this->belongsTo('app/FileItemModel');
    }
}
