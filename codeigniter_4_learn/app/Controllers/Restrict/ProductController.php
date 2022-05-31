<?php

namespace App\Controllers\Restrict;

use App\Controllers\BaseController;
use App\Validation\ProductValidation;

class ProductController extends BaseController
{

    private $productModel;
    private $productValidation;
    private $validation;
    private $productService;

    public function __construct()
    {

        $this->validation = \Config\Services::validation();
        $this->productValidation = \Config\Services::validationService('ProductValidation');
        $this->productModel = \Config\Services::modelService('ProductModel');
        $this->productService = \Config\Services::sessionService('SessionProduct');
    }

    /**
     * função para listar todos os produtos registrados e ativos
     * @param string $product nome do produto
     * @return string Restrict/Product/list
     */
    public function list(string $product = null): string
    {

        $this->productService->emptyProductSession(null, false);

        $dataProduct = $this->productModel->getAllProductsToList(str_replace('-', ' ', $product));
        $pager = $this->productModel->pager;

        $dataView = [
            'title' => 'Lista de produtos | Loja SA',
            'productsList' => $dataProduct,
            'pager' => $pager,
            'indexSearch' => $product == 'todos' ? null : $product
        ];
//        dd($dataView['pager']->links());;
        return view('Restrict/Product/list', $dataView);
    }

    /**
     * função que busca o produto pela descrição
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function searchProduct(): object
    {

        $productValidation = \Config\Services::validationService('ProductValidation');

        $dataSearch = $this->request->getPost();

        $this->validation->setRules($productValidation->selectRulesToValid($dataSearch), $productValidation->getRulesErrors());

        if (!$this->validation->run($dataSearch)) {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }

        return redirect()->to('privado/produtos/listar/' . str_replace(' ', '-', $dataSearch['description']));
    }

    /**
     * função que exibe tela com dados do produto cadastrado
     *
     * @param int id do produto
     * @return string Restrict/Product/show
     */
    public function show($id = null): string
    {

        $this->productService->emptyProductSession(substr(previous_url(), strlen(site_url())), true);

        $dataProduct = $this->checkProductExists($id);

        $dataView = [
            'title' => 'Exibindo informações | Loja SA',
            'product' => $dataProduct
        ];

        $this->productService->addProduct($dataProduct);

        return view('Restrict/Product/show', $dataView);
    }

    /**
     * função que exibe tela para atualizar registro do produto
     * @return string Restric/Product/edit
     */
    public function edit(): string
    {

        $this->productService->emptyProductSession(substr(previous_url(), strlen(site_url())), true);

        $dataProduct = $this->productService->getproduct();

        $dataView = [
            'title' => 'Atualizando informações | Loja SA',
            'product' => $dataProduct
        ];

        return view('Restrict/Product/edit', $dataView);
    }

