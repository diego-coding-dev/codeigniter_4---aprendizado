<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ProviderPhoneModel extends Model {

    protected $DBGroup = 'default';
    protected $table = 'providers_phone';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'telephone'
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
     * função que insere os telefones do fornecedor (via transaction em "ProviderModel")
     * @param int $providerId id do fornecedor
     * @param array $dataDB array com os telefones do fornecedor
     * @return bool
     */
    public function addTelephone(int $providerId, array $dataDB) {
        
        foreach ($dataDB as $telephone) {
            
            unset($telephone['telephone_type']);
            unset($telephone['id_session']);
            unset($telephone['telephone_description']);
            
            $telephone['provider_id'] = $providerId;
            
            $this->protect(false)->insert($telephone);
        }
        
        return true;
    }
    
    /**
     * função para adicionar novo telefone para o fornecedor
     * @param int $providerId id do fornecedor
     * @param array $dataDB dados para serem atualizados
     * @return bool
     */
    public function addNewTelephone(int $providerId, array $dataDB) {

        $telephoneType = explode('-', $dataDB['telephone_type']);
        $dataDB['telephone_type_id'] = $telephoneType[0];
        $dataDB['provider_id'] = $providerId;

        unset($dataDB['telephone_type']);

        return $this->protect(false)->insert($dataDB);
    }
    
    /**
     * função para remover um telefone do fornecedor
     * @param int $telephoneId id do telefone do fornecedor
     * @return bool
     */
    public function excludeTelephone(int $telephoneId) {

        $dataDB = [
            'deleted_at' => Time::now()->toDateTimeString() . '.000'
        ];

        $db = db_connect();

        return $db->table($this->table)->where('id', $telephoneId)->update($dataDB);
    }
}
