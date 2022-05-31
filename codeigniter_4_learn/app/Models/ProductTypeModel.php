<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductTypeModel extends Model
{

    protected $DBGroup = 'default';
    protected $table = 'products_type';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
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
     * função que retorna todos os tipos de produtos
     * @param string $productType nome do tipo de produto
     * @return array lista de \App\Models\ProductTypeModel
     */
    public function getAllProductsTypeToList(string $productType): array
    {

        if ($productType === 'todos' || !$productType) {

            return $this->where('deleted_at', null)->paginate(10);
        }

        return $this->where('deleted_at', null)->like('description', str_replace('-', ' ', $productType), 'both')->paginate(10);
    }
}
