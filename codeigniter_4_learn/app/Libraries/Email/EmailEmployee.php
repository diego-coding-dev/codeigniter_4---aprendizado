<?php

namespace App\Libraries\Email;

class EmailEmployee {

    private $email;
    private $token;
    private $time;

    function __construct() {

        $this->email = \Config\Services::email();
        $this->token = \Config\Services::tokenService('Token');
        $this->time = \Config\Services::timeService(null, '+120 min');
    }

    /**
     * função para enviar token de ativação para o email do funcionário
     * @param array $dataDB dados do funcionários vindo do formulário
     * @return bool|array - retorna "bool" se o email falhar | retorna "array" se o email for enviado
     */
    public function sendActivationToken(array $dataDB): bool|array {

        $this->email->setFrom(env('email.SMTPUser'), env('NAME_EMAIL'));
        $this->email->setTo($dataDB['email']);
        $this->email->setSubject('Email Test number 2');
        $this->email->setMessage(view('Restrict/Employee/complement/activationTokenEmail', ['token_activation' => $this->token->getToken()]));

        if ($this->email->send()) {

            $dataDB['activation_hash'] = $this->token->getHash();
            $dataDB['expired_hash_in'] = $this->time->format('Y-m-d H:i:s');

            return $dataDB;
        }

        return false;
    }

}
