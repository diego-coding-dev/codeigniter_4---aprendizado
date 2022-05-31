<?php

namespace App\Libraries\Session;

class SessionEmployee {

    private $session;

    const DATA_EMPLOYEE = 'dataEmployee_employee';
    const DATA_TELEPHONE_EMPLOYEE = 'dataTelephone_employee';

    public function __construct() {

        $this->employeeData = 'dataEmployee_employee';
        $this->employeePhone = 'dataTelephone_employee';
        $this->session = session();
    }

    /**
     * função para adicionar dados do funcionario na sesão
     * @param object App\Entities\EmployeeEntity dados do funcionario
     * @return bool
     */
    public function addEmployee(object $employeeData): bool {

        $dataSession = [
            'employee_id' => $employeeData->id,
            'user_type_id' => $employeeData->user_type_id,
            'activation_hash' => $employeeData->activation_hash,
            'is_first_login' => $employeeData->is_first_login
        ];

        $this->session->set(self::DATA_EMPLOYEE, $dataSession);

        return true;
    }

    /**
     * função para retornar todos os dados do funcionario na sessão
     * @param bool $onlyId somente obter o id do funcionario
     * @return int|array soment o id do funcionario | dados do funcionario
     */
    public function getEmployee($onlyId = false): int|array {

        if ($onlyId) {

            return $this->session->get(self::DATA_EMPLOYEE . '.employee_id');
        }

        return $this->session->get(self::DATA_EMPLOYEE);
    }

    /**
     * função que adiciona telefone do funcionario na sessão
     * @param array $telephone dados do telefone do funcionario
     * @return bool
     */
    public function addTelephone(array $telephone): bool {

        if ($this->session->has(self::DATA_TELEPHONE_EMPLOYEE)) {

            if ($this->existsTelephoneInSession($telephone)) {

                return false;
            }

            $this->session->push(self::DATA_TELEPHONE_EMPLOYEE, $this->makeDataTelephone($telephone));
        } else {

            $this->session->set(self::DATA_TELEPHONE_EMPLOYEE, $this->makeDataTelephone($telephone));
        }

        return true;
    }

    /**
     * função que prepara os dados do telefone para a seesão
     * @param array $telephone dados do telefone
     * @return array dados da sessão
     */
    private function makeDataTelephone($telephone) {

        $time = new \CodeIgniter\I18n\Time;

        $telephone['id_session'] = 'telephone-' . $time->getTimestamp();
        $telephoneDataSplit = explode('-', $telephone['telephone_type']);
        $telephone['telephone_type_id'] = $telephoneDataSplit[0];
        $telephone['telephone_description'] = $telephoneDataSplit[1];

        $dataSession = [
            $telephone
        ];

        return $dataSession;
    }

    /**
     * função que verifica se os telefone já existe na sessão
     * @param array $dataTelephone telefone a ser inserido na sessão para cadastrar novo funcionario
     * @return bool
     */
    private function existsTelephoneInSession(array $dataTelephone): bool {

        $telephoneList = $this->getTelephones();

        foreach ($telephoneList as $telephone) {

            if ($telephone['telephone'] == $dataTelephone['telephone']) {

                return true;
            }
        }

        return false;
    }

    /**
     * função que devolve todos os telefones do funcionario da sessão
     * @return null|array telefones do funcionario
     */
    public function getTelephones(): null|array {

        return $this->session->get(self::DATA_TELEPHONE_EMPLOYEE);
    }

    /**
     * função que exclui telefone da sessão
     * @param string $idSession id de sessão do funcionario
     * @return bool
     */
    public function removeTelephone($idSession) {

        $telephoneList = $this->getTelephones();

        foreach ($telephoneList as $key => $telephone) {

            if ($telephone['id_session'] == $idSession) {

                unset($telephoneList[$key]);
            }
        }

        return $this->reinsertTelephone($telephoneList);
    }

    /**
     * função que reinsere dados do telefone na sessão (atualização)
     * @param array $telephoneList telefones do funcionario
     * @return bool
     */
    private function reinsertTelephone($telephoneList): bool {

        $this->session->set(self::DATA_TELEPHONE_EMPLOYEE, $telephoneList);

        return true;
    }

    /**
     * função para apagar a sessão de cliente
     * @param string $prevURL URL anterior acessada
     * @param bool $checkURL aplicar a operação com checagem de URL
     * @return bool
     */
    public function emptyEmployeeSession(string $prevURL = null, bool $checkURL = true): bool {

        if ($checkURL) {

            $slicedURL = explode('/', $prevURL);
            if ($slicedURL[1] != 'funcionarios') {

                $this->session->remove([
                    self::DATA_EMPLOYEE,
                    self::DATA_TELEPHONE_EMPLOYEE
                ]);
            }
        } else {

            $this->session->remove([
                self::DATA_EMPLOYEE,
                self::DATA_TELEPHONE_EMPLOYEE
            ]);
        }

        return true;
    }

}
