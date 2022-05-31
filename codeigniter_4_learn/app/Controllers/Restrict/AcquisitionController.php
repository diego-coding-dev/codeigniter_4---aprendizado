<?php

namespace App\Controllers\Restrict;

use App\Controllers\BaseController;

class AcquisitionController extends BaseController {

    private $acquisitionModel;
    private $acquisitionService;

    public function __construct() {

        $this->acquisitionModel = \Config\Services::modelService('AcquisitionModel');
        $this->acquisitionService = \Config\Services::sessionService('SessionAcquisition');
    }

    /**
     * função para listar todos as operações de aquisições registradas
     * @return string Restrict/Acquisition/list
     */
    public function list(): string {

        $this->acquisitionService->emptyAcquisitionSession(null, false);

        $dataView = [
            'title' => 'Aquisições | Loja SA',
            'acquisitionsList' => $this->acquisitionModel->setTable('acquisitions_view')->where('deleted_at', null)->paginate(),
            'pager' => $this->acquisitionModel->pager
        ];

        return view('Restrict/Acquisition/list', $dataView);
    }

    /**
     * função que exibe os dados da aquisição
     * @param int $acquisitionId id da aquisição
     * @return string Restrict/Acquisition/showAcquisition
     */
    public function showAcquisition(int $acquisitionId = null): string {

        $this->acquisitionService->emptyAcquisitionSession(substr(previous_url(), strlen(site_url())));

        $dataView = [
            'title' => 'Aquisições | Loja SA',
            'acquisitionData' => $this->checkAcquisitionExists($acquisitionId)
        ];

        return view('Restrict/Acquisition/showAcquisition', $dataView);
    }

    /**
     * função que mostra os produtos da aquisição
     * @param int $acquisitionId
     * @return string Restrict/Acquisition/showAcquisitionProducts 
     */
    public function showAcquisitionProducts(int $acquisitionId = null): string {

        $this->acquisitionService->emptyAcquisitionSession(substr(previous_url(), strlen(site_url())));

        $batchProductAcquisitionModel = \Config\Services::modelService('BatchProductAcquisitionModel');
        $productAcquisitionModel = \Config\Services::modelService('ProductAcquisitionModel');

        $this->checkAcquisitionExists($acquisitionId);

        $dataProductsAcquisition = $productAcquisitionModel->setTable('products_acquisition_view')->where('acquisition_id', $acquisitionId)->paginate();
        $listBatchQuantity = $batchProductAcquisitionModel->getBatchQuantityByProductAcquisitionId($dataProductsAcquisition);

        $dataView = [
            'title' => 'Aquisições | Loja SA',
            'productsAcquisiton' => $dataProductsAcquisition,
            'listBatchQuantity' => $listBatchQuantity,
            'acquisitionId' => $acquisitionId
        ];

        return view('Restrict/Acquisition/showAcquisitionProducts', $dataView);
    }

    /**
     * função que mostra os lotes dos produtos da aquisição
     * @param int $productAcquisitionId id do produto da aquisição
     * @return string Restrict/Acquisition/showAcquisitionBatches
     */
    public function showAcquisitionBatches(int $productAcquisitionId): string {

        $this->acquisitionService->emptyAcquisitionSession(substr(previous_url(), strlen(site_url())));

        $previousURL = substr(previous_url(), strlen(site_url()));
        $dataBatches = $this->checkBatchProductAcquisitionExists($productAcquisitionId);

        $dataView = [
            'title' => 'Aquisições | Loja SA',
            'listBatches' => $dataBatches,
            'previousURL' => $previousURL
        ];

        return view('Restrict/Acquisition/showAcquisitionBatches', $dataView);
    }

    /**
     * função que exibe tela para selcionar o fornecedor para cadastrar uma nova aquisição
     *
     * @return string Restrict/Acquition/select_product
     */
    public function showProviders(): string {

        $this->acquisitionService->emptyAcquisitionSession(substr(previous_url(), strlen(site_url())));

        $providerModel = \Config\Services::modelService('ProviderModel');

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'providersList' => $providerModel->setTable('providers_view')->where('deleted_at', null)->paginate(10),
            'pager' => $providerModel->pager,
            'totalInCart' => $this->acquisitionService->totalProducts(),
            'linkActive' => '0'
        ];

        return view('Restrict/Acquisition/showProviders', $dataView);
    }

    /**
     * função que seleciona o fornecedor do produto a ser cadastrado
     * @param int $providerId id do fornecedor
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function selectProvider(int $providerId = null): object {

        $this->acquisitionService->emptyAcquisitionSession(substr(previous_url(), strlen(site_url())));

        $providerData = $this->checkProviderExists($providerId);

        $this->acquisitionService->addProvider($providerData);

        return redirect()->to('privado/aquisicoes/adicionar/produtos/listar/todos');
    }

    /**
     * função que exibe tela para selcionar o produto do fornecedor para uma nova aquisição
     * @param int $providerId id do fornecedor
     * @return string Restrict/Acquition/showProducts
     */
    public function showProducts(): string {

        $this->acquisitionService->emptyAcquisitionSession(substr(previous_url(), strlen(site_url())));

        $storageModel = \Config\Services::modelService('StorageModel');

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'productsList' => $storageModel->setTable('storage_view')->paginate(10),
            'pager' => $storageModel->pager,
            'totalInCart' => $this->acquisitionService->totalProducts(),
            'totalBatches' => $this->acquisitionService->totalBatches(),
            'linkActive' => '1'
        ];
