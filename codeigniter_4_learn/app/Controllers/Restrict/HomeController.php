<?php

namespace App\Controllers\Restrict;

use App\Controllers\BaseController;

class HomeController extends BaseController {

    private $clientModel;
    private $saleModel;
    private $acquisitionModel;
    private $productModel;
    private $employeeModel;

    public function __construct() {

        $this->clientModel = \Config\Services::modelService('ClientModel');
        $this->saleModel = \Config\Services::modelService('SaleModel');
        $this->acquisitionModel = \Config\Services::modelService('AcquisitionModel');
        $this->productModel = \Config\Services::modelService('ProductModel');
        $this->providerModel = \Config\Services::modelService('ProviderModel');
        $this->employeeModel = \Config\Services::modelService('EmployeeModel');
    }

    /**
     * função que exibe a tela de dashboard
     * @return string Restrict/Home/index
     */
    public function index(): string {

        $data = [
            'title' => 'Home | Loja SA',
            'totalClients' => $this->clientModel->getTotalClients(),
            'totalSales' => $this->saleModel->getTotalSales(),
            'totalAcquisitions' => $this->acquisitionModel->getTotalAcquisitions(),
            'totalProducts' => $this->productModel->getTotalProducts(),
            'totalProviders' => $this->providerModel->getTotalProviders(),
            'totalEmployees' => $this->employeeModel->getTotalEmployees()
        ];

        return view('Restrict/Home/index', $data);
    }

}
