<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// desabilitando rotas automáticas (namespaces)
// $routes->setAutoRoute(true);
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */

// grupo para redirecionamentos 404
$routes->add('redireciona', function () {
    $emplooyeAuth = service('employeeAuth');

    if ($emplooyeAuth->isLogged()) {
        return redirect()->to('privado/inicio/home');
    } else {
        return redirect()->to('publico/autenticacao/credencial');
    }
});

// grupo publico
$routes->group('publico', function ($routes) {
    // grupo autenticacao
    $routes->group('autenticacao', ['filter' => ['isLogged']], function ($routes) {
        $routes->get('', 'LoginController::login');
        $routes->post('autenticar', 'LoginController::authenticate');
    });
});
// grupo privado
$routes->group('privado', function ($routes) {
    // grupo inicial
    $routes->group('principal', ['filter' => ['isNotLogged']], function ($routes) {
        $routes->get('', 'Restrict\HomeController::index');
    });
    // grupo vendas
    $routes->group('vendas', function ($routes) {
        // grupo continuação de vendas
        $routes->group('', ['filter' => ['isNotLogged']], function ($routes) {
            // $routes->addRedirect('', 'privado/aquisicoes/listar/todos');
            $routes->get('listar', 'Restrict\SaleController::list');
        });
        // grupos mostrar
        $routes->group('mostrar', ['filter' => ['isNotLogged', 'hasSale']], function ($routes) {
            $routes->get('(:num)', 'Restrict\SaleController::showSale/$1');
            $routes->get('produtos/(:num)', 'Restrict\SaleController::showSaleProducts/$1');
            $routes->get('lotes/(:num)', 'Restrict\SaleController::showSaleBatches/$1');
        });
        // grupo adicionar
        $routes->group('adicionar', function ($routes) {
            $routes->addRedirect('', 'privado/vendas/adicionar/clientes/listar/todos');
            // grupo clientes
            $routes->group('clientes', ['filter' => ['isNotLogged', 'hasClient']], function ($routes) {
                $routes->get('listar/(:any)', 'Restrict\SaleController::showClients');
                $routes->get('selecionar/(:num)', 'Restrict\SaleController::selectClient/$1');
            });
            // grupo produtos
            $routes->group('produtos', ['filter' => ['isNotLogged', 'hasProduct', 'toAddSaleProduct']], function ($routes) {
                $routes->get('listar/(:any)', 'Restrict\SaleController::showProducts');
                $routes->get('selecionar/(:num)', 'Restrict\SaleController::selectProduct/$1');
                $routes->post('finalizar', 'Restrict\SaleController::addProduct');
            });
            // grupo carrinho
            $routes->group('carrinho', ['filter' => ['isNotLogged', 'hasClient', 'hasProduct']], function ($routes) {
                $routes->get('mostrar', 'Restrict\SaleController::listCart');
                $routes->get('deletar/(:any)', 'Restrict\SaleController::removeFromCart/$1');
            });
            // grupo dados adicionais
            $routes->group('dados_adicionais', ['filter' => ['isNotLogged', 'hasClient', 'hasProduct', 'toAddSaleAdditionalData']], function ($routes) {
                $routes->get('', 'Restrict\SaleController::additionalData');
                $routes->post('inserir', 'Restrict\SaleController::insertAdditionalData');
            });
            // grupo resumo
            $routes->group('resumo', ['filter' => ['isNotLogged', 'hasClient', 'hasProduct', 'toAddSaleResume']], function ($routes) {
                $routes->get('', 'Restrict\SaleController::resumeAcquisition');
                $routes->get('confirmar', 'Restrict\SaleController::confirmRegister');
            });
            $routes->get('finalizar', 'Restrict\SaleController::addSale', ['filter' => ['hasClient', 'hasProduct', 'hasProductType']]);
        });
    });
    // grupo aquisições
    $routes->group('aquisicoes', function ($routes) {
        // grupo continuação de aquisições
        $routes->group('', ['filter' => 'isNotLogged'], function ($routes) {
            // $routes->addRedirect('', 'privado/aquisicoes/listar/todos');
            $routes->get('listar', 'Restrict\AcquisitionController::list');
        });
        // grupos mostrar
        $routes->group('mostrar', ['filter' => ['isNotLogged', 'hasAcquisition']], function ($routes) {
            $routes->get('(:num)', 'Restrict\AcquisitionController::showAcquisition/$1');
            $routes->get('produtos/(:num)', 'Restrict\AcquisitionController::showAcquisitionProducts/$1');
            $routes->get('lotes/(:num)', 'Restrict\AcquisitionController::showAcquisitionBatches/$1');
        });
        // grupo adicionar
        $routes->group('adicionar', function ($routes) {
            $routes->addRedirect('', 'privado/aquisicoes/adicionar/fornecedor/listar/todos');
            // grupo fornecedor
            $routes->group('fornecedor', ['filter' => ['isNotLogged', 'hasProvider']], function ($routes) {
                $routes->get('listar/(:any)', 'Restrict\AcquisitionController::showProviders');
                $routes->get('selecionar/(:num)', 'Restrict\AcquisitionController::selectProvider/$1');
            });
            // grupo produtos
            $routes->group('produtos', ['filter' => ['isNotLogged', 'hasProvider', 'hasProduct', 'toAddAcquisitionProduct']], function ($routes) {
                $routes->get('listar/(:any)', 'Restrict\AcquisitionController::showProducts/$1');
                $routes->get('selecionar/(:num)', 'Restrict\AcquisitionController::selectProduct/$1');
                $routes->post('adiciona_no_carrinho', 'Restrict\AcquisitionController::addProductInTheCart');
            });
            // grupo dados_adicionais
            $routes->group('dados_adicionais', ['filter' => ['isNotLogged', 'hasProvider', 'hasProduct', 'toAddAcquisitionAdditionalData']], function ($routes) {
                $routes->get('', 'Restrict\AcquisitionController::additionalData');
                $routes->post('inserir', 'Restrict\AcquisitionController::insertAdditionalData');
            });
            // grupo lotes
            $routes->group('lotes', ['filter' => ['isNotLogged', 'hasProvider', 'hasProduct', 'toAddAcquisitionProduct']], function ($routes) {
                $routes->post('adicionar', 'Restrict\AcquisitionController::addBatch');
                $routes->get('remover/(:any)/(:num)', 'Restrict\AcquisitionController::removeBatch/$1/$2');
            });
            // grupo carrinho
            $routes->group('carrinho', ['filter' => ['isNotLogged', 'hasProvider', 'hasProduct']], function ($routes) {
                $routes->get('mostrar', 'Restrict\AcquisitionController::listCart');
                $routes->get('deletar_item/(:num)', 'Restrict\AcquisitionController::removeFromCart/$1');
            });
            // grupo resumo
            $routes->group('resumo', ['filter' => ['isNotLogged', 'hasProvider', 'hasProduct', 'toAddAcquisitionResume']], function ($routes) {
                $routes->get('', 'Restrict\AcquisitionController::resumeAcquisition');
                $routes->get('confirmar', 'Restrict\AcquisitionController::confirmRegister');
            });
            $routes->get('finalizar', 'Restrict\AcquisitionController::addAcquisition', ['filter' => ['isNotLogged', 'hasProvider', 'hasProduct', 'toAddAcquisitionResume']]);
        });
    });
    // grupo estoque
    $routes->group('estoque', function ($routes) {
        // grupo continuação de estoque
        $routes->group('', ['filter' => ['isNotLogged']], function ($routes) {
            $routes->addRedirect('', 'privado/estoque/listar/todos');
            $routes->get('listar/(:any)', 'Restrict\StorageController::list/$1');
        });
        // grupo continuação de estoque
        $routes->group('', ['filter' => ['isNotLogged', 'hasStorage']], function ($routes) {
            $routes->get('mostrar/(:num)', 'Restrict\StorageController::show/$1');
            $routes->get('lotes', 'Restrict\StorageController::showBatches');
            $routes->post('procurar', 'Restrict\StorageController::searchStorage');
        });
        // grupo para editar
        $routes->group('', ['filter' => ['isNotLogged', 'hasStorage']], function ($routes) {
            $routes->get('editar', 'Restrict\StorageController::edit');
            $routes->post('atualizar', 'Restrict\StorageController::update');
        });
    });
    // grupo tipo_de_produtos
    $routes->group('tipo_de_produtos', function ($routes) {
        // grupo continuação de tipo_de_produtos
        $routes->group('', ['filter' => 'isNotLogged'], function ($routes) {
            $routes->addRedirect('', 'privado/tipo_de_produtos/listar/todos');
            $routes->get('listar/(:any)', 'Restrict\ProductTypeController::list/$1');
            $routes->post('procurar', 'Restrict\ProductTypeController::searchProductType');
        });
        // grupo adicionar
        $routes->group('', ['filter' => 'isNotLogged'], function ($routes) {
            $routes->get('adicionar', 'Restrict\ProductTypeController::add');
            $routes->post('registrar', 'Restrict\ProductTypeController::insert');
        });
        // grupo editar
        $routes->group('', ['filter' => 'isNotLogged', 'hasProductType'], function ($routes) {
            $routes->get('editar/(:num)', 'Restrict\ProductTypeController::edit/$1');
            $routes->post('atualizar', 'Restrict\ProductTypeController::update');
        });
    });
    // grupo produtos
    $routes->group('produtos', function ($routes) {
        // grupo continuação de produtos
        $routes->group('', ['filter' => ['isNotLogged']], function ($routes) {
            $routes->addRedirect('', 'privado/produtos/listar/todos');
            $routes->get('listar/(:any)', 'Restrict\ProductController::list/$1');
            $routes->post('procurar', 'Restrict\ProductController::searchProduct');
        });
        // grupo adcionar
        $routes->group('adicionar', function ($routes) {
            $routes->addRedirect('', 'privado/produtos/adicionar/tipo_produto/listar/todos');
            // grupo tipo produto
            $routes->group('tipo_produto', ['filter' => ['isNotLogged', 'hasProductType']], function ($routes) {
                $routes->get('listar/(:any)', 'Restrict\ProductController::showProductType/$1');
                $routes->get('selecionar/(:num)', 'Restrict\ProductController::selectProductType/$1');
                $routes->post('procurar', 'Restrict\ProductController::searchProductType');
            });
            // grupo marca
            $routes->group('marca', ['filter' => ['isNotLogged', 'hasBrand', 'toAddBrand']], function ($routes) {
                $routes->get('listar/(:any)', 'Restrict\ProductController::showBrands/$1');
                $routes->get('selecionar/(:num)', 'Restrict\ProductController::selectBrands/$1');
                $routes->post('procurar', 'Restrict\ProductController::searchBrand');
            });
            // grupo departamento
            $routes->group('descricao', ['filter' => ['isNotLogged', 'hasProductType', 'hasBrand', 'toAddDescription']], function ($routes) {
                $routes->get('', 'Restrict\ProductController::productDescription');
                $routes->post('adicionar', 'Restrict\ProductController::addProductDescription');
            });
            // grupo continuação de adicionar
            $routes->group('', ['filter' => ['isNotLogged', 'hasProductType', 'hasBrand', 'toAddProduct']], function ($routes) {
                $routes->get('confirmar', 'Restrict\ProductController::confirmRegister');
                $routes->get('finalizar', 'Restrict\ProductController::addProduct');
            });
        });
        // grupo para editar
        $routes->group('', ['filter' => ['isNotLogged', 'hasProductType', 'hasBrand']], function ($routes) {
            $routes->get('editar', 'Restrict\ProductController::edit');
            $routes->get('excluir/(:num)', 'Restrict\ProductController::exclude/$1');
            $routes->get('deletar', 'Restrict\ProductController::delete');
            $routes->post('atualizar', 'Restrict\ProductController::update');
        });
        // grupo mostrar
        $routes->group('mostrar', ['filter' => ['isNotLogged', 'hasProductType', 'hasBrand']], function ($routes) {
            $routes->get('(:num)', 'Restrict\ProductController::show/$1');
        });
    });
    // grupo fornecedores
    $routes->group('fornecedores', function ($routes) {
        // continuação de fornecedores
        $routes->group('', ['filter' => ['isNotLogged']], function ($routes) {
            $routes->addRedirect('', 'privado/fornecedores/listar/todos');
            $routes->get('listar/(:any)', 'Restrict\ProviderController::list/$1');
            $routes->post('procurar', 'Restrict\ProviderController::searchProvider');
        });
        // grupo adicionar
        $routes->group('adicionar', function ($routes) {
            // continuação de adicionar
            $routes->group('', ['filter' => ['isNotLogged', 'hasUserType']], function ($routes) {
                $routes->get('', 'Restrict/ProviderController::add');
                $routes->post('', 'Restrict\ProviderController::insert');
            });
            // grupo telefone       
            $routes->group('telefone', ['filter' => ['isNotLogged', 'hasTelephoneType']], function ($routes) {
                $routes->post('', 'Restrict\ProviderController::addTelephone');
                $routes->get('excluir/(:any)', 'Restrict\ProviderController::removeTelephone/$1');
            });
        });
        // grupo editar
        $routes->group('editar', ['filter' => ['isNotLogged', 'hasProvider']], function ($routes) {
            $routes->get('', 'Restrict\ProviderController::edit');
            $routes->get('mostrar/(:num)', 'Restrict\ProviderController::show/$1');
            $routes->get('excluir_telefone/(:num)', 'Restrict\ProviderController::excludeTelephone/$1');
            $routes->post('atualizar_dados', 'Restrict\ProviderController::update');
            $routes->post('adicionar_telefone', 'Restrict\ProviderController::addNewTelephone');
        });
        // grupo excluir
        $routes->group('', ['filter' => ['isNotLogged', 'hasProvider']], function ($routes) {
            $routes->get('excluir/(:num)', 'Restrict\ProviderController::exclude/$1');
            $routes->get('deletar/(:num)', 'Restrict\ProviderController::delete/$1');
        });
    });
    // grupo funcionarios
    $routes->group('funcionarios', function ($routes) {
        // grupo ativação
        $routes->group('ativar_conta', ['filter' => ['isLogged']], function ($routes) {
            $routes->get('verificar/(:any)', 'Restrict\EmployeeController::checkTokenActivation/$1');
            $routes->get('credencial/(:num)', 'Restrict\EmployeeController::defineCredential/$1');
            $routes->post('atualizar_credencial/(:any)', 'Restrict\EmployeeController::updateCredential/$1');
        });
        // grupo continuação de funcionarios
        $routes->group('', ['filter' => ['isNotLogged', 'hasUserType']], function ($routes) {
            $routes->addRedirect('', 'privado/funcionarios/listar');
            $routes->get('listar', 'Restrict\EmployeeController::list');
        });
        // grupo adicionar
        $routes->group('adicionar', ['filter' => ['isNotLogged', 'hasUserType', 'hasUserType']], function ($routes) {
            $routes->get('', 'Restrict\EmployeeController::add');
            $routes->post('', 'Restrict\EmployeeController::insert');
            // grupo telefone       
            $routes->group('telefone', function ($routes) {
                $routes->post('', 'Restrict\EmployeeController::addTelephone');
                $routes->get('excluir/(:any)', 'Restrict\EmployeeController::removeTelephone/$1');
            });
        });
        // grupo editar
        $routes->group('editar', ['filter' => ['isNotLogged', 'hasUserType', 'hasTelephoneType']], function ($routes) {
            $routes->get('', 'Restrict\EmployeeController::edit/$1');
            $routes->get('mostrar/(:num)', 'Restrict\EmployeeController::show/$1');
            $routes->post('atualizar/(:num)', 'Restrict\EmployeeController::update/$1');
            $routes->post('adicionar_telefone', 'Restrict\EmployeeController::addNewTelephone');
            $routes->get('excluir_telefone/(:num)', 'Restrict\EmployeeController::excludeTelephone/$1');
            $routes->get('ativar', 'Restrict\EmployeeController::active');
            $routes->get('desativar', 'Restrict\EmployeeController::deactive');
            $routes->get('confirmar_desativacao', 'Restrict\EmployeeController::confirmDeactive');
        });

//         grupo para ativar no primeiro login (DESATIVADO)
//        $routes->group('', ['filter' => ['isNotFirstLogin', 'hasUserType']], function ($routes) {
//            $routes->get('editar_credencial', 'Restrict\EmployeeController::changeCredential');
//            $routes->post('atualizar_credencial/(:num)', 'Restrict\EmployeeController::updateCredential/$1');
//        });

        // grupo excluir
        $routes->group('', ['filter' => ['isNotLogged']], function ($routes) {
            $routes->get('excluir/(:num)', 'Restrict\EmployeeController::delete/$1');
            $routes->get('confirmar_exclusao/(:num)', 'Restrict\EmployeeController::confirmDelete/$1');
        });
        // grupo logout
        $routes->group('', ['filter' => ['isNotLogged']], function ($routes) {
            $routes->get('sair', 'Restrict\EmployeeController::logout');
        });
    });
    // grupo clientes
    $routes->group('clientes', function ($routes) {
        // grupo de continuação de clientes
        $routes->group('', ['filter' => 'isNotLogged'], function ($routes) {
            $routes->addRedirect('', 'privado/clientes/listar');
            $routes->get('listar', 'Restrict\ClientController::list');
        });
        // grupo adicionar
        $routes->group('adicionar', ['filter' => 'isNotLogged', 'hasUserType', 'hasTelephoneType'], function ($routes) {
            $routes->get('', 'Restrict\ClientController::add');
            $routes->post('', 'Restrict\ClientController::insert');
            // grupo telefone       
            $routes->group('telefone', function ($routes) {
                $routes->post('', 'Restrict\ClientController::addTelephone');
                $routes->get('excluir/(:any)', 'Restrict\ClientController::removeTelephone/$1');
            });
        });
        // grupo editar
        $routes->group('editar', ['filter' => 'isNotLogged', 'hasTelephoneType'], function ($routes) {
            $routes->get('', 'Restrict\ClientController::edit');
            $routes->get('mostrar/(:num)', 'Restrict\ClientController::show/$1');
            $routes->get('excluir_telefone/(:num)', 'Restrict\ClientController::excludeTelephone/$1');
            $routes->post('atualizar_dados', 'Restrict\ClientController::update');
            $routes->post('adicionar_telefone', 'Restrict\ClientController::addNewTelephone');
        });
        // grupo excluir
        $routes->group('', ['filter' => 'isNotLogged', 'hasClient'], function ($routes) {
            $routes->get('excluir/(:num)', 'Restrict\ClientController::exclude/$1');
            $routes->get('deletar/(:num)', 'Restrict\ClientController::delete/$1');
        });
    });
});
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
