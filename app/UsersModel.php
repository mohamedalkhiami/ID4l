<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    protected $table = 'Users';
    public $timestamps = false;
    protected $fillable = ['first_name', 'last_name', 'Firebase_Token'];

    public function SignerModel()
    {
        return $this->hasOne('SignerModel', 'user_id');
    }

    public function Viewer()
    {
        return $this->hasOne('Viewer_Model', 'user_id');
    }

    public function userFile()
    {
        return $this->hasMany('FileModel', 'file-owner');
    }

    public function MessageLogModel()
    {
        return $this->hasMany('MessageLogModel', 'user_id');
    }
}
