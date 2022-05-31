<?php

namespace App\Libraries\Session;

class SessionAcquisition
{

    private $session;

    const DATA_PROVIDER = 'dataProvider_acquisition';
    const DATA_PRODUCTS_BATCH = 'dataProducts_batch';
    const DATA_PRODUCTS = 'dataProducts_acquisition';
    const DATA_ADDITIONAL = 'additionalData_acquisition';

    public function __construct()
    {

        $this->session = session();
    }

    /**
     * função que adiciona um fornecedor na sessão para cadastro de um novo produto
     *
     * @param object $provider objeto ProviderEntity
     * @return bool
     */
    public function addProvider(\App\Entities\ProviderEntity $provider): bool
    {

        $dataSession = [
            'id' => $provider->id,
            'corporate_name' => $provider->corporate_name
        ];

        $this->session->set(self::DATA_PROVIDER, $dataSession);

        return true;
    }

    /**
     * função que retorna os dados do fornecedor na sessão
     * @param bool $onlyId retorna dados completos ou somente o id
     * @return array|int dados do fornecedor na sessão | id do dados do fornecedor na sessão
     */
    public function getProvider($onlyId = false)
    {

        if ($onlyId) {

            return $this->session->get(self::DATA_PROVIDER . '.id');
        }

        return $this->session->get(self::DATA_PROVIDER);
    }

    /**
     * função que adiciona o lote do produto na sessão
     * @param array $dataBatch dados do lote
     * @param bool $reinsert atualiza todos os lotes na sessão
     * @return bool
     */
    public function addBatch(array $dataBatch, bool $reinsert = false): bool
    {

        if ($reinsert) {

            $this->session->set(self::DATA_PRODUCTS_BATCH, $dataBatch);
        } else {

            if ($this->checkExistsBatchInSession()) {
                if ($this->checkAlreadyExistsBatchInSession($dataBatch['batch'])) {
                    return true;
                }

                $this->session->push(self::DATA_PRODUCTS_BATCH, $this->makeDataBatch($dataBatch));
            } else {

                $this->session->set(self::DATA_PRODUCTS_BATCH, $this->makeDataBatch($dataBatch));
            }

            $this->addTotalProductByBatch($dataBatch);
        }

        return true;
    }

    /**
     * função que prepara os dados do lote para a seesão
     * @param array $dataBatch dados do lote
     * @return array dados da sessão
     */
    private function makeDataBatch($dataBatch)
    {

        $time = new \CodeIgniter\I18n\Time;

        $dataBatch['id_session'] = 'lote-' . $time->getTimestamp();

        $dataSession = [
            $dataBatch
        ];

        return $dataSession;
    }

    /**
     * função que adiciona unidade total de todos os lotes de um produto
     * @param array $dataBatch dados do lote do produto
     * @return bool
     */
    private function addTotalProductByBatch($dataBatch): bool
    {

        $dataProductUpdated = array();
        $dataProduct = $this->getProducts();

        foreach ($dataProduct as $product) {

            if ($product['storage_id'] == $dataBatch['storage_id']) {

                $product['total'] += $dataBatch['total'];
                $dataProductUpdated[] = $product;
            } else {

                $dataProductUpdated[] = $product;
            }
        }

        $this->addProduct($dataProductUpdated, true);

        return true;
    }

    /**
     * remove o total de um produto da sessão com base no seu lote
     * @param int $quantityInBatch quantidade de unidades do produto no lote
     * @param string $storageId id do produto no estoque
     * @return bool
     */
    public function removeTotalProductByBatch(int $quantityInBatch, string $storageId): bool
    {

        $count  = 0;
        $dataProductUpdated = array();
        $dataProduct = $this->getProducts();

        foreach ($dataProduct as $product) {

            if ($product['storage_id'] == $storageId) {

                $product['total'] -= $quantityInBatch;
                $dataProductUpdated[$count] = $product;
            } else {

                $dataProductUpdated[$count] = $product;
            }

            $count++;
        }

        $this->addProduct($dataProductUpdated, true);

        return true;
    }

    /**
     * função que retorna o total de unidades em todos os lotes de um produto
     * @param int $productId id do produto que está sendo adicionado
     * @return int|string total do produtos em todos os lotes
     */
    public function getTotalProductByBatch(int $productId): int|string
    {

        $totalProduct = null;
        $productsData = $this->getProducts();

        foreach ($productsData as $product) {

            if ($product['storage_id'] == $productId) {

                $totalProduct += $product['total'];
            }
        }

        return $totalProduct;
    }

    /**
     * função que remove o lote da sessão
     * @param string $batchId id do lote
     * @return bool
     */
    public function removeBatch(string $batchId): bool
    {

        $count = 0;
        $storageId = null;
        $quantityInBatch = null;
        $batchsInSession = $this->getBatches(null, false);

        foreach ($batchsInSession as $key => $batch) {

            if ($batch['id_session'] == $batchId) {

                $storageId = $batch['storage_id'];
                $quantityInBatch = $batch['total'];

                unset($batchsInSession[$count]);

                $this->removeTotalProductByBatch($quantityInBatch, $storageId);
            }

            $count++;
        }

        $this->addBatch($batchsInSession, true);

        return true;
    }

