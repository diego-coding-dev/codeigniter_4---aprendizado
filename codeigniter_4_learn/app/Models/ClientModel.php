<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ClientModel extends Model {

    protected $DBGroup = 'default';
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'App\Entities\ClientEntity';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'first_name', 'last_name', 'address', 'address_complement', 'email', 'telephone_1', 'telephone_2'
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
     * função que registra um cliente no sistem
     * @param array $dataDB dados para realizar o cadastro
     * @return bool
     */
    public function addClient(array $dataDB): bool {

        $clientPhoneModel = \Config\Services::modelService('ClientPhoneModel');

        $this->transStart();

        $this->protect(false)->insert($dataDB['data_client']);

        $clientPhoneModel->addTelephone($this->getInsertID(), $dataDB['client_telephones']);

        $this->transComplete();

        return $this->transStatus;
    }

    /**
     * função que retorna total de clientes cadastrados
     * @var object $builder
     * @return int total de clientes
     */
    public function getTotalClients(): int {

        return $this->where('user_type_id', 1)->where('deleted_at', null)->countAllResults();
    }

    /**
     * retorna lista de clientes cadastrados
     * @return array lista de \App\Entities\ClientEntity
     */
    public function getClients(): array {

        return $this->setTable('clients_view')->where('user_type_id', 1)->where('deleted_at', null)->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * função que deleta o cliente (soft delete manualmente) do sistema
     * @param int $idClient id do cliente
     * @return bool
     */
    public function deleteClient(int $idClient): bool {
        
        $dataDB = [
            'deleted_at' => Time::now()->toDateTimeString() . '.000'
        ];

        $db = db_connect();

        return $db->table($this->table)->where('id', $idClient)->update($dataDB);
    }

}
