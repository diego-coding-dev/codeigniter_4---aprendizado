<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductSaleModel extends Model {

    protected $DBGroup = 'default';
    protected $table = 'products_sale';
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
     * função para adicionar os produtos da venda (por transaction em SaleModel)
     * @param int $saleId id da nova venda
     * @param array $product dados dos produtos da venda
     * @return bool
     */
    function addProductSale(int $saleId, array $product): bool {

        unset($product['session_id']);
        unset($product['product']);

        $product['sale_id'] = $saleId;

        return $this->protect(false)->insert($product);
    }

}
