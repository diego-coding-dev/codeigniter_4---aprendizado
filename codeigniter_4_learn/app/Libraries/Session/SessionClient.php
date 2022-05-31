<?php

namespace App\Libraries\Session;

class SessionClient {

    private $session;

    const DATA_CLIENT = 'dataClient_client';
    const DATA_TELEPHONE_CLIENT = 'dataTelephone_client';

    function __construct() {

        $this->session = session();
    }

    /**
     * função para adicionar dados do cliente na sesão
     * @param int $id id do cliente
     * @return bool
     */
    public function addClient(int $id): bool {

        $dataSession = [
            'client_id' => $id
        ];

        $this->session->set(self::DATA_CLIENT, $dataSession);

        return true;
    }

    /**
     * função para retornar todos os dados do cliente na sessão
     * @param bool $onlyId somente obter o id do cliente
     * @return int|array soment o id do cliente | dados do cliente
     */
    public function getClient($onlyId = false): int|array {

        if ($onlyId) {

            return $this->session->get(self::DATA_CLIENT . '.client_id');
        }

        return $this->session->get(self::DATA_CLIENT);
    }

    /**
     * função que adiciona telefone do cliente na sessão
     * @param array $telephone dados do telefone do cliente
     * @return bool
     */
    public function addTelephone(array $telephone): bool {

        if ($this->session->has(self::DATA_TELEPHONE_CLIENT)) {

            if ($this->existsTelephoneInSession($telephone)) {

                return false;
            }

            $this->session->push(self::DATA_TELEPHONE_CLIENT, $this->makeDataTelephone($telephone));
        } else {

            $this->session->set(self::DATA_TELEPHONE_CLIENT, $this->makeDataTelephone($telephone));
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
     * @param array $dataTelephone telefone a ser inserido na sessão para cadastrar novo cliente
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
     * função que devolve todos os telefones do cliente da sessão
     * @return null|array telefones do cliente
     */
    public function getTelephones(): null|array {

        return $this->session->get(self::DATA_TELEPHONE_CLIENT);
    }

    /**
     * função que exclui telefone da sessão
     * @param string $idSession id de sessão do cliente
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
     * @param array $telephoneList telefones do cliente
     * @return bool
     */
    private function reinsertTelephone($telephoneList): bool {

        $this->session->set(self::DATA_TELEPHONE_CLIENT, $telephoneList);

        return true;
    }

    /**
     * função para apagar a sessão de clientes
     * @param string $prevURL URL anterior acessada
     * @param bool $checkURL aplicar a operação com checagem de URL
     * @return bool
     */
    function emptyClientSession(string $prevURL = null, bool $checkURL = true): bool {

        if ($checkURL) {

            $slicedURL = explode('/', $prevURL);
            if ($slicedURL[1] != 'clientes') {

                $this->session->remove([
                    self::DATA_CLIENT,
                    self::DATA_TELEPHONE_CLIENT
                ]);
            }
        } else {

            $this->session->remove([
                self::DATA_CLIENT,
                self::DATA_TELEPHONE_CLIENT
            ]);
        }

        return true;
    }

}
