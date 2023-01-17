<?php

namespace Modules\Grade\Models;

use CodeIgniter\Model;

class GradeModel extends Model
{
    protected $table = 'grade';
    protected $primaryKey = 'gradeId';
    protected $allowedFields = ['gradeSetId', 'gradeMahasiswa', 'gradeNilai', 'gradeCreatedDate', 'gradeModifiedDate'];
    protected $useTimestamps = 'false';
    protected $createdField = 'gradeCreatedDate';
    protected $updatedField = 'gradeModifiedDate';
    protected $returnType = 'object';
}
