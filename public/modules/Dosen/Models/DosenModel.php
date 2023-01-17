<?php

namespace Modules\Dosen\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table = 'penguji';
    protected $primaryKey = 'pengujiId';
    protected $allowedFields = ['pengujiNama', 'pengujiPegawaiId', 'pengujiCreatedBy', 'pengujiCreatedDate', 'pengujiStatus', 'pengujiModifiedBy', 'pengujiModifiedDate', 'pengujiDeletedDate'];
    protected $useTimestamps = 'false';
    protected $useSoftDeletes = 'true';
    protected $createdField = 'pengujiCreatedDate';
    protected $updatedField = 'pengujiModifiedDate';
    protected $deletedField = 'pengujiDeletedDate';
    protected $returnType = 'object';

    public function getDosenPenguji($keyword = null)
    {
        $builder = $this->table($this->table);
        if ($keyword) {
            $builder->like($this->table . '.pengujiNama', $keyword)->where($this->table . '.pengujiDeletedDate', null);
        }
        $builder->orderBy($this->table . '.pengujiId', 'DESC');
        return $builder;
    }

    public function cekDosen($where)
    {
        $builder = $this->table($this->table);
        $builder->where($where);
        return $builder;
    }
}
