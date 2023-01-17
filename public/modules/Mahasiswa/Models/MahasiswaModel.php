<?php

namespace Modules\Mahasiswa\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'mahasiswaNpm';
    protected $useAutoIncrement  = false;
    protected $allowedFields = ['mahasiswaNpm', 'mahasiswaNama', 'mahasiswaCreatedBy', 'mahasiswaCreatedDate', 'mahasiswaModifiedBy', 'mahasiswaModifiedDate', 'mahasiswaDeletedDate'];
    protected $useTimestamps = 'false';
    protected $useSoftDeletes = 'true';
    protected $createdField = 'mahasiswaCreatedDate';
    protected $updatedField = 'mahasiswaModifiedDate';
    protected $deletedField = 'mahasiswaDeletedDate';
    protected $returnType = 'object';

    public function getMhs($keyword = null)
    {
        $builder = $this->table($this->table);
        if ($keyword) {
            $builder->like($this->table . '.mahasiswaNama', $keyword)->where($this->table . '.mahasiswaDeletedDate', null);
            $builder->orLike($this->table . '.mahasiswaNpm', $keyword)->where($this->table . '.mahasiswaDeletedDate', null);
        }
        $builder->orderBy($this->table . '.mahasiswaNama', 'ASC');
        return $builder;
    }

    public function cekMahasiswa($where)
    {
        $builder = $this->table($this->table);
        $builder->where($where);
        return $builder;
    }

    public function insertData($data)
    {
        $builder = $this->table($this->table);
        return $builder->set($data)->insert();
    }
}
