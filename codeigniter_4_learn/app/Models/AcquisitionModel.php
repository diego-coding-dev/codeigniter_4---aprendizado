<?php

namespace App\Models;

use CodeIgniter\Model;

class AcquisitionModel extends Model {

    protected $DBGroup = 'default';
    protected $table = 'acquisitions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'App\Entities\StorageEntity';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'operation_value',
        'document_number'
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
     * função que registra uma aquisição no sistema (faz uso de transaction)
     * @param array $dataDB dados da aquisição vindos da sessão
     * @return bool
     */
    public function add(array $dataDB): bool {

        $productAcquisitionModel = \Config\Services::modelService('ProductAcquisitionModel');
        $batchProductAcquisitionModel = \Config\Services::modelService('BatchProductAcquisitionModel');
        $batchStorageModel = \Config\Services::modelService('BatchStorageModel');
        $storageModel = \Config\Services::modelService('StorageModel');

        $this->transStart();

        $this->protect(false)->insert($dataDB['additionalData']);

        foreach ($dataDB['productsAndBatches'] as $product) {

            $productAcquisitionModel->add($this->getInsertID(), $product);

            foreach ($product['batches'] as $batch) {

                $batchProductAcquisitionModel->add($productAcquisitionModel->getInsertID(), $batch);

                $batchStorageModel->add($batchProductAcquisitionModel->getInsertID(), $batch);

                $storageModel->updateQuantityByTransaction($batch['storage_id'], $batch['total'], 'sum');
            }
        }

        $this->transComplete();

        return $this->transStatus;
    }

    /**
     * função que retorna total de operações realizadas
     * @var object $builder
     * @return int total de operações
     */
    public function getTotalAcquisitions(): int {

        $builder = $this->builder('sales');

        return $builder->where('operation_type', 2)->countAll();
    }

}
