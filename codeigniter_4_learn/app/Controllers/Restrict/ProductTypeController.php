<?php

namespace App\Controllers\Restrict;

use App\Controllers\BaseController;

class ProductTypeController extends BaseController {

    private $productTypeModel;
    private $productTypeValidation;
    private $validation;
    private $productService;

    public function __construct() {

        $this->productTypeModel = \Config\Services::modelService('ProductTypeModel');
        $this->productTypeValidation = \Config\Services::validationService('ProductTypeValidation');
        $this->validation = \Config\Services::validation();
        $this->productService = \Config\Services::sessionService('SessionProduct');
    }

    /**
     * função para listar todos as categorias produtos registrados e ativos
     * @param string $productType tipo de produto
     * @return string Restrict/ProductType/list
     */
    public function list(string $productType = null): string {

        $this->productService->emptyProductSession(null, false);

        $dataProductType = $this->productTypeModel->getAllProductsTypeToList(str_replace('-', ' ', $productType));
        $pager = $this->productTypeModel->pager;

        $dataView = [
            'title' => 'Lista de produtos | Loja SA',
            'productsTypeList' => $dataProductType,
            'pager' => $pager,
            'indexSearch' => $productType == 'todos' ? null : $productType
        ];

        return view('Restrict/ProductType/list', $dataView);
    }

    /**
     * função que busca o tipo do produto pela descrição
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function searchProductType(): object {

        $productTypeValidation = \Config\Services::validationService('ProductTypeValidation');

        $dataSearch = $this->request->getPost();

        $this->validation->setRules($productTypeValidation->selectRulesToValid($dataSearch), $productTypeValidation->getRulesErrors());

        if (!$this->validation->run($dataSearch)) {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }

        return redirect()->to('privado/tipo_de_produtos/listar/' . str_replace(' ', '-', $dataSearch['description']));
    }

    /**
     * função que exibe tela para cadastrar uma nova categoria de produto
     * @return string Restrict/ProductType/add
     */
    public function add(): string {

        $this->productService->emptyProductSession(substr(previous_url(), strlen(site_url())));

        $dataView = [
            'title' => 'Adicionando nova categoria de produto | Loja SA'
        ];

        return view('Restrict/ProductType/add', $dataView);
    }

    /**
     * função para registrar categoria de produto no sistema
     * 
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function insert(): object {

        $dataDB = $this->request->getPost();

        $this->validation->setRules($this->productTypeValidation->selectRulesToValid($dataDB), $this->productTypeValidation->getRulesErrors());

        if ($this->validation->run($dataDB)) {

            if ($this->productTypeModel->insert($dataDB)) {

                return redirect()->to("privado/tipo_de_produtos/listar/todos")->with('success', 'Categoria de produto registrada com sucesso.');
            } else {

                return redirect()->to("privado/tipo_de_produtos/listar/todos")->with('danger', 'Não foi possível realizar esta operação, tente mais tarde.');
            }
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função que exibe tela para atualizar registro do tipo do produto
     * @param int id do fornecedor
     * @return string Restric/ProductType/edit
     */
    public function edit($id = null): string {

        $this->productService->emptyProductSession(substr(previous_url(), strlen(site_url())));

        $dataProduct = $this->checkProductTypeExists($id);

        $this->productService->addProductType($dataProduct);

        $dataView = [
            'title' => 'Atualizando informações | Loja SA',
            'productType' => $dataProduct
        ];

        return view('Restrict/ProductType/edit', $dataView);
    }

    /**
     * função que atualiza categoria de produtos
     * @return object \CodeIgniter\HTTP\RedirectResponse
     */
    public function update(): object {

        $productTypeId = $this->productService->getProductType(true);

        $this->checkProductTypeExists($productTypeId);

        $dataDB = $this->productTypeValidation->checkEmptyFields($this->request->getPost());

        if (empty($dataDB)) {

            return redirect()->back()->with('info', 'Não há dados para atualizar.');
        }

        $this->validation->setRules($this->productTypeValidation->selectRulesToValid($dataDB), $this->productTypeValidation->getRulesErrors());

        if ($this->validation->run($dataDB)) {

            if ($this->productTypeModel->update($productTypeId, $dataDB)) {

                return redirect()->to("privado/tipo_de_produtos/listar/todos")->with('success', 'Dados atualizados com sucesso.');
            } else {

                return redirect()->to("privado/tipo_de_produtos/listar/todos")->with('danger', 'Não foi possível realizar esta operaçã, tente mais tarde.');
            }
        } else {

            return redirect()->back()->with('error_validation', $this->validation->getErrors());
        }
    }

    /**
     * função que faz a checagem para constatar a existência da categoria de produto no sistema
     * @param int $id id da categoria de produto
     * @return object \App\Entities\ProductTypeEntity | \CodeIgniter\Exceptions\PageNotFoundException
     */
    private function checkProductTypeExists(int $id): object {

        if ($id && $productTypeData = $this->productTypeModel->find($id)) {

            return $productTypeData;
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Operação não realizada.");
    }

}
