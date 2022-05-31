<?php

namespace App\libraries;

class Token {

    private $token;

    public function __construct($token = null) {

        if ($token == null) {

            $this->token = bin2hex(random_bytes(16));
        } else {

            $this->token = $token;
        }
    }

    /**
     * função para retornar um hash chaveado
     * @return string hash do token
     */
    public function getHash(): string {

        return hash_hmac('sha256', $this->token, env('KEY_TOKEN'));
    }

    /**
     * função que retorna um hash já chaveado
     * @return string hash do token
     */
    public function getToken(): string {

        return $this->token;
    }

}
