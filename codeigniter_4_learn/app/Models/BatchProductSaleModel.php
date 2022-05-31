<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;

class BatchProductSaleModel extends Model {

    private $date;
    protected $DBGroup = 'default';
    protected $table = 'batch_product_sale';
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
     * função para adicionar o lote do produto da venda, a quantidade depende da quantidade disponivel nos lotes de BatchStorageModel
     * @param int $productSaleId id do produto da venda
     * @param array $product dados do produto
     * return bool
     */
    public function addBatchProduct(int $productSaleId, array $product): bool {

        unset($product['session_id']);
        unset($product['product']);

        $batch = $this->getTotalInBatchByStorageId($product['storage_id']);

        if ($product['total'] <= $batch->total) {

            $batch->total = $batch->total - $product['total'];

            $this->protect(false)->insert([
                'product_sale_id' => $productSaleId,
                'batch_storage_id' => $batch->id,
                'total' => $product['total']
            ]);

            $this->updateTotalById($batch->id, $batch->total);
        } else {

            $product['total'] = $product['total'] - $batch->total;

            $this->protect(false)->insert([
                'product_sale_id' => $productSaleId,
                'batch_storage_id' => $batch->id,
                'total' => $batch->total
            ]);

            $batch->total = 0;

            $this->updateTotalById($batch->id, $batch->total);

            // recursividade até que a quantidade de produtos do pedido da venda seja menor ou igual a quantidade do lote, satisfaça a primeira condição do laço IF
            $this->addBatchProduct($productSaleId, $product);
        }

        return true;
    }

    /**
     * função para retornar a quantidade de produtos do lote mais antigo disponível, junto com seu id
     * @param int $storageId id do produto no estoque
     * @return object App\Models\BatchStorageModel
     */
    private function getTotalInBatchByStorageId(int $storageId): object {

        $batchStorageModel = new \App\Models\BatchStorageModel;

        return $batchStorageModel->select('min(id) id, total')
                        ->where('storage_id', $storageId)
                        ->where('total >', 0)
                        ->where('id', function ($builder) use ($storageId) {
                            return $builder->select('id')->where('storage_id', $storageId);
                        })
                        ->first();
    }

    /**
     * função para atualizar o total do lote pelo id, usado na transaction pelo SaleModel
     * @param int $batchId id do lote
     * @param int $total total a ser atualizado
     * @return bool
     */
    private function updateTotalById(int $batchId, int $total): bool {

        $db = db_connect();

        return $db->table('batch_storage')->where('id', $batchId)->update(['total' => $total]);
    }
    
    /**
     * função que retorna a quantidade de lotes que um produto da venda possui
     * @param array $dataProductsSale os produto da aquisição
     * @return array lista de quantidade de lotes do produto
     */
    public function getBatchQuantityByProductSaleId(array $dataProductsSale): array {

        $count = 0;
        $listBatchQuantity = array();
        
        foreach ($dataProductsSale as $productSale) {
            $listBatchQuantity[$count]['batchTotal'] = $this->setTable('batch_product_sale_view')->where('product_sale_id', $productSale->id)->countAllResults();
            $listBatchQuantity[$count]['productSaleId'] = $productSale->id;
            $count++;
        }

        return $listBatchQuantity;
    }

}
