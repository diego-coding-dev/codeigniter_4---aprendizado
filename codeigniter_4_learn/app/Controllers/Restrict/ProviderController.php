<?php

namespace App\Controllers\Restrict;

use App\Controllers\BaseController;
use App\Models\ProviderModel;
use App\Validation\ProviderValidation;

class ProviderController extends BaseController
{

    private $providerModel;
    private $providerValidation;
    private $validation;
    private $providerService;

    public function __construct()
    {

        $this->providerModel = \Config\Services::modelService('ProviderModel');
        $this->providerValidation = \Config\Services::validationService('ProviderValidation');
        $this->validation = \Config\Services::validation();
        $this->providerService = \Config\Services::sessionService('SessionProvider');
    }

    /**
     * função que exibe tela com lista dos fornecedores cadastrados
     * @param string $provider nome do fornecedor
     * @return string Restrict/Provider/list
     */
    public function list(string $provider = null): string
    {

        $this->providerService->emptyProviderSession(null, false);

        $dataView = [
            'title' => 'Lista de fornecedores | Loja SA',
            'providersList' => $this->providerModel->getAll($provider),
            'pager' => $this->providerModel->pager,
            'indexSearch' => $provider == 'todos' ? null : $provider
        ];

        return view('Restrict/Provider/list', $dataView);
    }

    /**
     * função que busca o fornecedor pela descrição
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function searchProvider(): object
    {

        $providerValidation = \Config\Services::validationService('ProviderValidation');

        $dataSearch = $this->request->getPost();

        $this->validation->setRules($providerValidation->selectRulesToValid($dataSearch), $providerValidation->getRulesErrors());

        if (!$this->validation->run($dataSearch)) {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }

        return redirect()->to('privado/fornecedores/listar/' . str_replace(' ', '-', $dataSearch['corporate_name']));
    }

    /**
     * função que exibe tela com dados do fornecedor
     * @param int id do fornecedor
     * @return string Restrict/Provider/show
     */
    public function show($id = null): string
    {

        $this->providerService->emptyProviderSession(substr(previous_url(), strlen(site_url())));

        $providerPhoneModel = \Config\Services::modelService('ProviderPhoneModel');

        $dataView = [
            'title' => 'Exibindo informações | Loja SA',
            'provider' => $this->checkProviderExists($id),
            'telephones_provider' => $providerPhoneModel->setTable('provider_telephones_view')->where('deleted_at', null)->where('provider_id', $id)->findAll()
        ];

        $this->providerService->addProvider($id);

        return view('Restrict/Provider/show', $dataView);
    }

    /**
     * função que exibe tela para atualizar registro do fornecedor
     * @return string Restric/Provider/edit
     */
    public function edit(): string
    {

        $this->providerService->emptyProviderSession(substr(previous_url(), strlen(site_url())));

        $telephoneTypeModel = \Config\Services::modelService('TelephoneTypeModel');
        $providerPhoneModel = \Config\Services::modelService('ProviderPhoneModel');

        $providerId = $this->providerService->getProvider(true);

        $dataView = [
            'title' => 'Atualizando informações | Loja SA',
            'provider' => $this->checkProviderExists($providerId),
            'telephoneTypeList' => $telephoneTypeModel->getTelephoneTypeProvider(),
            'telephoneList' => $providerPhoneModel->setTable('provider_telephones_view')->where('deleted_at', null)->where('provider_id', $providerId)->findAll(),
        ];

        return view('Restrict/Provider/edit', $dataView);
    }

    /**
     * função que atualiza dados do fornecedor
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function update(): object
    {

        $providerId = $this->providerService->getProvider(true);
        $providerData = $this->checkProviderExists($providerId);
        $dataDB = $this->providerValidation->checkEmptyFields($this->request->getPost());

        if (empty($dataDB)) {

            return redirect()->to("privado/fornecedores/mostrar/$providerId")->with('info', 'Não há dados para atualizar.');
        }

        $this->validation->setRules($this->providerValidation->selectRulesToValid($dataDB), $this->providerValidation->getRulesErrors());

        if ($this->validation->run($dataDB)) {

            if ($this->providerModel->update($providerData->id, $dataDB)) {

                return redirect()->to("privado/fornecedores/mostrar/$providerId")->with('success', 'Dados atualizados com sucesso.');
            } else {

                return redirect()->to("privado/fornecedores/mostrar/$providerId")->with('danger', 'Não foi possível realizar esta operaçã, tente mais tarde.');
            }
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função para excluir um telefone do provider
     * @param int $telephoneId telefone do provider
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function excludeTelephone(int $telephoneId)
    {

        $providerPhoneModel = \Config\Services::modelService('ProviderPhoneModel');

        $this->checkTelephoneUserExists($telephoneId);

        if ($providerPhoneModel->excludeTelephone($telephoneId)) {

            return redirect()->to('privado/fornecedores/mostrar/' . $this->providerService->getProvider(true))->with('success', 'Telefone removido com sucesso');
        } else {

            return redirect()->back()->with('warning', 'Operação temporáriamente indisponível, tente mais tarde.');
        }
    }

    /**
     * função que exibe tela para cadastrar um novo fornecedor
     * @return string Restrict/Provider/add
     */
    public function add(): string
    {

        $this->providerService->emptyProviderSession(substr(previous_url(), strlen(site_url())));

        $telephoneTypeModel = \Config\Services::modelService('TelephoneTypeModel');

        $dataView = [
            'title' => 'Adicionando novo fornecedor | Loja SA',
            'telephoneTypeList' => $telephoneTypeModel->getTelephoneTypeProvider(),
            'telephoneList' => $this->providerService->getTelephones()
        ];

        return view('Restrict/Provider/add', $dataView);
    }

