<?php

namespace Modules\Lokasi\Models;

use CodeIgniter\Model;

class LokasiModel extends Model
{
    protected $table = 'lokasi';
    protected $primaryKey = 'lokasiId';
    protected $allowedFields = ['lokasiNama', 'lokasiCreatedBy', 'lokasiCreatedDate', 'lokasiModifiedBy', 'lokasiModifiedDate', 'lokasiDeletedDate'];
    protected $useTimestamps = 'false';
    protected $useSoftDeletes = 'true';
    protected $createdField = 'lokasiCreatedDate';
    protected $updatedField = 'lokasiModifiedDate';
    protected $deletedField = 'lokasiDeletedDate';
    protected $returnType = 'object';

    public function getLokasi($keyword = null)
    {
        $builder = $this->table($this->table);
        if ($keyword) {
            $builder->like($this->table . '.lokasiNama', $keyword)->where($this->table . '.lokasiDeletedDate', null);
        }
        $builder->orderBy($this->table . '.lokasiId', 'DESC');
        return $builder;
    }

    public function updateData($where, $data)
    {
        $builder = $this->table($this->table);
        return $builder->set($data)
            ->where($where)
            ->update();
    }

    public function deleteData($where)
    {
        $builder = $this->table($this->table);
        return $builder->where($where)
            ->delete();
    }
}
