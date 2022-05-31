<?php

namespace App\Controllers\Restrict;

use App\Controllers\BaseController;

class EmployeeController extends BaseController {

    private $employeeModel;
    private $validation;
    private $employeeValidation;
    private $employeeService;

    public function __construct() {

        $this->employeeModel = \Config\Services::modelService('EmployeeModel');
        $this->validation = \Config\Services::validation();
        $this->employeeValidation = \Config\Services::validationService('EmployeeValidation');
        $this->employeeService = \Config\Services::sessionService('SessionEmployee');
    }

    /**
     * função que exibe tela com dados do funcionario
     * @return string Restrict/Employee/list
     */
    public function list(): string {

        $this->employeeService->emptyEmployeeSession(null, false);

        $dataView = [
            'title' => 'Lista de funcionarios | Loja SA',
            'employeesList' => $this->employeeModel->getEmployees(),
            'pager' => $this->employeeModel->pager
        ];

        return view('Restrict/Employee/list', $dataView);
    }

    /**
     * função que exibe tela com dados do funcionario
     * @param int id do funcionario
     * @return string Restrict/Employee/show
     */
    public function show($id = null): string {

        $this->employeeService->emptyEmployeeSession(substr(previous_url(), strlen(site_url())));

        $employeePhoneModel = \Config\Services::modelService('EmployeePhoneModel');

        $dataEmployee = $this->checkEmployeeExists($id);

        $dataView = [
            'title' => 'Exibindo informações | Loja SA',
            'employee' => $dataEmployee,
            'telephonesEmployee' => $employeePhoneModel->setTable('employee_telephones_view')->where('deleted_at', null)->where('employee_id', $id)->findAll()
        ];

        $this->employeeService->addEmployee($dataEmployee);

        return view('Restrict/Employee/show', $dataView);
    }

    /**
     * função que exibe tela para atualizar registro do funcionario
     * @return string Restrict/Client/edit
     */
    public function edit(): string {

        $this->employeeService->emptyEmployeeSession(substr(previous_url(), strlen(site_url())));

        $telephoneTypeModel = \Config\Services::modelService('TelephoneTypeModel');
        $employeePhoneModel = \Config\Services::modelService('EmployeePhoneModel');

        $employeeId = $this->employeeService->getEmployee(true);

        $dataView = [
            'title' => 'Atualizando informações | Loja SA',
            'employee' => $this->checkEmployeeExists($employeeId),
            'telephoneTypeList' => $telephoneTypeModel->getTelephoneTypeClient(),
            'telephoneList' => $employeePhoneModel->setTable('employee_telephones_view')->where('deleted_at', null)->where('employee_id', $employeeId)->findAll(),
        ];

        return view('Restrict/Employee/edit', $dataView);
    }

    /**
     * função que atualiza dados do funcionario
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function update(): object {

        $employeeId = $this->employeeService->getEmployee(true);
        $dataDB = $this->employeeValidation->checkEmptyFields($this->request->getPost());

        if (empty($dataDB)) {

            return redirect()->to("privado/funcionarios/editar/mostrar/$employeeId")->with('info', 'Não há dados para atualizar.');
        }

        $this->validation->setRules($this->employeeValidation->selectRulesToValid($dataDB), $this->employeeValidation->getRulesErrors());

        if ($this->validation->run($dataDB)) {

            if ($this->clientModel->update($employeeId, $dataDB)) {

                return redirect()->to("privado/funcionarios/editar/mostrar/$employeeId")->with('success', 'Dados atualizados com sucesso.');
            } else {

                return redirect()->to("privado/funcionarios/editar/mostrar/$employeeId")->with('danger', 'Não foi possível realizar esta operaçã, tente mais tarde.');
            }
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função para excluir um telefone do funcionario
     * @param int $telephoneId telefone do funcionario
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function excludeTelephone(int $telephoneId) {

        $employeePhoneModel = \Config\Services::modelService('EmployeePhoneModel');

        $this->checkTelephoneEmployeeExists($telephoneId);

        if ($employeePhoneModel->excludeTelephone($telephoneId)) {

            return redirect()->to('privado/funcionarios/editar')->with('success', 'Telefone removido com sucesso');
        } else {

            return redirect()->back()->with('warning', 'Operação temporáriamente indisponível, tente mais tarde.');
        }
    }

    /**
     * função que exibe tela para confirmar desativação do funcionario
     * @return string Restric/Employee/edit
     */
    public function deactive(): string {

        $this->employeeService->emptyEmployeeSession(substr(previous_url(), strlen(site_url())));

        $dataView = [
            'title' => 'Confirmar desativação | Lojas SA',
            'ask' => 'Confirmar desativação?',
            'entity' => 'funcionarios',
            'action' => 'editar/confirmar_desativacao',
        ];

        return view('dialog/confirm', $dataView);
    }

