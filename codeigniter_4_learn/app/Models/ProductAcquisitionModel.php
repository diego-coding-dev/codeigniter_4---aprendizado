<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductAcquisitionModel extends Model
{

    protected $DBGroup = 'default';
    protected $table = 'products_acquisitions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'total'
    ];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * função que insere produtos da aquisição (por transaction)
     * @param int $acquisitionId id da nova aquisição
     * @param array $dataProducts dados com os produtos da aquisição
     * @return bool
     */
    public function add(int $acquisitionId, array $dataProduct): bool
    {

        unset($dataProduct['corporate_name']);
        unset($dataProduct['description']);
        unset($dataProduct['batches']);

        $dataProduct['acquisition_id'] = $acquisitionId;

        return $this->protect(false)->insert($dataProduct);
    }
}
