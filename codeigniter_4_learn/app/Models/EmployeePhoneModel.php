<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class EmployeePhoneModel extends Model {

    protected $DBGroup = 'default';
    protected $table = 'employees_phone';
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
     * função para adicionar o telefone do funcionário
     * @param int $employeeId id do funcionário
     * @param array $dataDB dados dos telefones do funcionário
     * @return bool
     */
    public function addPhone(int $employeeId, array $dataDB): bool
    {

        foreach ($dataDB as $telephone) {
            
            unset($telephone['telephone_type']);
            unset($telephone['id_session']);
            unset($telephone['telephone_description']);

            $telephone['employee_id'] = $employeeId;

            $this->protect(false)->insert($telephone);
        }

        return true;
    }

    /**
     * função para adicionar novo telefone para o funcionario
     * @param int $employeeId id do funcionario
     * @param array $dataDB dados para serem atualizados
     * @return bool
     */
    public function addNewTelephone(int $employeeId, array $dataDB) {

        $telephoneType = explode('-', $dataDB['telephone_type']);
        $dataDB['telephone_type_id'] = $telephoneType[0];
        $dataDB['employee_id'] = $employeeId;

        unset($dataDB['telephone_type']);

        return $this->protect(false)->insert($dataDB);
    }

    /**
     * função para remover um telefone do funcionario
     * @param int $telephoneId id do telefone do funcionario
     * @return bool
     */
    public function excludeTelephone(int $telephoneId) {

        $dataDB = [
            'deleted_at' => Time::now()->toDateTimeString() . '.000'
        ];

        $db = db_connect();
        $builder = $db->table($this->table);

        return $builder->where('id', $telephoneId)->update($dataDB);
    }
}