    /**
     * função que atualiza dados do produto
     * @return object Restric/Product/edit
     */
    public function update(): object
    {

        $productData = $this->productService->getproduct();
        $dataDB = $this->productValidation->checkEmptyFields($this->request->getPost());
        $dataDB = $this->ajusteData($dataDB);

        if ($dataDB['out_of_production'] == $productData['out_of_production']) {

            return redirect()->to('privado/produtos/mostrar/' . $productData['id'])->with('info', 'Não há dados para atualizar.');
        }

        $this->validation->setRules($this->productValidation->selectRulesToValid($dataDB), $this->productValidation->getRulesErrors());

        if ($this->validation->run($dataDB)) {

            if ($this->productModel->updateById($productData['id'], $dataDB)) {

                return redirect()->to('privado/produtos/mostrar/' . $productData['id'])->with('success', 'Dados atualizados com sucesso.');
            } else {

                return redirect()->to('privado/produtos/mostrar/' . $productData['id'])->with('danger', 'Não foi possível realizar esta operaçã, tente mais tarde.');
            }
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função que exibe tela para selecionar o tipo do produto a ser cadastrado
     * @param string $typeProduct tipo do produto
     * @return string Restrict/Product/showProductType
     */
    public function showProductType(string $typeProduct = null): string
    {

        $this->productService->emptyProductSession(substr(previous_url(), strlen(site_url())), true);

        $productTypeModel = \Config\Services::modelService('ProductTypeModel');

        $dataProductType = null;

        if ($typeProduct === 'todos' || !$typeProduct) {

            $dataProductType = $productTypeModel->where('deleted_at', null)->paginate(10);
            $pager = $productTypeModel->pager;
        } else {

            $dataProductType = $productTypeModel->where('deleted_at', null)->like('description', str_replace('-', ' ', $typeProduct), 'both')->paginate(10);
            $pager = $productTypeModel->pager;
        }

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'productsTypeList' => $dataProductType,
            'pager' => $pager,
            'linkActive' => '1'
        ];

        return view('Restrict/Product/showProductType', $dataView);
    }

    /**
     * função que busca o tipo do produto pela descrição
     * @return object Restric/Product/edit
     */
    public function searchProductType(): object
    {

        $productTypeValidation = \Config\Services::validationService('ProductTypeValidation');

        $dataSearch = $this->request->getPost();

        $this->validation->setRules($productTypeValidation->selectRulesToValid($dataSearch), $productTypeValidation->getRulesErrors());

        if (!$this->validation->run($dataSearch)) {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }

        return redirect()->to('privado/produtos/adicionar/tipo_produto/listar/' . str_replace(' ', '-', $dataSearch['description']));
    }

    /**
     * função que seleciona o fornecedor do produto a ser cadastrado
     *
     * @param int id do fornecedor
     * @return object Restric/Product/edit
     */
    public function selectProductType(int $productTypeId): object
    {

        $productTypeData = $this->checkProductTypeIdExists($productTypeId);

        $this->productService->addProductType($productTypeData);

        return redirect()->to('privado/produtos/adicionar/marca/listar/todos');
    }

    /**
     * função que exibe tela para selecionar a marca do produto
     * 
     * @param string $brand marca do produto
     * @return string Restrict/Product/showBrands
     */
    public function showBrands(string $brand = null): string
    {

        $this->productService->emptyProductSession(substr(previous_url(), strlen(site_url())), true);

        $brandsModel = \Config\Services::modelService('BrandModel');

        $dataBrand = null;

        if ($brand === 'todos' || !$brand) {

            $dataBrand = $brandsModel->where('deleted_at', null)->paginate(10);
            $pager = $brandsModel->pager;
        } else {

            $dataBrand = $brandsModel->where('deleted_at', null)->like('description', str_replace('-', ' ', $brand), 'both')->paginate(10);
            $pager = $brandsModel->pager;
        }

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'brandsList' => $dataBrand,
            'pager' => $pager,
            'linkActive' => '2'
        ];

        return view('Restrict/Product/showBrands', $dataView);
    }

    /**
     * função que busca marca pela descrição
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function searchBrand(): object
    {

        $brandValidation = \Config\Services::validationService('BrandValidation');

        $dataSearch = $this->request->getPost();

        $this->validation->setRules($brandValidation->selectRulesToValid($dataSearch), $brandValidation->getRulesErrors());

        if (!$this->validation->run($dataSearch)) {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }

        return redirect()->to('privado/produtos/adicionar/marca/listar/' . str_replace(' ', '-', $dataSearch['description']));
    }

    /**
     * função que seleciona a marca do produto a ser cadastrado
     *
     * @param int id do fornecedor
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function selectBrands(int $brandId): object
    {

        $brandData = $this->checkBrandIdExists($brandId);

        $this->productService->addBrand($brandData);

        return redirect()->to('privado/produtos/adicionar/descricao');
    }

    /**
     * função que mostrar a tela para definir informações doproduto a ser cadastrado
     *
     * @return string Restrict/Product/productDescription
     */
    public function productDescription(): string
    {

        $this->productService->emptyProductSession(substr(previous_url(), strlen(site_url())), true);

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'linkActive' => '3'
        ];

