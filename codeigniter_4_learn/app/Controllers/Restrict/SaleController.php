<?php

namespace App\Controllers\Restrict;

use App\Controllers\BaseController;
use App\Models\SaleModel;
use App\Libraries\Session\SessionClient;

class SaleController extends BaseController
{

    private $saleModel;
    private $validation;
    private $saleService;

    public function __construct()
    {

        $this->saleModel = \Config\Services::modelService('SaleModel');
        $this->validation = \Config\Services::validation();
        $this->saleService = \Config\Services::sessionService('SessionSale');;
    }

    /**
     * função para listar todos as operações de vendas registradas
     * @return string Restrict/Sale/list
     */
    public function list(): string
    {

        $this->saleService->emptySaleSession(null, false);

        $dataView = [
            'title' => 'Vendas | Loja SA',
            'salesList' => $this->saleModel->setTable('sales_view')->where('deleted_at', null)->paginate(),
            'pager' => $this->saleModel->pager
        ];

        return view('Restrict/Sale/list', $dataView);
    }

    /**
     * função que exibe os dados da aquisição
     * @param int $saleId id da venda
     * @return string Restrict/Sale/showSale
     */
    public function showSale(int $saleId = null): string
    {

        $this->saleService->emptySaleSession(substr(previous_url(), strlen(site_url())));

        $dataSale = $this->checkSaleExists($saleId);

        $dataView = [
            'title' => 'Vendas | Loja SA',
            'saleData' => $this->checkSaleExists($saleId)
        ];

        return view('Restrict/Sale/showSale', $dataView);
    }

    /**
     * função que mostra os produtos da aquisição
     * @param int $acquisitionId
     * @return string Restrict/Acquisition/showAcquisitionProducts 
     */
    public function showSaleProducts(int $saleId = null): string
    {

        $this->saleService->emptySaleSession(substr(previous_url(), strlen(site_url())));

        $batchProductSaleModel = \Config\Services::modelService('BatchProductSaleModel');
        $productSaleModel = \Config\Services::modelService('ProductSaleModel');

        $this->checkSaleExists($saleId);

        $dataProductsSale = $productSaleModel->setTable('products_sale_view')->where('sale_id', $saleId)->paginate();
        $listBatchQuantity = $batchProductSaleModel->getBatchQuantityByProductSaleId($dataProductsSale);

        $dataView = [
            'title' => 'Aquisições | Loja SA',
            'productsSale' => $dataProductsSale,
            'listBatchQuantity' => $listBatchQuantity,
            'saleId' => $saleId
        ];

        return view('Restrict/Sale/showSaleProducts', $dataView);
    }

    /**
     * função que mostra os lotes dos produtos da aquisição
     * @param int $productAcquisitionId id do produto da aquisição
     * @return string Restrict/Acquisition/showAcquisitionBatches
     */
    public function showSaleBatches(int $productSaleId): string
    {

        $this->saleService->emptySaleSession(substr(previous_url(), strlen(site_url())));

        $previousURL = substr(previous_url(), strlen(site_url()));
        $dataBatches = $this->checkBatchProductSaleExists($productSaleId);

        $dataView = [
            'title' => 'Aquisições | Loja SA',
            'listBatches' => $dataBatches,
            'previousURL' => $previousURL
        ];

        return view('Restrict/Sale/showSaleBatches', $dataView);
    }

    /**
     * função que exibe tela para selcionar o cliente para cadastrar uma nova venda
     *
     * @return string Restrict/Sale/showClients
     */
    public function showClients(): string
    {

        $this->saleService->emptySaleSession(substr(previous_url(), strlen(site_url())));

        $clientModel = \Config\Services::modelService('ClientModel');

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'clientsList' => $clientModel->setTable('clients_view')->where('deleted_at', null)->paginate(10),
            'pager' => $clientModel->pager,
            'totalInCart' => $this->saleService->totalProducts(),
            'linkActive' => '0'
        ];

