<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ClientPhoneModel extends Model {

    protected $DBGroup = 'default';
    protected $table = 'clients_phone';
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
     * função para registrar os telefones do cliente (usado em transaction com o 'ClientModel')
     * @param int $clientId id do cliente
     * @param array $dataDB array com os telefones do cliente
     * @return bool
     */
    public function addTelephone(int $clientId, array $dataDB): bool {

        foreach ($dataDB as $telephone) {

            unset($telephone['telephone_type']);
            unset($telephone['id_session']);
            unset($telephone['telephone_description']);

            $telephone['client_id'] = $clientId;

            $this->protect(false)->insert($telephone);
        }

        return true;
    }

    /**
     * função para adicionar novo telefone para o cliente
     * @param int $clientId id do cliente
     * @param array $dataDB dados para serem atualizados
     * @return bool
     */
    public function addNewTelephone(int $clientId, array $dataDB) {

        $telephoneType = explode('-', $dataDB['telephone_type']);
        $dataDB['telephone_type_id'] = $telephoneType[0];
        $dataDB['client_id'] = $clientId;

        unset($dataDB['telephone_type']);

        return $this->protect(false)->insert($dataDB);
    }

    /**
     * função para remover um telefone do cliente
     * @param int $telephoneId id do telefone do cliente
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
