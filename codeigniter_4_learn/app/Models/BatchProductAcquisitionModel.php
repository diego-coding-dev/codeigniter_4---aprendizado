<?php

namespace App\Models;

use CodeIgniter\Model;

class BatchProductAcquisitionModel extends Model {

    protected $DBGroup = 'default';
    protected $table = 'batch_product_acquisition';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'batch', 'total'
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
     * função que insere os dados dos lotes dos produtos da aquisição (por transaction)
     * @param int $productAcquisitionId id do produto da aquisição
     * @param array $batche dados dos lotes dos produtos
     * @return bool
     */
    public function add(int $productAcquisitionId, array $batche): bool {

        unset($batche['storage_id']);
        unset($batche['id_session']);

        $batche['products_acquisition_id'] = $productAcquisitionId;

        return $this->protect(false)->insert($batche);
    }
    
    /**
     * função que retorna a quantidade de lotes que um produto da aquisição possui
     * @param array $dataProductsAcquisition os produto da aquisição
     * @return array lista de quantidade de lotes do produto
     */
    public function getBatchQuantityByProductAcquisitionId(array $dataProductsAcquisition): array {

        $count = 0;
        $listBatchQuantity = array();
        
        foreach ($dataProductsAcquisition as $productAcquisition) {
            $listBatchQuantity[$count]['batchTotal'] = $this->setTable('batch_product_acquisition_view')->where('products_acquisition_id', $productAcquisition->id)->countAllResults();
            $listBatchQuantity[$count]['productAcquisitionId'] = $productAcquisition->id;
            $count++;
        }

        return $listBatchQuantity;
    }

}
