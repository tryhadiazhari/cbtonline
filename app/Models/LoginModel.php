<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table      = 'hazedu_users';
    protected $primaryKey = 'uid';
    protected $useAutoIncrement = false;
    protected $useTimestamps = false;
    protected $allowedFields = ['uid', 'npsn', 'fname', 'eml', 'hp', 'uname', 'pword', 'lv', 'img', 'crdate', 'upddate', 'activation_date', 'is_activated'];
}