    /**
     * função que retorna o total de lotes na sessão
     * @return int|string total de lotes
     */
    public function totalBatches(): int|string
    {

        if ($this->session->has(self::DATA_PRODUCTS_BATCH)) {

            return count($this->session->get(self::DATA_PRODUCTS_BATCH));
        }

        return 0;
    }

    /**
     * função que retorna os dados do lote do produto na sessão baseados no id do produto (produto que está sendo editado no momento)
     * @param string $productId id do produto que está sendo editado no momento
     * @param bool $byBatchId pesquisar pela chave 'id_session' ou pela chave 'storage_id'
     * @return array|null dados do lote do produto na sessão
     */
    public function getBatches(string $productId = null, bool $byBatchId = true): array|null
    {

        $batchesProduct = array();

        if ($this->session->has(self::DATA_PRODUCTS_BATCH)) {

            $dataBatch = $this->session->get(self::DATA_PRODUCTS_BATCH);

            if ($byBatchId) {

                foreach ($dataBatch as $batch) {

                    if ($batch['storage_id'] == $productId) {

                        $batchesProduct[] = $batch;
                    }
                }

                return $batchesProduct;
            }

            return $dataBatch;
        }
        return $batchesProduct;
    }

    /**
     * função para checar se existe algum lote adicionado na sessão
     * @return bool
     */
    private function checkExistsBatchInSession(): bool
    {

        if ($this->session->has(self::DATA_PRODUCTS_BATCH) && count($this->session->get(self::DATA_PRODUCTS_BATCH)) > 0) {

            return true;
        } else {

            return false;
        }
    }

    /**
     * função que verifica se já existe um lote na sessão com base na string (campo batch)
     * @param string $batch Lote do produto
     * @return bool
     */
    private function checkAlreadyExistsBatchInSession(string $batch): bool
    {

        $batchDataSesion = $this->session->get(self::DATA_PRODUCTS_BATCH);

        foreach ($batchDataSesion as $dataBatch) {

            if ($dataBatch['batch'] === $batch) {

                return true;
            }
        }

        return false;
    }

    /**
     * função que adiciona o produto na sessão para cadastro de um novo produto da aquisição
     *
     * @param object|array $product (App\Entities\StorageEntity) dados vindos da tabela STORAGE
     * @param bool $reinsert reinserir todos os produtos que já estão na sessão (atualização geral)
     * @return bool
     */
    public function addProduct(object|array $product, bool $reinsert = false): bool
    {

        if ($reinsert) {

            $this->session->set(self::DATA_PRODUCTS, $product);
        } else {

            $dataSession = [
                [
                    'storage_id' => $product->id,
                    'description' => $product->product,
                    'corporate_name' => $product->corporate_name,
                    'total' => '0'
                ]
            ];

            if ($this->checkExistsProductInSession()) {

                if ($this->checkAlreadyExistsProductInSession($product)) {

                    return true;
                }

                $this->session->push(self::DATA_PRODUCTS, $dataSession);
            } else {

                $this->session->set(self::DATA_PRODUCTS, $dataSession);
            }
        }

        return true;
    }

    /**
     * função que retorna os dados do produto na sessão
     * @param bool $onlyId retorna dados completos ou somente o id
     * @return array|int dados do produto na sessão | id do dados do produto na sessão
     */
    public function getProducts(bool $onlyId = false)
    {

        if ($onlyId) {

            return $this->session->get(self::DATA_PRODUCTS . '.id');
        }

        return $this->session->get(self::DATA_PRODUCTS);
    }

    /**
     * funçao que verifica se já exista alguma sessão para $this->dataProducts
     * @return bool
     */
    public function hasDataProduct(): bool
    {

        return $this->session->has(self::DATA_PRODUCTS);
    }

    /**
     * função para checar se existe algum produto adicionado na sessão
     *
     * @return bool
     */
    private function checkExistsProductInSession(): bool
    {

        if ($this->session->has(self::DATA_PRODUCTS) && count($this->session->get(self::DATA_PRODUCTS)) > 0) {

            return true;
        } else {

            return false;
        }
    }