//        dd($dataView);
        return view('Restrict/Acquisition/showProducts', $dataView);
    }

    /**
     * função que exibe tela para selcionar produto para cadastrar uma nova aquisição
     *
     * @return string Restrict/Acquition/selectProduct
     */
    public function selectProduct(int $productId = null) {

        $this->acquisitionService->emptyAcquisitionSession(substr(previous_url(), strlen(site_url())));

        $productData = $this->checkProductExists($productId);

        $this->acquisitionService->addProduct($productData);

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'provider' => $this->acquisitionService->getProvider(),
            'productData' => $productData,
            'totalInCart' => $this->acquisitionService->totalProducts(),
            'listBatch' => $this->acquisitionService->getBatches($productId, true),
            'totalProducts' => $this->acquisitionService->getTotalProductByBatch($productId),
            'totalBatches' => $this->acquisitionService->totalBatches(),
            'additionalData' => $this->acquisitionService->additionaDataExists(),
            'linkActive' => '1'
        ];

        return view('Restrict/Acquisition/selectProduct', $dataView);
    }

    /**
     * função que adiciona o lote do produto na sessão
     */
    public function addBatch() {

        $validation = \Config\Services::validation();
        $productAcquisitionValidation = \Config\Services::validationService('ProductAcquisitionValidation');

        $dataBatch = $this->request->getPost();

        $validation->setRules($productAcquisitionValidation->selectRulesToValid($dataBatch), $productAcquisitionValidation->getRulesErrors());

        if ($validation->run($dataBatch)) {

            $this->acquisitionService->addBatch($dataBatch);

            return redirect()->to('privado/aquisicoes/adicionar/produtos/selecionar/' . $dataBatch['storage_id']);
        } else {

            return redirect()->back()->with('error_validation', $validation->getErrors());
        }
    }

    /**
     * função que remove o lote de um produto da sessão
     * @param string $productBatchId id do lote na sessão
     * @param int $productId id do produto a ser adicionado
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function removebatch(string $productBatchId, int $productId) {

        $this->acquisitionService->removeBatch($productBatchId);

        return redirect()->to('privado/aquisicoes/adicionar/produtos/selecionar/' . $productId);
    }

    /**
     * função que adiciona o produto no carrinho
     *
     * @param int $id id do produto
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function addToCart(): object {

        $validation = \Config\Services::validation();
        $productAcquisitionValidation = \Config\Services::validationService('ProductAcquisitionValidation');

        $dataCart = $this->request->getPost();

        $validation->setRules($productAcquisitionValidation->selectRulesToValid($dataCart), $productAcquisitionValidation->getRulesErrors());

        if ($validation->run($dataCart)) {

            $this->acquisitionService->addProduct($dataCart);
            return redirect()->to('privado/aquisicoes/adicionar/produtos')->with('success', 'Produto adicionado ao carrinho.');
        } else {

            return redirect()->back()->with('error_validation', $validation->getErrors());
        }
    }

    /**
     * função que mostrar os itens do carrinho
     *
     * @return string Restrict/Acquisition/complement/listCart
     */
    public function listCart(): string {

        $this->acquisitionService->emptyAcquisitionSession(substr(previous_url(), strlen(site_url())));

        $this->acquisitionService->setPrevURL(previous_url());

        $dataView = [
            'title' => 'Carrinho | Loja SA',
            'itensCart' => $this->acquisitionService->hasDataProduct() ? $this->acquisitionService->getProducts() : [],
            'providerId' => $this->acquisitionService->getProvider(true),
            'previousURL' => $this->acquisitionService->getPrevURL()
        ];

        return view('Restrict/Acquisition/complement/listCart', $dataView);
    }

    /**
     * função que remove produto da sessão
     *
     * @param int $id id do produto
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function removeFromCart(int $productId = null): object {

        $this->acquisitionService->removeFromCart($productId);

        return redirect()->to('privado/aquisicoes/adicionar/produtos/listar/todos')->with('info', 'Item removido.');
    }

    /**
     * função que finaliza o processo de colocar itens no carrinho
     *
     * @return string Restrict/Acquisition/additionalData
     */
    public function additionalData(): string {

        $this->acquisitionService->emptyAcquisitionSession(substr(previous_url(), strlen(site_url())));

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'dataProvider' => $this->acquisitionService->getProvider(),
            'totalInCart' => $this->acquisitionService->totalProducts(),
            'totalBatches' => $this->acquisitionService->totalBatches(),
            'additionalData' => $this->acquisitionService->additionaDataExists(),
            'linkActive' => '2'
        ];

        return view('Restrict/Acquisition/additionalData', $dataView);
    }

    /**
     * função que registra uma aquisição na sessão
     *
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function insertAdditionalData(): object {

        $validation = \Config\Services::validation();
        $acquisitionValidation = \Config\Services::validationService('AcquisitionValidation');

        $additionalData = $this->adjustPrices($this->request->getPost());

        $validation->setRules($acquisitionValidation->selectRulesToValid($additionalData), $acquisitionValidation->getRulesErrors());

        if ($validation->run($additionalData)) {

            $this->acquisitionService->addAddtionalData($additionalData);

            return redirect()->to('privado/aquisicoes/adicionar/resumo');
        } else {

            return redirect()->back()->with('error_validation', $validation->getErrors());
        }
    }

    /**
     * função que exibe tela de resumo da aquisição
     * @return string Restrict/Acquisition/resumeAcquisition
     */
    public function resumeAcquisition(): string {

        $this->acquisitionService->emptyAcquisitionSession(substr(previous_url(), strlen(site_url())));

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'totalInCart' => $this->acquisitionService->totalProducts(),
            'provider' => $this->acquisitionService->getProvider(),
            'products' => $this->acquisitionService->getProducts(),
            'batches' => $this->acquisitionService->getBatches(null, false),
            'additionalData' => $this->acquisitionService->getAdditionalData(),
            'linkActive' => '3'
        ];

        return view('Restrict/Acquisition/resumeAcquisition', $dataView);
    }

    /**
     * função que exibe tela para confirmar registro de uma nova aquisição
     * @return string Restrict/Acquisition/confirmRegister
     */
    public function confirmRegister(): string {

        $this->acquisitionService->emptyAcquisitionSession(substr(previous_url(), strlen(site_url())));

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'totalInCart' => $this->acquisitionService->totalProducts(),
            'linkActive' => '3'
        ];

        return view('Restrict/Acquisition/confirmRegister', $dataView);
    }

    /**
     * função que registra a aquisição no sistema
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function addAcquisition(): object {

        $dataDB = [
            'provider' => $this->acquisitionService->getProvider(),
            'productsAndBatches' => $this->acquisitionService->getProductsAndBatches(),
            'additionalData' => $this->acquisitionService->getAdditionalData()
        ];

        if ($this->acquisitionModel->add($dataDB)) {

            return redirect()->to('privado/aquisicoes/listar')->with('success', 'Aquisição registrada com sucesso.');
        } else {


            return redirect()->to('privado/aquisicoes/listar')->with('warning', 'Operação indisponível, tente mais tarde.');
        }
    }

    /**
     * função que ajusta os campos cost_price e sale_price vindos do POST
     *
     * @param array $dataDB dados capturado no POST
     * @return array dados prontopara serem validados e inseridos
     */
    private function adjustPrices(array $dataDB): array {

        $dataDB['operation_value'] = str_replace(',', '', $dataDB['operation_value']);

        return $dataDB;
    }

    /**
     * função que faz a checagem para constatar a existência do fornecedor no sistema
     *
     * @param int $id id do fornecedor
     * @return object \App\Entities\ProviderEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkProviderExists(int $id): object {

        $providerModel = \Config\Services::modelService('ProviderModel');

        if ($id && $providerData = $providerModel->setTable('providers_view')->where('deleted_at', null)->find($id)) {

            return $providerData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função que faz a checagem para constatar a existência do produto da aquisição no sistema
     *
     * @param int $id id da aquisição
     * @return object \App\Entities\ProductEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkProductExists(int $id): object {

        $storageModel = \Config\Services::modelService('StorageModel');

        if ($id && $storageData = $storageModel->setTable('storage_view')->where('id', $id)->first()) {

            return $storageData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função que faz a checagem para constatar a existência de lotes do produto da aquisição no sistema
     *
     * @param int $id id do produto da aquisição
     * @return array|object lista de \App\Models\BatchProductAcquisitionModel | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkBatchProductAcquisitionExists(int $id): array|object {

        $batchProductAcquisitionModel = \Config\Services::modelService('BatchProductAcquisitionModel');

        if ($id && $batchProductAcquisitionData = $batchProductAcquisitionModel->setTable('batch_product_acquisition_view')->where('products_acquisition_id', $id)->paginate()) {

            return $batchProductAcquisitionData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função que verifica a existência da aquisição no sistema
     * @param int $acquisitionId
     * @return object \App\Entities\AcquisitionEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkAcquisitionExists(int $acquisitionId) {

        if ($acquisitionId && $acquisitionData = $this->acquisitionModel->setTable('acquisitions_view')->where('deleted_at', null)->where('id', $acquisitionId)->first()) {

            return $acquisitionData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

}
