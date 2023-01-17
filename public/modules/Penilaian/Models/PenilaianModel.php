<?php

namespace Modules\Penilaian\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $table = 'grade';
    protected $primaryKey = 'gradeId';
    protected $allowedFields = ['gradeSetId', 'gradeMahasiswa', 'gradeNilai', 'gradeCreatedDate', 'gradeModifiedDate'];
    protected $useTimestamps = 'false';
    protected $createdField = 'gradeCreatedDate';
    protected $updatedField = 'gradeModifiedDate';
    protected $returnType = 'object';
    protected $whereForNilai = [];

    public function getSkenario($id, $station)
    {
        $builder = $this->db->table("function_tampil_skenario(" . $id . "," . $station . ")");
        return $builder->get();
    }

    public function getAllAttachment($id, $station)
    {
        $builder = $this->db->table("function_tampil_all_attachment(" . $id . "," . $station . ")");
        return $builder->get();
    }

    public function getPeserta($wherePeserta, $whereNilai)
    {
        $this->whereForNilai = $whereNilai;
        $builder = $this->db->table("function_mahasiswa_station() as peserta");
        $builder->join('grade', 'grade."gradeSetId" = peserta."setId" and grade."gradeMahasiswa"= peserta."peserta"', 'LEFT');
        $builder->join('mahasiswa', 'mahasiswa."mahasiswaNpm" = peserta."peserta" ', 'LEFT');
        $builder->where($wherePeserta);
        $builder->whereNotIn(
            'peserta."peserta"',
            function (BaseBuilder $subBuilder) {
                return $subBuilder->select('nilai."peserta"')->from("function_mahasiswa_nilai() as nilai")->where($this->whereForNilai);
            }
        );
        $builder->orderBy('peserta."lokasiId"', 'ASC');
        $builder->limit(1, 0);
        return $builder->get();
    }

    public function getAllPeserta($wherePeserta)
    {
        $builder = $this->db->table("function_mahasiswa_station() as peserta");
        $builder->join('grade', 'grade."gradeSetId" = peserta."setId" and grade."gradeMahasiswa"= peserta."peserta"', 'LEFT');
        $builder->join('mahasiswa', 'mahasiswa."mahasiswaNpm" = peserta."peserta" ', 'LEFT');
        $builder->where($wherePeserta);
        $builder->orderBy('peserta."lokasiId"', 'ASC');
        return $builder->get();
    }

    public function updateData($where, $data)
    {
        $builder = $this->table($this->table);
        return $builder->set($data)
            ->where($where)
            ->update();
    }
}
