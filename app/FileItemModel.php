<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class FileItemModel extends Model
{
    protected $table = 'file_item';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $casts = [
        'divisions' => 'array',
    ];

    protected $fillable = ['title', 'file_owner', 'status_id', 'sign_id', 'sign_sequence_id', 'total_signer', 'file_url'];

    public function fileItem()
    {
        return $this->hasMany('UsersModel');
    }

    public function messageLogModel()
    {
        return $this->hasMany('App/MessageLogModel');
    }
}
