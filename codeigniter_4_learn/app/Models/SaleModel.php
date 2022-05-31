<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model {

    protected $DBGroup = 'default';
    protected $table = 'sales';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'App\Entities\SaleEntity';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'operation_value', 'document_number'
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
     * função para registra uma venda no sistema
     * @param array $dataDB dados da venda
     * @return bool
     */
    public function addSale(array $dataDB): bool {

        $productSaleModel = \Config\Services::modelService('ProductSaleModel');
        $batchProductSale = \Config\Services::modelService('BatchProductSaleModel');
        $storageModel = \Config\Services::modelService('StorageModel');

        $this->transStart();

        $this->protect(false)->insert($dataDB['additionalData']);

        foreach ($dataDB['products'] as $product) {

            $productSaleModel->addProductSale($this->getInsertID(), $product);

            $batchProductSale->addBatchProduct($productSaleModel->getInsertID(), $product);

            $storageModel->updateQuantityByTransaction($product['storage_id'], $product['total'], 'sub');
        }

        $this->transComplete();

        return $this->transStatus;
    }

    /**
     * função que retorna total de operações realizadas
     * @var object $builder
     * @return int total de operações
     */
    public function getTotalSales(): int {

        $builder = $this->builder('sales');

        return $builder->where('operation_type', 1)->countAll();
    }
}