    /**
     * função para checar se o produto já está adicionado na sessão
     *
     * @param \App\Entities\StorageEntity $product
     * @return bool
     */
    private function checkAlreadyExistsProductInSession(\App\Entities\StorageEntity $product): bool
    {

        $productsInSession = $this->session->get(self::DATA_PRODUCTS);

        if ($this->totalProducts() > 0) {

            foreach ($productsInSession as $fromSession) {

                if ($fromSession['storage_id'] === $product->id) {

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * função que incrementa o total de unidades de um produto na sessão com base nos dados de seu lote
     * @param array $dataBatch dados vindos do lote
     * @return bool
     */
    private function addTotalProduct(array $dataBatch): bool
    {

        dd('não está em desuso como imaginei');
        $count = 0;
        $dataProductUpdated = array();
        $dataProduct = $this->session->get($this->dataProducts);

        foreach ($dataProduct as $product) {

            if ($product['storage_id'] == $dataBatch['storage_id']) {

                $product['total'] = $dataBatch['quantity'];
            }

            $dataProductUpdated[$count] = $product;
            $count++;
        }

        $this->addProduct($dataProductUpdated, true);

        return true;
    }

    /**
     * função que remove o total de um produto com base nos dados do seu lote
     * @param int $storageId id do produto no estoque
     * @param int $quantity quantidade do lote do produto
     * @return bool
     */
    private function removeTotalProduct(int $storageId, int $quantity): bool
    {

        $count = 0;
        $productDataSessionUpdated = array();
        $productDataSession = $this->getProducts();

        foreach ($productDataSession as $data) {

            if ($data['storage_id'] == $storageId) {

                $data['total'] = '0';
            }

            $productDataSessionUpdated[$count] = $data;
            $count++;
        }

        $this->addProduct($productDataSessionUpdated, true);

        return true;
    }

    /**
     * função que retorna a quantidade dos produtos na sessão
     *
     * @return int
     */
    public function totalProducts(): int
    {

        if ($this->session->has(self::DATA_PRODUCTS)) {

            return count($this->session->get(self::DATA_PRODUCTS));
        }

        return 0;
    }

    /**
     * função que devolve os produtos com seus respectivos lotes
     * @return array
     */
    public function getProductsAndBatches(): array
    {

        $newProducts = array();
        $products = $this->getProducts();

        foreach ($products as $product) {

            $product['batches'] = $this->getBatches($product['storage_id'], true);
            $newProducts[] = $product;
        }

        return $newProducts;
    }

    /**
     * função que remove o produto da sessão
     *
     * @param int $productId id do produto
     * @return bool
     */
    public function removeFromCart(int $productId): bool
    {

        $productsInSession = $this->getProducts();

        foreach ($productsInSession as $key => $product) {

            if ($product['storage_id'] == $productId) {


                unset($productsInSession[$key]);

                if (count($productsInSession) > 0) {

                    $this->session->addProduct($productsInSession);
                } else {

                    $this->session->remove(self::DATA_PRODUCTS);
                }
                return true;
            }
        }

        return false;
    }

    /**
     * função que adiciona dados adicionais da requisição
     *
     * @param array $additionalData dados vindos do post
     */
    public function addAddtionalData(array $additionalData)
    {

        $additionalData['provider_id'] = $this->session->get(self::DATA_PROVIDER . '.id');
        $additionalData['employee_id'] = $this->session->get('employee_data_session.id');

        $this->session->set(self::DATA_ADDITIONAL, $additionalData);

        return true;
    }

    /**
     * função que retorna os dados adicionais na sessão
     * @param bool $onlyId retorna dados completos ou somente o id
     * @return array dados adicionais na sessão
     */
    public function getAdditionalData()
    {

        return $this->session->get(self::DATA_ADDITIONAL);
    }

    /**
     * função que verifica se existe dados adicionais na sessão
     * @return bool
     */
    public function additionaDataExists(): bool
    {

        return $this->session->has(self::DATA_ADDITIONAL);
    }

    /**
     * função que guarda a url na sessão de venda, funciona apenas com o carrinho
     * @param string $url url
     * @retur bool
     */
    public function setPrevURL($url): bool
    {

        if ($this->session->has('prevURL')) {

            if ('privado/aquisicoes/carrinho/mostrar' === substr($url, strlen(site_url()))) {

                return true;
            }

            $this->session->set('prevURL', substr($url, strlen(site_url())));
        } else {

            $this->session->set('prevURL', substr($url, strlen(site_url())));
        }

        return true;
    }

    /**
     * função para devolver a url na sessão de venda, funciona apenas para o carrinho
     */
    public function getPrevURL()
    {

        return $this->session->get('prevURL');
    }

    /**
     * função para apagar a sessão de aquisicoes
     * @param string $prevURL URL anterior acessada
     * @param bool $checkURL aplicar a operação com checagem de URL
     * @return bool
     */
    public function emptyAcquisitionSession(string $prevURL = null, bool $checkURL = true): bool
    {

        if ($checkURL) {

            $slicedURL = explode('/', $prevURL);

            if ($slicedURL[1] != 'aquisicoes') {

                $this->session->remove([
                    self::DATA_PROVIDER,
                    self::DATA_PRODUCTS_BATCH,
                    self::DATA_PRODUCTS,
                    self::DATA_ADDITIONAL
                ]);
            }
        } else {

            $this->session->remove([
                self::DATA_PROVIDER,
                self::DATA_PRODUCTS_BATCH,
                self::DATA_PRODUCTS,
                self::DATA_ADDITIONAL
            ]);
        }

        return true;
    }
}
