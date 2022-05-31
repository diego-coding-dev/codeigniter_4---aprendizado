<?php

namespace App\Libraries\Session;

class SessionStorage
{

    private $session;

    const DATA_PRODUCT = 'productData_storage';

    public function __construct()
    {

        $this->session = session();
    }

    /**
     * função para adicionar id do produto do estoque na sessão
     * @param object|array $productData objeto de App\Entities\StorageEntity | array dados do produto
     * @param bool $update atualização das informações do produto
     * @return bool
     */
    function addProduct(object|array $productData, bool $update = false): bool
    {

        if ($update) {
            // atualiza todos os dados
        } else {

            $dataSession = [
                'storage_id' => $productData->id,
                'product_id' => $productData->product_id
            ];
        }

        $this->session->set(self::DATA_PRODUCT, $dataSession);

        return true;
    }

    /**
     * função para retornar dados do produto no estoque da sessão
     * @param bool $onlyId retornar apenas o id do produto no estoque
     * @return array|string todos os dados do produto do estoque na sessão|id do produto do estoque na sessão
     */
    public function getProduct(bool $onlyId = false): array|string
    {

        if ($onlyId) {

            return $this->session->get(self::DATA_PRODUCT . '.storage_id');
        }

        return $this->session->get(self::DATA_PRODUCT);
    }

    /**
     * função para apagar a sessão de estoque
     * @param string $prevURL URL anterior acessada
     * @param bool $checkURL aplicar a operação com checagem de URL
     * @return bool
     */
    function emptyStorageSession(string $prevURL = null, bool $checkURL = true): bool
    {

        if ($checkURL) {

            $slicedURL = explode('/', $prevURL);
            if ($slicedURL[1] != 'estoque') {

                $this->session->remove([
                    self::DATA_PRODUCT,
                ]);
            }
        } else {

            $this->session->remove([
                self::DATA_PRODUCT,
            ]);
        }

        return true;
    }
}
