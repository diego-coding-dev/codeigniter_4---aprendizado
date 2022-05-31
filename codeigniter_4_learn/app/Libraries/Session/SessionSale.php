<?php

namespace App\Libraries\Session;

class SessionSale
{

    private $session;

    const DATA_CLIENT = 'dataClient_sale';
    const DATA_PRODUCTS = 'dataProducts_sale';
    const DATA_SIGNAL_CART = 'signalCart_sale';
    const DATA_ADDITIONAL = 'additionalData_sale';

    public function __construct()
    {

        $this->session = session();
    }

    /**
     * função para adicionar dados do cliente na sessão
     * @param object $dataClient dados do cliente do tipo ClientEntity
     * @return bool
     */
    public function addClient(object $dataClient): bool
    {

        $dataSession = [
            'client_id' => $dataClient->id,
            'first_name' => $dataClient->first_name,
            'last_name' => $dataClient->last_name
        ];

        $this->session->set(self::DATA_CLIENT, $dataSession);

        return true;
    }

    /**
     * função para retornar dados do cliente na sessão
     * @param bool $onlyId retornar ou não somente o id do cliente
     * @return int|array id do cliente | todos os dados
     */
    public function getClient(bool $onlyId = false)
    {

        if ($onlyId) {

            return $this->session->get(self::DATA_CLIENT . '.client_id');
        }

        return $this->session->get(self::DATA_CLIENT);
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
     * função que adiciona o produto na sessão para cadastro de um novo produto(estoque) da venda
     *
     * @param object|array $product (App\Entities\StorageEntity) dados vindos da tabela STORAGE
     * @param bool $reinsert reinserir todos os produtos que já estão na sessão (atualização geral)
     * @return bool
     */
    public function addProduct(object|array $product, bool $reinsert = false): bool
    {

        $time = new \CodeIgniter\I18n\Time;

        if ($reinsert) {

            $this->session->set(self::DATA_PRODUCTS, $product);
        } else {

            $dataSession = [
                [
                    'session_id' => 'prod-' . $time->getTimestamp(),
                    'storage_id' => $product['storage_id'],
                    'product' => $product['product'],
                    'total' => $product['total']
                ]
            ];

            if ($this->checkExistsProductInSession()) {

                $this->session->push(self::DATA_PRODUCTS, $dataSession);
            } else {

                $this->session->set(self::DATA_PRODUCTS, $dataSession);
            }
        }

        return true;
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
     * @param array $product dados do produto
     * @return bool
     */
    public function checkAlreadyExistsProductInSession(array $product): bool
    {

        $productsInSession = $this->session->get(self::DATA_PRODUCTS);

        if ($this->totalProducts() > 0) {

            foreach ($productsInSession as $fromSession) {

                if ($fromSession['storage_id'] === $product['storage_id']) {

                    return true;
                }
            }
        }

        return false;
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
     * função que guarda sinalizadores para caso de algum erro com o item do carrinho
     * @param array $signals sinalizadores para cada item do carrinho
     * @return bool
     */
    public function setSignal(array $signals): bool
    {

        $this->session->set(self::DATA_SIGNAL_CART, $signals);

        return true;
    }

    /**
     * funçãp que devolve os sinalizadores para os itens do carrinho
     * @return array sinalizadores dos itens do carrinho
     */
    public function getSignal(): array
    {

        return $this->session->get(self::DATA_SIGNAL_CART);
    }

    /**
     * função que confirma se há itens de erros do carrinho na sessão
     * @return bool
     */
    public function hasErrorsItensCart(): bool
    {

        return $this->session->has(self::DATA_SIGNAL_CART);
    }

    /**
     * função que remove o produto da sessão
     *
     * @param string $productId id do produto
     * @return bool
     */
    public function removeFromCart(string $productId): bool
    {

        $productsInSession = $this->getProducts();

        foreach ($productsInSession as $key => $product) {

            if ($product['session_id'] == $productId) {


                unset($productsInSession[$key]);

                if (count($productsInSession) > 0) {

                    $this->addProduct($productsInSession, true);
                } else {

                    $this->session->remove(self::DATA_PRODUCTS);
                }
                return true;
            }
        }

        return false;
    }

    /**
     * função que adiciona dados adicionais da venda
     *
     * @param array $additionalData dados vindos do post
     */
    public function addAddtionalData(array $additionalData)
    {

        $additionalData['client_id'] = $this->getClient(true);
        $additionalData['employee_id'] = $this->session->get('employee_data_session.id');

        $this->session->set(self::DATA_ADDITIONAL, $additionalData);

        return true;
    }

    /**
     * função para retornar os dados adicionais da venda
     * @return array dados adicionais da venda
     */
    public function getAdditionalData(): array
    {

        return $this->session->get(self::DATA_ADDITIONAL);
    }

    /**
     * funçao que verifica se já exista alguma sessão para 'dataProducts_acquisition'
     * @return bool
     */
    public function hasDataProduct(): bool
    {

        return $this->session->has(self::DATA_PRODUCTS);
    }

    /**
     * função que guarda a url na sessão de venda, funciona apenas com o carrinho
     * @param string $url url
     * @retur bool
     */
    public function setPrevURL($url): bool
    {

        if ($this->session->has('prevURL')) {

            if ('privado/vendas/adicionar/carrinho/mostrar' === substr($url, strlen(site_url()))) {

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
     * função para apagar a sessão de vendas
     * @param string $prevURL URL anterior acessada
     * @param bool $checkURL aplicar a operação com checagem de URL
     * @return bool
     */
    public function emptySaleSession(string $prevURL = null, bool $checkURL = true): bool
    {

        if ($checkURL) {

            $slicedURL = explode('/', $prevURL);

            if ($slicedURL[1] != 'vendas') {

                $this->session->remove([
                    self::DATA_CLIENT,
                    self::DATA_PRODUCTS,
                    self::DATA_SIGNAL_CART,
                    self::DATA_ADDITIONAL
                ]);
            }
        } else {

            $this->session->remove([
                self::DATA_CLIENT,
                self::DATA_PRODUCTS,
                self::DATA_SIGNAL_CART,
                self::DATA_ADDITIONAL
            ]);
        }

        return true;
    }
}
