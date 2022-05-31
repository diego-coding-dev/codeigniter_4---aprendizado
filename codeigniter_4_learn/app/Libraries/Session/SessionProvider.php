<?php

namespace App\Libraries\Session;

class SessionProvider {

    private $session;

    const DATA_PROVIDER = 'dataProvider_provider';
    const DATA_TELEPHONE_PROVIDER = 'dataTelephone_provider';

    public function __construct() {

        $this->session = session();
    }

    /**
     * função para adicionar dados do fornecedor na sesão
     * @param int $id id do fornecedor
     * @return bool
     */
    public function addProvider(int $id): bool {

        $dataSession = [
            'provider_id' => $id
        ];

        $this->session->set(self::DATA_PROVIDER, $dataSession);

        return true;
    }

    /**
     * função para retornar todos os dados do fornecedor na sessão
     * @param bool $onlyId somente obter o id do fornecedor
     * @return int|array soment o id do fornecedor | dados do fornecedor
     */
    public function getProvider($onlyId = false): int|array {

        if ($onlyId) {

            return $this->session->get(self::DATA_PROVIDER . '.provider_id');
        }

        return $this->session->get(self::DATA_PROVIDER);
    }

    /**
     * função que adiciona telefone do fornecedor na sessão
     * @param array $telephone dados do telefone do cliente
     * @return bool
     */
    public function addTelephone(array $telephone): bool {

        if ($this->session->has(self::DATA_TELEPHONE_PROVIDER)) {

            if ($this->existsTelephoneInSession($telephone)) {

                return false;
            }

            $this->session->push(self::DATA_TELEPHONE_PROVIDER, $this->makeDataTelephone($telephone));
        } else {

            $this->session->set(self::DATA_TELEPHONE_PROVIDER, $this->makeDataTelephone($telephone));
        }

        return true;
    }

    /**
     * função que prepara os dados do telefone para a seesão
     * @param array $telephone dados do telefone
     * @return array dados da sessão
     */
    private function makeDataTelephone($telephone) {

        $time = new \CodeIgniter\I18n\Time;

        $telephone['id_session'] = 'telephone-' . $time->getTimestamp();
        $telephoneDataSplit = explode('-', $telephone['telephone_type']);
        $telephone['telephone_type_id'] = $telephoneDataSplit[0];
        $telephone['telephone_description'] = $telephoneDataSplit[1];

        $dataSession = [
            $telephone
        ];

        return $dataSession;
    }

    /**
     * função que verifica se os telefone já existe na sessão
     * @param array $dataTelephone telefone a ser inserido na sessão para cadastrar novo fornecedor
     * @return bool
     */
    private function existsTelephoneInSession(array $dataTelephone): bool {

        $telephoneList = $this->getTelephones();

        foreach ($telephoneList as $telephone) {

            if ($telephone['telephone'] == $dataTelephone['telephone']) {

                return true;
            }
        }

        return false;
    }

    /**
     * função que devolve todos os telefones do fornecedor da sessão
     * @return null|array telefones do cliente
     */
    public function getTelephones(): null|array {

        return $this->session->get(self::DATA_TELEPHONE_PROVIDER);
    }

    /**
     * função que exclui telefone da sessão
     * @param string $idSession id de sessão do fornecedor
     * @return bool
     */
    public function removeTelephone($idSession) {

        $telephoneList = $this->getTelephones();

        foreach ($telephoneList as $key => $telephone) {

            if ($telephone['id_session'] == $idSession) {

                unset($telephoneList[$key]);
            }
        }

        return $this->reinsertTelephone($telephoneList);
    }

    /**
     * função que reinsere dados do telefone na sessão (atualização)
     * @param array $telephoneList telefones do fornecedor
     * @return bool
     */
    private function reinsertTelephone($telephoneList): bool {

        $this->session->set(self::DATA_TELEPHONE_PROVIDER, $telephoneList);

        return true;
    }
    
    /**
     * função para apagar a sessão de fornecedor
     * @param string $prevURL URL anterior acessada
     * @param bool $checkURL aplicar a operação com checagem de URL
     * @return bool
     */
    function emptyProviderSession(string $prevURL = null, bool $checkURL = true): bool {

        if ($checkURL) {

            $slicedURL = explode('/', $prevURL);
            if ($slicedURL[1] != 'fornecedores') {

                $this->session->remove([
                    self::DATA_PROVIDER,
                    self::DATA_TELEPHONE_PROVIDER
                ]);
            }
        } else {

            $this->session->remove([
                self::DATA_PROVIDER,
                self::DATA_TELEPHONE_PROVIDER
            ]);
        }

        return true;
    }

}
