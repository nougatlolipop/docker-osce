<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthGroupsUsersModel extends Model
{
    protected $table = 'auth_groups_users';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['group_id', 'deleted_at'];
    protected $returnType = 'object';
    protected $useSoftDeletes = 'true';
}
