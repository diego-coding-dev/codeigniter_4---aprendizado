<?php

namespace App\Libraries\Auth;

use App\Entities\EmployeeEntity;

class AuthEmployee {

    private $employee;
    private $employeeModel;
    private $session;

    public function __construct() {

        $this->employeeModel = \Config\Services::modelService('EmployeeModel');
        $this->session = session();
    }

    /**
     * função que antentica o funcionário no sistema
     * @param array $dataDB dados vindos do post
     * @return object|string App\Entities\EmployeeEntity em caso de sucesso no login | string em caso de falha no login 
     */
    public function authenticate(array $dataDB): object|string {

        $this->employee = $this->employeeModel->where('username', $dataDB['username'])->first();

        if ($this->employee == null) {

            return 'not_found';
        }

        if (!$this->employee->checkPassword($dataDB['password_hash'])) {

            return 'wrong_password';
        }

        if ($this->employee->is_first_login) {

            $this->loginUser($this->employee);
            return 'first_login';
        }

        if (!$this->employee->is_active) {

            return 'not_active';
        }

        $this->loginUser($this->employee);

        return $this->employee;
    }

    /**
     * função que loga o funcionário no sistema
     * @param object EmployeeModel
     * @return void
     */
    private function loginUser(EmployeeEntity $employee) {

        $dataSession = [
            'id' => $employee->id,
            'type' => $employee->user_type_id,
            'is_active' => $employee->is_active,
            'is_first_login' => $employee->is_first_login,
            'name' => $employee->first_name . ' ' . $employee->last_name
        ];

        $this->session->regenerate();

        $this->session->set('employee_data_session', $dataSession);
    }

    /**
     * função que desloga o funcionário do sistema
     * @return void
     */
    public function logout() {

        $this->session = session();

        $this->session->destroy();
    }

    /**
     * função que verifica se o funcionário está logado
     * @return bool
     */
    public function isLogged(): bool {

        return $this->getEmployeeLogged() != null;
    }
    
    /**
     * função que busca os dados do funcionário logado
     * @return object|null \App\Entities\EmployeeEntity
     */
    public function getEmployeeLogged(): object|null {

        if ($this->employee == null) {

            return $this->employee = $this->getEmployeeSession();
        }

        return $this->employee;
    }

    /**
     * função que busca os dados do funcionário na sessão
     * @return object|null \App\Entities\EmployeeEntity
     */
    private function getEmployeeSession(): object|null {

        if (!$this->session->has('employee_data_session')) {

            return null;
        }

        $result = $this->employeeModel->find(session()->get('employee_data_session.id'));

        if ($result && $result->is_active) {

            return $result;
        } elseif ($result && $result->is_first_login) {

            return $result;
        }

        return null;
    }

}
