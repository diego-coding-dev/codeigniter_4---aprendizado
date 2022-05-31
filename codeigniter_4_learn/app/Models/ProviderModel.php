<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ProviderModel extends Model {

    protected $DBGroup = 'default';
    protected $table = 'providers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'App\Entities\ProviderEntity';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'corporate_name', 'cnpj', 'contact', 'email', 'address', 'address_complement', 'telephone_1', 'telephone_2'
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
     * função para adicionar um fornecedor no sistema
     * @param array $dataDB dados do fornecedor
     * @return bool
     */
    public function addProvider(array $dataDB): bool {

        $providerPhoneModel = \Config\Services::modelService('ProviderPhoneModel');

        $this->transStart();

        $this->protect(false)->insert($dataDB['data_provider']);

        $providerPhoneModel->addTelephone($this->getInsertID(), $dataDB['provider_telephone']);

        $this->transComplete();

        return $this->transStatus;
    }

    /**
     * função para pegar todos os fornecedores ou somente pela razão social
     * @param string $provider razão social do fornecedor
     * @return array lista com todos os fornecedores
     */
    public function getAll(string $provider): array {

        if ($provider === 'todos' || !$provider) {

            return $this->setTable('providers_view')->where('deleted_at', null)->paginate(10);
        } else {

            return $this->setTable('providers_view')->where('deleted_at', null)->like('corporate_name', str_replace('-', ' ', $provider), 'both')->paginate();
        }
    }

    /**
     * função que retorna total de fornecedores cadastrados
     * @return int total de fornecedores
     */
    public function getTotalProviders(): int {
        
        $builder = $this->builder('providers');

        return $builder->countAll();
    }

    /**
     * função que deleta o fornecedor (soft delete manualmente) do sistema
     * @param int $idProvider id do fornecedor
     * @return bool
     */
    public function deleteProvider(int $idProvider): bool {
        
        $dataDB = [
            'deleted_at' => Time::now()->toDateTimeString() . '.000'
        ];

        $db = db_connect();

        return $db->table($this->table)->where('id', $idProvider)->update($dataDB);
    }

}
