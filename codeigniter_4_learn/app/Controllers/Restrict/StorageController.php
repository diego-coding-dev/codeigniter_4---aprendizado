<?php

namespace App\Controllers\Restrict;

use App\Controllers\BaseController;

class StorageController extends BaseController
{

    private $storageModel;
    private $validation;
    private $sessionStorage;

    public function __construct()
    {

        $this->storageModel = \Config\Services::modelService('StorageModel');
        $this->validation = \Config\Services::validation();
        $this->sessionStorage = \Config\Services::sessionService('SessionStorage');
    }

    /**
     * função que mostra lista de produtos do estoque
     * @param string $storage produto do estoque
     * @return string Restrict/Storage/list
     */
    public function list(string $storage): string
    {

        $this->sessionStorage->emptyStorageSession(null, false);

        $dataStorage = $this->storageModel->getDistinctAll($storage);
        $pager = $this->storageModel->pager;

        $dataView = [
            'title' => 'Estoque de produtos | Loja SA',
            'storageProducts' => $dataStorage,
            'pager' => $pager
        ];

        return view('Restrict/Storage/list', $dataView);
    }

    /**
     * função que procura os itens do estoque pela descrição
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function searchStorage()
    {

        $productValidation = \Config\Services::validationService('ProductValidation');
        $dataSearch = $this->request->getPost();

        $this->validation->setRules($productValidation->selectRulesToValid($dataSearch), $productValidation->getRulesErrors());

        if (!$this->validation->run($dataSearch)) {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }

        return redirect()->to('privado/estoque/listar/' . str_replace(' ', '-', $dataSearch['description']));
    }

    /**
     * função que exibe tela com dados do produto no estoque (não importa os fornecedores)
     * @param int $productId id do produto no estoque
     * @return string Restrict/Storage/show
     */
    public function show(int $productId = null): string
    {

        $this->sessionStorage->emptyStorageSession(substr(previous_url(), strlen(site_url())));

        $dataProduct = $this->checkStorageExists($productId);

        $this->sessionStorage->addProduct($dataProduct);

        $dataView = [
            'title' => 'Exibindo informações | Loja SA',
            'product' => $dataProduct,
            'totalProduct' => $this->storageModel->getTotalProducts($dataProduct),
            'linkActive' => '1',
            'productId' => $productId
        ];

        return view('Restrict/Storage/show', $dataView);
    }

    /**
     * função para mostrar os lotes do produto no estoque
     * @return string Restrict/Storage/showBatches
     */
    public function showBatches(): string
    {

        $this->sessionStorage->emptyStorageSession(substr(previous_url(), strlen(site_url())));

        $batchStorageModel = \Config\Services::modelService('BatchStorageModel');

        $storageData = $this->sessionStorage->getProduct();

        $dataView = [
            'title' => 'Exibindo informações | Loja SA',
            'batches' => $batchStorageModel->setTable('batch_storage_product_acquisition')->where('storage_id', $storageData['storage_id'])->findAll(),
            'productId' => $storageData['product_id'],
            'linkActive' => '2'
        ];

        return view('Restrict/Storage/showBatches', $dataView);
    }

    /**
     * função para exibir a tela para atualizar dados do produto no estoque
     * return string Restrict/Storage/edit
     */
    public function edit(): string
    {

        $this->sessionStorage->emptyStorageSession(substr(previous_url(), strlen(site_url())));

        $storageData = $this->sessionStorage->getProduct();
        $dataProduct = $this->checkStorageExists($storageData['product_id']);

        $dataView = [
            'title' => 'Exibindo informações | Loja SA',
            'storage' => $dataProduct,
            'productId' => $storageData['product_id'],
            'linkActive' => '3'
        ];

        return view('Restrict/Storage/edit', $dataView);
    }

    /**
     * função para atualizar dados do produto no estoque
     * @return object \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function update(): object
    {

        $this->sessionStorage->emptyStorageSession(substr(previous_url(), strlen(site_url())));

        $storageValidation = \Config\Services::validationService('StorageValidation');

        $dataDB = $storageValidation->checkEmptyFields($this->request->getPost());

        if (count($dataDB) < 1) {

            return redirect()->back()->with('info', 'Não há dados para atualizar.');
        }

        $this->validation->setRules($storageValidation->selectRulesToValid($dataDB), $storageValidation->getRulesErrors());

        if ($this->validation->run($dataDB)) {

            if ($this->storageModel->updateStorage($this->sessionStorage->getProduct(true), $dataDB)) {

                return redirect()->back()->with('success', 'Dados atualizados com sucesso.');
            }

            return redirect()->back()->with('warning', 'Operação temporáriamente indisponível, tente mais tarde.');
        } else {

            return redirect()->back()->with('info', $this->validation->getErrors());
        }
    }

    /**
     * função que faz a checagem para constatar a existência do produto no sistema
     *
     * @param int $id id do produto
     * @return object \App\Entities/ProviderEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkProductExists(int $id): object
    {

        $productModel = \Config\Services::modelService('ProductModel');

        if ($id && $productData = $productModel->setTable('products_view')->where('deleted_at', null)->find($id)) {

            return $productData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função que faz a checagem para constatar a existência do fornecedor no sistema
     *
     * @param int $id id do fornecedor
     * @return object \App\Entities\ProviderEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkProviderExists(int $id): object
    {

        $providerModel = \Config\Services::modelService('ProviderModel');

        if ($id && $providerData = $providerModel->setTable('providers_view')->where('deleted_at', null)->find($id)) {

            return $providerData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função que faz a checagem para constatar a existência do produto no estoque do sistema
     *
     * @param int $id id do produto
     * @return object \App\Entities\StorageEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkStorageExists(int $storageId): object
    {

        if ($storageId && $storageData = $this->storageModel->setTable('storage_view')->where('deleted_at', null)->where('product_id', $storageId)->first()) {

            return $storageData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }
}