        return view('Restrict/Sale/showClients', $dataView);
    }

    /**
     * função para selecionar o cliente para a sessão
     * @param int $clientID id do cliente
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function selectClient(int $clientId = null): object
    {

        $dataClient = $this->checkClientExists($clientId);

        $this->saleService->addClient($dataClient);

        return redirect()->to('privado/vendas/adicionar/produtos/listar/todos');
    }

    /**
     * função que exibe tela para selcionar o produtos do cliente para cadastrar uma nova venda
     *
     * @return string Restrict/Sale/showProducts
     */
    public function showProducts(): string
    {

        $this->saleService->emptySaleSession(substr(previous_url(), strlen(site_url())));

        $storageModel = \Config\Services::modelService('StorageModel');

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'productsList' => $storageModel->setTable('storage_view')->paginate(10),
            'pager' => $storageModel->pager,
            'totalInCart' => $this->saleService->totalProducts(),
            'linkActive' => '1'
        ];

        return view('Restrict/Sale/showProducts', $dataView);
    }

    /**
     * função para selecionar o produto do cliente para a sessão
     * @param int $productId id do produto
     * @return string|object Restrict/Sale/selectProduct | CodeIgniter\HTTP\RedirectResponse
     */
    public function selectProduct(int $productId = null): string|object
    {

        $this->saleService->emptySaleSession(substr(previous_url(), strlen(site_url())));

        $productData = $this->checkStorageExists($productId);

        if ($this->saleService->checkAlreadyExistsProductInSession(['storage_id' => $productData->id])) {

            return redirect()->back()->with('info', 'Este produto já está no carrinho');
        }

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'productData' => $productData,
            'totalInCart' => $this->saleService->totalProducts(),
            'linkActive' => '1'
        ];

        return view('Restrict/Sale/selectProduct', $dataView);
    }

    /**
     * função que adiciona um produto na sessão
     * 
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function addProduct(): object
    {

        $this->saleService->emptySaleSession(substr(previous_url(), strlen(site_url())));

        $productSaleValidation = \Config\Services::validationService('ProductSaleValidation');

        $dataPost = $this->request->getPost();
        $totalProduct = $this->checkQuantityStorage($dataPost['storage_id']);

        if ($totalProduct < 1 || $totalProduct < $dataPost['total']) {
            
            return redirect()->back()->with('warning', 'Produto não está disponível ou em quantidade insuficiente.');
        }

        $this->validation->setRules($productSaleValidation->getRules($dataPost), $productSaleValidation->getRulesErrors());

        if ($this->validation->run($dataPost)) {

            $this->saleService->addProduct($dataPost);

            return redirect()->to('privado/vendas/adicionar/produtos/listar/todos');
        }

        return redirect()->back()->with('error_validation', $this->validation->getErrors());
    }

    /**
     * função para exibir a tela de dados adicionais
     * @return string Restrict/Sale/additionalData
     */
    public function additionalData(): string
    {

        $this->saleService->emptySaleSession(substr(previous_url(), strlen(site_url())));

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'totalInCart' => $this->saleService->totalProducts(),
            'linkActive' => '2'
        ];

        return view('Restrict/Sale/additionalData', $dataView);
    }

    /**
     * função que registra uma aquisição na sessão
     *
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function insertAdditionalData(): object
    {

        $saleValidation = \Config\Services::validationService('SaleValidation');

        $additionalData = $this->adjustPrices($this->request->getPost());

        $this->validation->setRules($saleValidation->selectRulesToValid($additionalData), $saleValidation->getRulesErrors());

        if ($this->validation->run($additionalData)) {

            $this->saleService->addAddtionalData($additionalData);

            return redirect()->to('privado/vendas/adicionar/resumo');
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função que exibe tela de resumo da venda
     * @return string Restrict/Sale/resumeSale
     */
    public function resumeAcquisition(): string
    {

        $this->saleService->emptySaleSession(substr(previous_url(), strlen(site_url())));

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'totalInCart' => $this->saleService->totalProducts(),
            'client' => $this->saleService->getClient(),
            'products' => $this->saleService->getProducts(),
            'additionalData' => $this->saleService->getAdditionalData(),
            'linkActive' => '3'
        ];

        return view('Restrict/Sale/resumeSale', $dataView);
    }

    /**
     * função que exibe tela para confirmar registro de uma nova venda
     * @return string Restrict/Sale/confirmRegister
     */
    public function confirmRegister(): string
    {

        $this->saleService->emptySaleSession(substr(previous_url(), strlen(site_url())));

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'totalInCart' => $this->saleService->totalProducts(),
            'linkActive' => '3'
        ];

        return view('Restrict/Sale/confirmRegister', $dataView);
    }

    /**
     * função que registra a venda no sistema
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function addSale(): object
    {

        $dataDB = [
            'client' => $this->saleService->getClient(),
            'products' => $this->saleService->getProducts(),
            'additionalData' => $this->saleService->getAdditionalData()
        ];

        if (!$this->checkAvailabilityInStorage($dataDB['products'])) {

            return redirect()->to('privado/vendas/adicionar/carrinho/mostrar')->with('danger', 'Os itens marcados não possuem estoque suficientes.');
        }

        if ($this->saleModel->addSale($dataDB)) {

            return redirect()->to('privado/vendas/listar')->with('success', 'Venda registrada com sucesso.');
        } else {

            return redirect()->to('privado/vendas/listar')->with('info', 'Operação temporáriamente indisponível, tente mais tarde.');
        }
    }

    /**
     * função para verificar a disponibilidade dos produtos no estoque, quantidade de itens da venda são menores que a quantidade de itens no estoque
     * @param array $produtos produtos da venda
     * @return bool
     */
    private function checkAvailabilityInStorage(array $products): bool
    {

        $storageModel = \Config\Services::modelService('StorageModel');
        $result = array();
        $count = 0;

        foreach ($products as $product) {

            $currentQuantity = $storageModel->select('total')->where('id', $product['storage_id'])->first();

            if ($currentQuantity->total < $product['total']) {

                $result['error'][$count] = $product['session_id'];
            }

            $count++;
        }

        if (array_key_exists('error', $result)) {

            $this->saleService->setSignal($result['error']);

            return false;
        }

        return true;
    }

    /**
     * função que ajusta os campos cost_price e sale_price vindos do POST
     *
     * @param array $dataDB dados capturado no POST
     * @return array dados prontopara serem validados e inseridos
     */
    private function adjustPrices(array $dataDB): array
    {

        $dataDB['operation_value'] = str_replace(',', '', $dataDB['operation_value']);

        return $dataDB;
    }

    /**
     * função que mostrar os itens do carrinho
     *
     * @return string Restrict/Sale/complement/listCart
     */
    public function listCart(): string
    {

        $this->saleService->emptySaleSession(substr(previous_url(), strlen(site_url())));

        $this->saleService->setPrevURL(previous_url());

        $dataView = [
            'title' => 'Carrinho | Loja SA',
            'itensCart' => $this->saleService->hasDataProduct() ? $this->saleService->getProducts() : [],
            'errorsItensCart' => $this->saleService->hasErrorsItensCart() ? $this->saleService->getSignal() : [],
            'previousURL' => $this->saleService->getPrevURL()
        ];

        return view('Restrict/Sale/complement/listCart', $dataView);
    }

    /**
     * função que remove produto da sessão
     *
     * @param string $id id do produto
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function removeFromCart(string $productId = null): object
    {

        $this->saleService->removeFromCart($productId);

        return redirect()->to('privado/vendas/adicionar/produtos/listar/todos')->with('info', 'Item removido.');
    }

    /**
     * função para checar se o cliente existe
     * @param int $clientId id do cliente
     * @return object App\Entities\ClientEntity | CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkClientExists(int $clientId): object
    {

        $clientModel = \Config\Services::modelService('ClientModel');

        if ($clientId && $dataClient = $clientModel->setTable('clients_view')->where('deleted_at', null)->where('id', $clientId)->first()) {

            return $dataClient;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função para checar se o produto existe no estoque
     * @param int $productId id do produto
     * @return object App\Entities\StorageEntity | CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkStorageExists(int $productId): object
    {

        $storageModel = \Config\Services::modelService('StorageModel');

        if ($productId && $dataProduct = $storageModel->setTable('storage_view')->where('product_id', $productId)->first()) {

            return $dataProduct;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função para checar se o produto existe no estoques, sem distinct
     * @param int $productId id do produto
     * @return int|object total do produto no estoque | CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkQuantityStorage(int $productId): int|object
    {

        $storageModel = \Config\Services::modelService('StorageModel');

        if ($productId && $dataProduct = $storageModel->setTable('storage_view')->select('total')->where('product_id', $productId)->first()) {

            return $dataProduct->total;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função que verifica a existência da venda no sistema
     * @param int $saleId
     * @return object \App\Entities\SaleEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkSaleExists(int $saleId)
    {

        if ($saleId && $saleData = $this->saleModel->setTable('sales_view')->where('deleted_at', null)->where('id', $saleId)->first()) {

            return $saleData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função que faz a checagem para constatar a existência de lotes do produto da venda no sistema
     *
     * @param int $id id do produto da venda
     * @return array|object lista de \App\Models\BatchProductSaleModel | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkBatchProductSaleExists(int $id): array|object
    {

        $batchProductSaleModel = \Config\Services::modelService('BatchProductSaleModel');

        if ($id && $batchProductSaleData = $batchProductSaleModel->setTable('batch_product_sale_view')->where('product_sale_id', $id)->paginate()) {

            return $batchProductSaleData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }
}