    /**
     * função que exibe desativa cadastro do funcionário
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function confirmDeactive(): object {

        $employeeId = $this->employeeService->getEmployee(true);

        if ($this->employeeModel->builder()->where('id', $employeeId)->update(['is_active' => false])) {

            return redirect()->to("privado/funcionarios/editar/mostrar/$employeeId")->with('success', 'Esta conta foi desativada com sucesso.');
        }

        return redirect()->to("privado/funcionarios/editar/mostrar/$employeeId")->with('info', 'Operação indisponível, tende mais tarde.');
    }

    /**
     * função que exibe ativa cadastro do funcionário
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
//    public function active(): object {
//
//        $employeeId = $this->employeeService->getEmployee(true);
//
//        if ($this->employeeModel->builder()->where('id', $employeeId)->update(['is_active' => true])) {
//
//            return redirect()->to("privado/funcionarios/editar/mostrar/$employeeId")->with('success', 'Esta conta foi ativada com sucesso.');
//        }
//
//        return redirect()->to("privado/funcionarios/editar/mostrar/$employeeId")->with('info', 'Operação indisponível, tende mais tarde.');
//    }

    /**
     * função que exibe tela para cadastrar um novo funcionario
     * @return string Restrict/Employee/add
     */
    public function add(): string {

        $this->employeeService->emptyEmployeeSession(substr(previous_url(), strlen(site_url())));

        $telephoneTypeModel = \Config\Services::modelService('TelephoneTypeModel');

        $dataView = [
            'title' => 'Adicionando novo funcionario | Loja SA',
            'telephoneTypeList' => $telephoneTypeModel->getTelephoneType(),
            'telephoneList' => $this->employeeService->getTelephones()
        ];

        return view('Restrict/Employee/add', $dataView);
    }

    /**
     * função que adiciona telefone do funcionario na sessão para cadastro
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function addTelephone(): object {

        $dataPost = $this->request->getPost();

        $this->validation->setRules($this->employeeValidation->selectRulesToValid($dataPost), $this->employeeValidation->getRulesErrors());

        if ($this->validation->run($dataPost)) {

            $this->employeeService->addTelephone($dataPost);

            return redirect()->back();
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função que remove o telefone do funcionario da sessão
     * @param string $telephone telefone do funcionario
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function removeTelephone($telephone): object {

        $this->employeeService->removeTelephone($telephone);

        return redirect()->back();
    }

    /**
     * função para registrar funcionario no sistema
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function insert(): object {

        $employeeEmail = \Config\Services::emailService('EmailEmployee');

        $dataDB['data_employee'] = $this->request->getPost();

        $this->validation->setRules($this->employeeValidation->selectRulesToValid($dataDB['data_employee']), $this->employeeValidation->getRulesErrors());

        if ($this->validation->run($dataDB['data_employee'])) {

            if (count($this->employeeService->getTelephones()) < 1) {

                return redirect()->back()->with('restrict_info', 'Por favor, adicione um telefone.');
            }

            $dataDB['employee_telephones'] = $this->employeeService->getTelephones();

            if (!$dataDB['data_employee'] = $employeeEmail->sendActivationToken($dataDB['data_employee'])) {

                return redirect()->to('privado/funcionarios/listar')->with('danger', 'Não foi possível realizar esta operação, tente mais tarde.');
            }

            if ($this->employeeModel->addEmployee($dataDB)) {

                return redirect()->to('privado/funcionarios/editar/mostrar/' . $this->employeeModel->getInsertID())->with('success', 'Funcionário registrado com sucesso.');
            } else {

                return redirect()->to('privado/funcionarios/listar')->with('danger', 'Não foi possível realizar esta operação, tente mais tarde.');
            }
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função para adicionar novo telefone de um funcionario existente
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function addNewTelephone() {

        $employeePhoneModel = \Config\Services::modelService('EmployeePhoneModel');

        $dataDB = $this->request->getPost();

        $this->validation->setRules($this->employeeValidation->selectRulesToValid($dataDB), $this->employeeValidation->getRulesErrors());

        if ($this->validation->run($dataDB)) {

            if ($employeePhoneModel->addNewTelephone($this->employeeService->getEmployee(true), $dataDB)) {

                return redirect()->to('privado/funcionarios/editar')->with('success', 'Telefone adicionado com sucesso.');
            } else {

                return redirect()->to('privado/funcionarios/editar')->with('warning', 'Operação indisponível, tente mais tarde.');
            }
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função que exibe tela para confirmar exclusão
     * @param int id do funcionario
     * @return string dialog/confirm
     */
    public function delete($id = null): string {

        $this->employeeService->emptyEmployeeSession(substr(previous_url(), strlen(site_url())));

        $dataEmployee = $this->checkEmployeeExists($id);

        $dataView = [
            'title' => 'Confirmar exclusão | Lojas SA',
            'ask' => 'Confirmar exclusão?',
            'entity' => 'funcionarios',
            'action' => 'confirmar_exclusao',
            'id' => $dataEmployee->id
        ];

        return view('dialog/confirm', $dataView);
    }

