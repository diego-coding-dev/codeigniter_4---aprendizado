<?php

namespace App\Controllers\Restrict;

use App\Controllers\BaseController;

class ClientController extends BaseController
{

    private $clientModel;
    private $validation;
    private $clientValidation;
    private $clientService;

    public function __construct()
    {

        $this->clientModel = \Config\Services::modelService('ClientModel');
        $this->validation = \Config\Services::validation();
        $this->clientValidation = \Config\Services::validationService('ClientValidation');
        $this->clientService = \Config\Services::sessionService('SessionClient');
    }

    /**
     * função que exibe tela com dados do cliente
     * @return string Restrict/Client/list
     */
    public function list(): string
    {

        $this->clientService->emptyClientSession(null, false);

        $dataView = [
            'title' => 'Lista de clientes | Loja SA',
            'clientsList' => $this->clientModel->getClients(),
            'pager' => $this->clientModel->pager
        ];

        return view('Restrict/Client/list', $dataView);
    }

    /**
     * função que exibe tela com dados do cliente
     * @param int id do cliente
     * @return string Restrict/Client/show
     */
    public function show($id = null): string
    {

        $this->clientService->emptyClientSession(substr(previous_url(), strlen(site_url())));

        $clienPhoneModel = \Config\Services::modelService('ClientPhoneModel');

        $dataView = [
            'title' => 'Exibindo informações | Loja SA',
            'client' => $this->checkUserExists($id),
            'telephones_client' => $clienPhoneModel->setTable('client_telephones_view')->where('deleted_at', null)->where('client_id', $id)->findAll()
        ];

        $this->clientService->addClient($id);

        return view('Restrict/Client/show', $dataView);
    }

    /**
     * função que exibe tela para atualizar registro do cliente
     * @return string Restrict/Client/edit
     */
    public function edit(): string
    {

        $this->clientService->emptyClientSession(substr(previous_url(), strlen(site_url())));

        $telephoneTypeModel = \Config\Services::modelService('TelephoneTypeModel');
        $clientPhoneModel = \Config\Services::modelService('ClientPhoneModel');

        $clientId = $this->clientService->getClient(true);

        $dataView = [
            'title' => 'Atualizando informações | Loja SA',
            'client' => $this->checkUserExists($clientId),
            'telephoneTypeList' => $telephoneTypeModel->getTelephoneTypeClient(),
            'telephoneList' => $clientPhoneModel->setTable('client_telephones_view')->where('deleted_at', null)->where('client_id', $clientId)->findAll(),
        ];

        return view('Restrict/Client/edit', $dataView);
    }

    /**
     * função que atualiza dados do cliente
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function update(): object
    {

        $clientId = $this->clientService->getClient(true);
        $dataDB = $this->clientValidation->checkEmptyFields($this->request->getPost());

        if (empty($dataDB)) {

            return redirect()->to("privado/clientes/editar/mostrar/$clientId")->with('info', 'Não há dados para atualizar.');
        }

        $this->validation->setRules($this->clientValidation->selectRulesToValid($dataDB), $this->clientValidation->getRulesErrors());

        if ($this->validation->run($dataDB)) {

            if ($this->clientModel->update($clientId, $dataDB)) {

                return redirect()->to("privado/clientes/editar/mostrar/$clientId")->with('success', 'Dados atualizados com sucesso.');
            } else {

                return redirect()->to("privado/clientes/editar/mostrar/$clientId")->with('danger', 'Não foi possível realizar esta operaçã, tente mais tarde.');
            }
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função para excluir um telefone do cliente
     * @param int $telephoneId telefone do cliente
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function excludeTelephone(int $telephoneId)
    {

        $clientPhoneModel = \Config\Services::modelService('ClientPhoneModel');

        $this->checkTelephoneClientExists($telephoneId);

        if ($clientPhoneModel->excludeTelephone($telephoneId)) {

            return redirect()->to('privado/clientes/editar')->with('success', 'Telefone removido com sucesso');
        } else {

            return redirect()->back()->with('warning', 'Operação temporáriamente indisponível, tente mais tarde.');
        }
    }

    /**
     * função que exibe tela para cadastrar um novo cliente
     * @return string Restrict/Client/add
     */
    public function add(): string
    {

        $this->clientService->emptyClientSession(substr(previous_url(), strlen(site_url())));

        $telephoneTypeModel = \Config\Services::modelService('TelephoneTypeModel');

        $dataView = [
            'title' => 'Adicionando novo cliente | Loja SA',
            'telephoneTypeList' => $telephoneTypeModel->getTelephoneTypeClient(),
            'telephoneList' => $this->clientService->getTelephones()
        ];

        return view('Restrict/Client/add', $dataView);
    }

