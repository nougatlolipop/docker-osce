<?php

namespace Modules\ManajemenAkun\Models;

use CodeIgniter\Model;

class ManajemenAkunModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'username', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash', 'status', 'status_message', 'active', 'force_pass_reset', 'created_at', 'created_update', 'deleted_at'];
    protected $returnType = 'object';
    protected $useSoftDeletes = 'true';

    public function getManajemenAkun($keyword = null)
    {
        $builder = $this->table('users');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'LEFT');
        $builder->join('auth_groups', 'auth_groups.id  = auth_groups_users.group_id', 'LEFT');
        if ($keyword) {
            $builder->like('LOWER(auth_groups.name)', strtolower($keyword))->where('users.deleted_at', null);
            $builder->orlike('LOWER(users.username)', strtolower($keyword))->where('users.deleted_at', null);
            $builder->orlike('LOWER(users.email)', strtolower($keyword))->where('users.deleted_at', null);
        }
        $builder->orderBy('users.id', 'DESC');
        return $builder;
    }

    public function getSpecificUser($where)
    {
        $builder = $this->table('users');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id  = auth_groups_users.group_id');
        $builder->where($where);
        $query = $builder->get();
        return $query;
    }
}
