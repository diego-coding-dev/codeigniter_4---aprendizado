<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model {

    protected $DBGroup = 'default';
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'App\Entities\ProductEntity';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'description'
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
     * função que insere o produto no sistem e o insere no estoque por transaction
     * @param array $dataProduct dados referente ao produto a ser cadastrado
     * @param array $dataStorage dados referente ao fornecedor
     * @return bool
     */
    public function addProduct(array $dataProduct): bool {

        $storageModel = new \App\Models\StorageModel;
        
        $this->transStart();
        
        $this->protect(false)->insert($dataProduct);
        
        $storageModel->addInStorage($this->getInsertID());
        
        $this->transComplete();
        
        return $this->transStatus;
    }

    /**
     * função que retorna total de produtos cadastrados
     * @param string $operationType
     * @var object $builder
     * @return int total de produtos
     */
    public function getTotalProducts(): int {

        $builder = $this->builder('products');

        return $builder->where('out_of_production', false)->where('deleted_at', null)->countAllResults();
    }

    /**
     * função que atualiza dados do produto
     * @param int $id id do produto
     * @param array $data dados enviandos para atualização
     * @return bool
     */
    public function updateById(int $id, array $dataDB): bool {

        $db = db_connect();

        return $db->table($this->table)->where('id', $id)->where('deleted_at', null)->update($dataDB);
    }

    /**
     * função que retorna todos os produtos em produção
     * @param string $product nome do produto
     * @return array lista de \App\Entitites\ProductEntity
     */
    public function getAllProductsToList(string $product = null): array {

        if ($product === 'todos' || !$product) {

            return $this->setTable('products_view')->where('out_of_production', false)->where('deleted_at', null)->paginate(10);
        }

        return $this->setTable('products_view')->where('out_of_production', false)->where('deleted_at', null)->like('description', $product, 'both')->paginate(10);
    }

    /**
     * função que retorna informações de um produto
     * @param int id do produto
     * @return object \App\Entities\ProductEntity
     */
    public function getProductById(int $id): object {

        return $this->setTable('products_view')->where('deleted_at', null)->find($id);
    }

    /**
     * função que retorna informações de um produto
     * @param int id da categoria do produto
     * @return object \App\Entities\ProductEntity
     */
    public function getProductsByCategory(int $id): object {

        return $this->setTable('products_view')->where('product_type_id', $id)->where('deleted_at', null)->findAll();
    }

    /**
     * função que deleta o produto (soft delete manualmente) do sistema
     * @param int $idProduct id do produto
     * @return bool
     */
    public function deleteProduct(int $idProduct): bool {

        $time = new \CodeIgniter\I18n\Time;

        $dataDB = [
            'deleted_at' => $time->now()->toDateTimeString() . '.000'
        ];

        $db = db_connect();

        return $db->table($this->table)->where('id', $idProduct)->update($dataDB);
    }

}