        return view('Restrict/Product/productDescription', $dataView);
    }

    /**
     * função que exibe a tela para confirmar o registro de um novo produto
     * 
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function addProductDescription(): object
    {

        $dataDB = $this->request->getPost();

        $this->validation->setRules($this->productValidation->selectRulesToValid($dataDB), $this->productValidation->getRulesErrors());

        if ($this->validation->run($dataDB)) {

            $dataDB['product_type_id'] = $this->productService->getProductType(true);
            $dataDB['brand_id'] = $this->productService->getBrand(true);

            $this->productService->addAdditionalData($dataDB);

            return redirect()->to('privado/produtos/adicionar/confirmar');
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função que exibe tela para confirmar registro de um novo produto
     * @return string Restrict/Product/confirmRegister
     */
    public function confirmRegister(): string
    {

        $this->productService->emptyProductSession(substr(previous_url(), strlen(site_url())), true);

        $dataView = [
            'title' => 'Adicionando novo produto | Loja SA',
            'linkActive' => '3'
        ];

        return view('Restrict/Product/confirmRegister', $dataView);
    }

    /**
     * função que registra os dados do novo produto no sistema
     *
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function addProduct(): object
    {

        $dataProduct = $this->productService->getAdditionalData();

        if ($this->productModel->addProduct($dataProduct)) {

            return redirect()->to('privado/produtos/listar/todos')->with('success', 'Produto adicionado com sucesso.');
        } else {

            return redirect()->to('privado/produtos/listar/todos')->with('warning', 'Desculpe, está operação está indisponível no momento,tente mais tarde.');
        }
    }

    /**
     * função que exibe tela para confirmar exclusão
     * @param int id do produto
     * @return string 'dialog/confirm'
     */
    public function exclude($id = null): string
    {

        $productData = $this->checkProductExists($id);

        $dataView = [
            'title' => 'Conformar exclusão | Lojas SA',
            'ask' => 'Confirmar exclusão?',
            'entity' => 'produtos',
            'action' => 'deletar'
        ];

        $this->productService->addProduct($productData);

        return view('dialog/confirm', $dataView);
    }

    /**
     * função para excluir produto do sistema
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete(): object
    {

        $productId = $this->productService->getProduct(true);

        if ($this->productModel->deleteProduct($productId)) {

            return redirect()->to('privado/produtos/listar/todos')->with('success', 'Produto excuído com sucesso.');
        }

        return redirect()->to('privado/produtos/listar/todos')->with('danger', 'Operação não realizada com sucesso.');
    }

    /**
     * função que ajusta os campos cost_price e slae_price vindos do POST
     *
     * @param array $dataDB dados capturado no POST
     * @return array dados prontopara serem validados e inseridos
     */
    private function adjustPrices(array $dataDB): array
    {

        $dataDB['cost_price'] = str_replace(',', '', $dataDB['cost_price']);
        $dataDB['sale_price'] = str_replace(',', '', $dataDB['sale_price']);

        return $dataDB;
    }

    /**
     * função para verificar e setar valore vindo do campo select no formulário
     *
     * @param array $dataDB dados vindos do formulário
     * @return array $dataDB - dados com os campos select do fomulpario já ajustados
     */
    private function ajusteData(array $dataBD): array
    {

        if ($dataBD['out_of_production'] === 'active') {

            $dataBD['out_of_production'] = 0;
        } else {

            $dataBD['out_of_production'] = 1;
        }

        return $dataBD;
    }

    /**
     * função que lista os produtos por categoria
     *
     * @param int | id da categoria
     * @return string Restrict/Product/listByCategoryAjax
     */
    public function listByCategoryAjax(int $id): string
    {

        $dataView = [
            'productsList' => $this->productModel->getProductsByCategory($id)
        ];

        return view('Restrict/Product/listByCategoryAjax', $dataView);
    }

    /**
     * função que faz a checagem para constatar a existência do produto no sistema
     *
     * @param int $id id do produto
     * @return object \App\Entities\ProductEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkProductExists(int $id): object
    {

        if ($id && $productData = $this->productModel->setTable('products_view')->where('deleted_at', null)->find($id)) {

            return $productData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função que faz a checagem para constatar a existência do tipo do produto no sistema
     *
     * @param int $id id do tipo do produto
     * @return object \App\Entities\ProductTypeEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkProductTypeIdExists(int $id): object
    {

        $productTypeModel = \Config\Services::modelService('ProductTypeModel');

        if ($id && $productTypeData = $productTypeModel->where('deleted_at', null)->find($id)) {

            return $productTypeData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

    /**
     * função que faz a checagem para constatar a existência da marca no sistema
     *
     * @param int $id id da marca
     * @return object \App\Entities\ProductTypeEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkBrandIdExists(int $id): object
    {

        $brandModel = \Config\Services::modelService('BrandModel');

        if ($id && $brandData = $brandModel->where('deleted_at', null)->find($id)) {

            return $brandData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }
}
