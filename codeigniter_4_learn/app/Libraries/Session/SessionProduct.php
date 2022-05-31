<?php

namespace App\Libraries\Session;

class SessionProduct
{

    private $session;

    const DATA_PRODUCT = 'dataProduct_product';
    const DATA_PRODUCT_TYPE = 'dataProductType_product';
    const DATA_BRAND = 'dataBrand_product';
    const DATA_ADDITIONAL = 'additionalData_product';

    public function __construct()
    {

        $this->session = session();
    }

    /**
     * função para adicionar dados de um produto na sessão
     * @param object $product objeto do tipo App\Entities\ProductEntity com dados do produto
     * @return bool
     */
    public function addProduct(object $product): bool
    {

        $dataSession = [
            'id' => $product->id,
            'product_type_id' => $product->product_type_id,
            'description' => $product->description,
            'out_of_production' => $product->out_of_production
        ];

        $this->session->set(self::DATA_PRODUCT, $dataSession);

        return true;
    }

    /**
     * função para pegar dado do produto na sessão
     * @param bool $onlyId sinal para retornar somente o id do produto
     * @return string|array id do produto na sessão | dados do produto na sessão
     */
    public function getProduct(bool $onlyId = false): string|array
    {

        if ($onlyId) {

            return $this->session->get(self::DATA_PRODUCT . '.id');
        } else {

            return $this->session->get(self::DATA_PRODUCT);
        }
    }

    /**
     * função para revomer o produto da sessão
     * @return bool
     */
    public function removeProduct(): bool
    {

        $this->session->remove(self::DATA_PRODUCT);

        return true;
    }

    /**
     * função que adiciona a categoria do produto na sessão para cadastro de um novo produto
     *
     * @param object $productType objeto stdClass
     * @return bool
     */
    public function addProductType(object $productType): bool
    {

        $dataSession = [
            'id' => $productType->id,
            'description' => $productType->description
        ];

        $this->session->set(self::DATA_PRODUCT_TYPE, $dataSession);

        return true;
    }

    /**
     * função que retorna os dados do tipo de produto na sessão
     * @param bool $onlyId retorna dados completos ou somente o id
     * @return array|int dados do tipo de produto na sessão | id do tipo de produto na sessão
     */
    public function getProductType(bool $onlyId = false): array|int
    {

        if ($onlyId) {

            return $this->session->get(self::DATA_PRODUCT_TYPE . '.id');
        }

        return $this->session->get(self::DATA_PRODUCT_TYPE);
    }

    /**
     * função para remover tipo de produto da sessão
     * @return bool
     */
    public function removeProductType(): bool
    {

        $this->session->remove(self::DATA_PRODUCT_TYPE);

        return true;
    }

    /**
     * função que adiciona a marca do produto na sessão para cadastro de um novo produto
     *
     * @param object $brand objeto stdClass
     * @return bool
     */
    public function addBrand(\stdClass $brand): bool
    {

        $dataSession = [
            'id' => $brand->id,
            'description' => $brand->description
        ];

        $this->session->set(self::DATA_BRAND, $dataSession);

        return true;
    }

    /**
     * função que retorna os dados da marca do produto na sessão
     * @param bool $onlyId retorna dados completos ou somente o id
     * @return array|int dados da marca do produto na sessão | id da marca do produto na sessão
     */
    public function getBrand($onlyId = false)
    {

        if ($onlyId) {

            return $this->session->get(self::DATA_BRAND . '.id');
        }

        return $this->session->get(self::DATA_BRAND);
    }

    /**
     * função que adiciona dados adicionais do produto na sessão para cadastro de um novo produto
     *
     * @param array $dataDB
     * @return bool
     */
    public function addAdditionalData(array $dataDB)
    {

        $dataSession = $dataDB;

        $this->session->set(self::DATA_ADDITIONAL, $dataSession);

        return true;
    }

    /**
     * função que retorna os dados adicionais do produto na sessão
     * @param bool $onlyId retorna dados completos ou somente o id
     * @return array|int dados adicionais do produto na sessão | id do dados adicionais do produto na sessão
     */
    public function getAdditionalData($onlyId = false)
    {

        if ($onlyId) {

            return $this->session->get(self::DATA_ADDITIONAL . '.id');
        }

        return $this->session->get(self::DATA_ADDITIONAL);
    }

    /**
     * função para apagar a sessão de clientes
     * @param string $prevURL URL anterior acessada
     * @param bool $checkURL aplicar a operação com checagem de URL
     * @return bool
     */
    function emptyProductSession(string $prevURL = null, bool $checkURL = true): bool
    {

        if ($checkURL) {

            $slicedURL = explode('/', $prevURL);
            if ($slicedURL[1] != 'produtos') {

                $this->session->remove([
                    self::DATA_PRODUCT,
                    self::DATA_PRODUCT_TYPE,
                    self::DATA_BRAND,
                    self::DATA_ADDITIONAL
                ]);
            }
        } else {

            $this->session->remove([
                self::DATA_PRODUCT,
                self::DATA_PRODUCT_TYPE,
                self::DATA_BRAND,
                self::DATA_ADDITIONAL
            ]);
        }

        return true;
    }
}
