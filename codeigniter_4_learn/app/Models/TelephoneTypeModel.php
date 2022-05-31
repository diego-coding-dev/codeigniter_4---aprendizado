<?php

namespace App\Models;

use CodeIgniter\Model;

class TelephoneTypeModel extends Model
{

    protected $DBGroup = 'default';
    protected $table = 'telephone_type';
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
     * função que seleciona os tipos de telefone para clientes
     * @return array array de \App\Models\TelephoneTypeModel
     */
    public function getTelephoneTypeClient()
    {

        return $this->where('deleted_at', null)->where('id', '1')->orWhere('id', '3')->findAll();
    }

    /**
     * função que seleciona os tipos de telefone para fornecedores
     * @return array array de \App\Models\TelephoneTypeModel
     */
    public function getTelephoneTypeProvider()
    {

        return $this->where('deleted_at', null)->where('id', '2')->orWhere('id', '3')->findAll();
    }

    /**
     * função que seleciona todos os tipos de telefone
     * @return array array de \App\Models\TelephoneTypeModel
     */
    public function getTelephoneType(): array
    {

        return $this->setTable('telefone_type_view')->findAll();
    }
}