    /**
     * função que adiciona telefone do cliente na sessão para cadastro
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function addTelephone(): object
    {

        $this->clientService->emptyClientSession(substr(previous_url(), strlen(site_url())));

        $dataPost = $this->request->getPost();

        $this->validation->setRules($this->clientValidation->selectRulesToValid($dataPost), $this->clientValidation->getRulesErrors());

        if ($this->validation->run($dataPost)) {

            $this->clientService->addTelephone($dataPost);
            return redirect()->back();
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função que remove o telefone do cliente da sessão
     * @param string $telephone telefone do cliente
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function removeTelephone($telephone): object
    {

        $this->clientService->removeTelephone($telephone);

        return redirect()->back();
    }

    /**
     * função para registrar cliente no sistema
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function insert(): object
    {

        $dataDB['data_client'] = $this->request->getPost();

        $this->validation->setRules($this->clientValidation->selectRulesToValid($dataDB['data_client']), $this->clientValidation->getRulesErrors());

        if ($this->validation->run($dataDB['data_client'])) {

            if (count($this->clientService->getTelephones()) < 1) {

                return redirect()->back()->with('restrict_info', 'Por favor, adicione um telefone.');
            }

            $dataDB['client_telephones'] = $this->clientService->getTelephones();

            if ($this->clientModel->addClient($dataDB)) {

                return redirect()->to('privado/clientes/editar/mostrar/' . $this->clientModel->getInsertID())->with('success', 'Cliente registrado com sucesso.');
            } else {

                return redirect()->to("privado/clientes/listar")->with('danger', 'Não foi possível realizar esta operação, tente mais tarde.');
            }
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função para adicionar novo telefone de um cliente existente
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function addNewTelephone()
    {

        $clientPhoneModel = \Config\Services::modelService('ClientPhoneModel');

        $dataDB = $this->request->getPost();

        $this->validation->setRules($this->clientValidation->selectRulesToValid($dataDB), $this->clientValidation->getRulesErrors());

        if ($this->validation->run($dataDB)) {

            if ($clientPhoneModel->addNewTelephone($this->clientService->getClient(true), $dataDB)) {

                return redirect()->to('privado/clientes/editar')->with('success', 'Telefone adicionado com sucesso.');
            } else {

                return redirect()->to('privado/clientes/editar')->with('warning', 'Operação indisponível, tente mais tarde.');
            }
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função que exibe tela para confirmar exclusão
     * @param int id do cliente
     * @return string dialog/confirm
     */
    public function exclude($id = null): string
    {

        $this->clientService->emptyClientSession(substr(previous_url(), strlen(site_url())));

        $dataUser = $this->checkUserExists($id);

        $dataView = [
            'title' => 'Conformar exclusão | Lojas SA',
            'ask' => 'Confirmar exclusão?',
            'entity' => 'clientes',
            'action' => 'deletar',
            'id' => $dataUser->id
        ];

        return view('dialog/confirm', $dataView);
    }

    /**
     * função para excluir cliente do sistema
     * @param int id do cliente
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id = null): object
    {

        $dataUser = $this->checkUserExists($id);

        if ($this->clientModel->deleteClient($dataUser->id)) {

            return redirect()->to('privado/clientes/listar')->with('success', 'CLiente excuído com sucesso.');
        }

        return redirect()->to('privado/clientes/listar')->with('danger', 'Operação não realizada com sucesso.');
    }

    /**
     * função que faz a checagem para constatar a existência do cliente no sistema
     * @param int $id id do cliente
     * @return object|string  \App\Entities\UserEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkUserExists(int $id): object
    {

        if ($id && $userData = $this->clientModel->where('deleted_at', null)->find($id)) {

            return $userData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função que faz a checagem para constatar a existência do telefone do cliente no sistema
     * @param int $id id do cliente
     * @return object|string  \App\Models\ClientPhoneModel | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkTelephoneClientExists(int $id): object
    {

        $clientPhoneModel = \Config\Services::modelService('ClientPhoneModel');

        if ($id && $telephoneData = $clientPhoneModel->setTable('client_telephones_view')->where('deleted_at', null)->find($id)) {

            return $telephoneData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }
}
