<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class EmployeeModel extends Model {

    private const EMPLOYEE_VIEW = 'employees_view ';
    private const TOKEN_TIME_EXPIRED = '2:00:00';

    protected $DBGroup = 'default';
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'App\Entities\EmployeeEntity';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'first_name', 'last_name', 'address', 'address_complement', 'email', 'telephone_1', 'telephone_2', 'username', 'activation_hash', 'expired_hash_in'
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
     * função para adicionar novo funcionario
     * @param array $dataDB dados do funcionário
     * @return bool
     */
    public function addEmployee(array $dataDB) {

        $employeePhoneModel = \Config\Services::modelService('EmployeePhoneModel');

        $this->transStart();

        $this->insert($dataDB['data_employee']);

        $employeePhoneModel->addPhone($this->getInsertID(), $dataDB['employee_telephones']);

        $this->transComplete();

        return $this->transStatus;
    }

    /**
     * função para deletar a conta do funcionario (soft_delete)
     * @param int $employeeId id do funcionário
     * @return bool
     */
    public function deleteEmployee(int $employeeId): bool {

        $db = db_connect();
        $builder = $db->table($this->table);

        $dataDB = [
            'deleted_at' => Time::now()->toDateTimeString() . '.000'
        ];

        return $builder->where('id', $employeeId)->update($dataDB);
    }

    /**
     * função que retorna total de funcionários cadastrados
     * @var object $builder
     * @return int total de clientes
     */
    public function getTotalEmployees(): int {

        return $this->where('user_type_id', 3)->where('deleted_at', null)->countAllResults();
    }

    /**
     * retorna lista de funcionários cadastrados
     * @return array lista de \App\Entities\EmployeeEntity 
     */
    public function getEmployees(): array {

        return $this->setTable(self::EMPLOYEE_VIEW)->where('user_type_id', 3)->where('deleted_at', null)->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * função que atualiza dados por id
     * @param object $employeeData dados do funcionário
     * @return bool
     */
    public function updateById(object $employeeData): bool {

        $builder = $this->builder();

        return $builder
                        ->where('id', $employeeData->id)
                        ->set('is_active', true)
                        ->set('is_first_login', false)
                        ->set('password_hash', $employeeData->e_password_hash)
                        ->set('username', $employeeData->e_username)
                        ->set('expired_hash_in', null)
                        ->set('activation_hash', null)
                        ->update();
    }

    /**
     * função para pegar dados do funcionário pelo token de ativação
     * @param string $token token de ativação
     * @return object|null retorna objeto do tipo EmployeeEntity
     */
    public function getEmployeeByActivationToken(string $token): object|null {

        $token = \Config\Services::tokenService(null, $token);
        $time = \Config\Services::timeService(null, 'now');

        $currentData = $time->format('Y-m-d H:i:s');
        $token_hash = $token->getHash();

        return $this->select('*')
                        ->where('activation_hash', $token_hash)
                        ->where("TIMEDIFF(expired_hash_in, '$currentData') <=", self::TOKEN_TIME_EXPIRED)
                        ->first();
    }

}