    /**
     * função cadastrar telefone do fornecedor na sessão
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function addTelephone()
    {

        $dataPost = $this->request->getPost();

        $this->validation->setRules($this->providerValidation->selectRulesToValid($dataPost), $this->providerValidation->getRulesErrors());

        if ($this->validation->run($dataPost)) {

            $this->providerService->addTelephone($dataPost);

            return redirect()->back();
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função que remove o telefone do fornecedor da sessão
     * @param string $telephone telefone do fornecedor
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function removeTelephone($telephone): object
    {

        $this->providerService->removeTelephone($telephone);

        return redirect()->back();
    }

    /**
     * função para registrar fornecedor no sistema
     * 
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function insert(): object
    {

        $dataDB['data_provider'] = $this->request->getPost();

        $this->validation->setRules($this->providerValidation->selectRulesToValid($dataDB['data_provider']), $this->providerValidation->getRulesErrors());

        if ($this->validation->run($dataDB['data_provider'])) {

            if (count($this->providerService->getTelephones()) < 1) {

                return redirect()->back()->with('restrict_info', 'Por favor, adicione um telefone.');
            }

            $dataDB['provider_telephone'] = $this->providerService->getTelephones();

            if ($this->providerModel->addProvider($dataDB)) {

                return redirect()->to('privado/fornecedores/editar/mostrar/' . $this->providerModel->getInsertID())->with('success', 'Fornecedor registrado com succeso.');
            } else {

                return redirect()->to("privado/fornecedores/listar")->with('danger', 'Não foi possível realizar esta operação, tente mais tarde.');
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

        $providerPhoneModel = \Config\Services::modelService('ProviderPhoneModel');

        $dataDB = $this->request->getPost();

        $this->validation->setRules($this->providerValidation->selectRulesToValid($dataDB), $this->providerValidation->getRulesErrors());

        if ($this->validation->run($dataDB)) {

            if ($providerPhoneModel->addNewTelephone($this->providerService->getProvider(true), $dataDB)) {

                return redirect()->to('privado/fornecedores/editar')->with('success', 'Telefone adicionado com sucesso.');
            } else {

                return redirect()->to('privado/fornecedores/editar')->with('warning', 'Operação indisponível, tente mais tarde.');
            }
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função que exibe tela para confirmar exclusão
     * @param int id do fornecedor
     * @return string dialog/confirm
     */
    public function exclude($id = null): string
    {

        $this->providerService->emptyProviderSession(substr(previous_url(), strlen(site_url())));

        $providerData = $this->checkProviderExists($id);

        $dataView = [
            'title' => 'Conformar exclusão | Lojas SA',
            'ask' => 'Confirmar exclusão?',
            'entity' => 'fornecedores',
            'action' => 'deletar',
            'id' => $providerData->id
        ];

        return view('dialog/confirm', $dataView);
    }

    /**
     * função para excluir fornecedor do sistema
     * @param int id do fornecedor
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id = null): object
    {

        $providerData = $this->checkProviderExists($id);

        if ($this->providerModel->deleteProvider($providerData->id)) {

            return redirect()->to('privado/fornecedores/listar')->with('success', 'Fornecedor excuído com sucesso.');
        }

        return redirect()->to('privado/fornecedores/listar')->with('danger', 'Operação não realizada com sucesso.');
    }

    /**
     * função que faz a checagem para constatar a existência do fornecedor no sistema
     * @param int $id id do fornecedor
     * @return object \App\Entities\ProviderEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkProviderExists(int $id): object
    {

        if ($id && $providerData = $this->providerModel->setTable('providers_view')->where('deleted_at', null)->find($id)) {

            return $providerData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função que faz a checagem para constatar a existência do telefone do fornecedor no sistema
     * @param int $id id do cliente
     * @return object|string  \App\Models\ProviderPhoneModel | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkTelephoneUserExists(int $id): object
    {

        $providerPhoneModel = \Config\Services::modelService('ProviderPhoneModel');

        if ($id && $telephoneData = $providerPhoneModel->setTable('provider_telephones_view')->where('deleted_at', null)->find($id)) {

            return $telephoneData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }
}