    /**
     * função para excluir funcionario do sistema
     * @param int id do funcionario
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function confirmDelete($id = null): object {

        $dataEmployee = $this->checkEmployeeExists($id);

        if ($this->employeeModel->deleteEmployee($dataEmployee->id)) {

            return redirect()->to('privado/funcionarios/listar')->with('success', 'Funcionario excuído com sucesso.');
        }

        return redirect()->to('privado/funcionarios/listar')->with('danger', 'Operação não realizada com sucesso.');
    }

    /**
     * função para deslogar do sistema
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout(): object {

        $employeeAuth = \Config\Services::authService('AuthEmployee');

        $employeeAuth->logout();

        return redirect()->to('publico/autenticacao')->with('info', 'Até a próxima.');
    }

    /**
     * DESATIVADO
     * função que exibe a tela para alterar credênciais, apenas se for o primeiro login
     * @return string Restrict/Employee/changeCredentials 
     */
//    public function changeCredential(): string {
//
//        $employeeId = session('id');
//
//        $this->checkEmployeeExists($employeeId);
//
//        $dataView = [
//            'title' => 'Alterando credênciais | Loja SA',
//            'employeeId' => $employeeId
//        ];
//
//        return view('Restrict/Employee/changeCredentials', $dataView);
//    }

    /**
     * função que atualiza a credencial do funcionário
     * @param string $id id do funcionário
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function updateCredential(string $token = null) {

        $login = \Config\Services::authService('AuthEmployee');

        $employee = $this->employeeModel->getEmployeeByActivationToken($token);
        $dataDB = $this->request->getPost();

        $this->validation->setRules($this->employeeValidation->selectRulesToValid($dataDB), $this->employeeValidation->getRulesErrors());

        if ($this->validation->run($dataDB)) {

            $employee->prepareCredential($dataDB);

            if ($this->employeeModel->updateById($employee)) {

                $login->authenticate(['username' => $employee->e_username, 'password_hash' => $employee->e_password]);

                return redirect()->to('privado/principal')->with('success', 'Bem vindo ' . esc($employee->first_name) . ' ' . esc($employee->last_name));
            } else {

                return redirect()->back()->with('error_validation', 'Operação indiponível, tente mais tarde.');
            }
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função para ativa a conta do funcionário
     * @param string|object $activationToken toke de ativação da conta
     * @return object
     */
    public function checkTokenActivation(string $activationToken = null): string|object {

        $dataEmployee = $this->employeeModel->getEmployeeByActivationToken($activationToken);

        if ($dataEmployee) {

            $dataView = [
                'title' => 'Registrando credencial | Loja SA',
                'token' => $activationToken
            ];

            return view('Restrict/Employee/defineCredential', $dataView);
        }

        return redirect()->to('publico/autenticacao')->with('warning', 'Dados inválidos ou expirados.');
    }

    /**
     * função que faz a checagem para constatar a existência do funcionario no sistema
     * @param int $id id do funcionario
     * @return object App\Entities\UserEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkEmployeeExists(int $id): object {

        if ($id && $employeeData = $this->employeeModel->find($id)) {

            return $employeeData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função que faz a checagem para constatar a existência do telefone do funcionario no sistema
     * @param int $id id do funcionario
     * @return object|string  \App\Models\EmployeePhoneModel | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkTelephoneEmployeeExists(int $id): object {

        $employeePhoneModel = \Config\Services::modelService('EmployeePhoneModel');

        if ($id && $telephoneData = $employeePhoneModel->setTable('employee_telephones_view')->where('deleted_at', null)->find($id)) {

            return $telephoneData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

}
