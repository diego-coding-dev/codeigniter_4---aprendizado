<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LoginController extends BaseController {

    private $loginValidation;
    private $validation;
    private $employeeModel;

    public function __construct() {

        $this->validation = \Config\Services::validation();
        $this->loginValidation = \Config\Services::validationService('LoginValidation');
        $this->employeeModel = \Config\Services::modelService('EmployeeModel');
    }

    /**
     * função que exibe a tela para o usuário inserir suas credênciais
     * @return string 'Login/login
     */
    public function login() {

        $dataView = [
            'title' => 'Área restrita | Loja SA'
        ];

        return view('Login/login', $dataView);
    }

    /**
     * função que autentica o usuário no sistema
     * @return string redirect
     */
    public function authenticate() {

        $employeeAuth = \Config\Services::authService('AuthEmployee');

        $dataDB = $this->request->getPost();

        $this->validation->setRules($this->loginValidation->selectRulesToValid($dataDB), $this->loginValidation->getRulesErrors());

        if ($this->validation->run($dataDB)) {

            $resultLogin = $employeeAuth->authenticate($dataDB);
            if (is_string($resultLogin)) {

                return $this->responseLogin($resultLogin);
            }
            return redirect()->to('privado/principal')->with('login', 'Bem vindo ' . esc($resultLogin->first_name) . ' ' . esc($resultLogin->last_name));
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função que trata as respostas da authenticação quando falha
     * @param array $responseLogin array com as respostas do processo de autenticação
     * @return string redirect
     */
    private function responseLogin($resultLogin) {

        // dd($resultLogin);
        switch ($resultLogin) {

            case 'not_found':

                return redirect()->back()->with('info', 'Suas credências são inválidas.');
                break;
            case 'not_active':

                return redirect()->back()->with('info', 'Seu usuário está desativado.');
                break;
            case 'first_login':

                return redirect()->to('privado/funcionarios/editar_credencial')->with('info', 'Por favor, atualize suas credênciais.');
                break;
            case 'wrong_password':

                return redirect()->back()->with('info', 'Suas credências são inválidas.');
                break;

            default:
                return redirect()->back()->with('info', 'Desculpe, serviços indiponível no momento, tente mais tarde.');
                break;
        }
    }

}
