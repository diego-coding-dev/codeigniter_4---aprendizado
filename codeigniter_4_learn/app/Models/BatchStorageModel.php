<?php

namespace App\Models;

use CodeIgniter\Model;

class BatchStorageModel extends Model
{

    protected $DBGroup = 'default';
    protected $table = 'batch_storage';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
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
     * função que adiciona os lotes associados com o estoque (por transaction)
     * @param int $batchProductId id do do lote do produto
     * @param array $batch dados do lote
     * @return bool
     */
    public function add(int $batchProductId, array $batch): bool
    {

        unset($batch['batch']);
        unset($batch['id_session']);

        $batch['batch_product_acquisition_id'] = $batchProductId;

        return $this->protect(false)->insert($batch);
    }

    /**
     * função para retornar todos os lotes com base no storage_id dos produtos (são vários produtos a serem usados nessa função)
     * @param array $products array de App\Entities\StorageEntity
     */
    public function getBatchesByStorageId(array $products)
    {
        dd($products);
        $count = 0;

        $batchList = array();

        foreach ($products as $product) {

            $batchList[$count]['product'] = $product;
            $batchList[$count]['batches'] = $this->where('total >', 0)->where('storage_id', $product->id)->findAll();
            $count++;
        }

        dd($batchList);
    }
}
