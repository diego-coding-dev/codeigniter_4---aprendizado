<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class EmployeeEntity extends Entity {

    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];
    private $token;

    public function __construct() {

        $this->token = \Config\Services::tokenService('Token');
    }

    /**
     * função que verifica a senha
     * @param string password
     * @return bool
     */
    public function checkPassword(string $password) {

        return password_verify($password, $this->password_hash);
    }

    /**
     * função para gerar o token para o funcionario
     * @return void
     */
    public function activationToken(): void {

        $serviceToken = \Config\Services::tokenService('Token');
        $time = \Config\Services::timeService(null, '+120 min');

        $this->activation_token = $serviceToken->getHash();

        $this->reset_hash = $serviceToken->getToken();

        $this->expired_hash_in = $time->format('Y-m-d H:i:s');
    }
    
    public function prepareCredential($dataDB) {
        
        $this->e_password_hash = password_hash($dataDB['password_hash'], PASSWORD_DEFAULT);
        $this->e_username = $dataDB['username'];
        $this->e_password = $dataDB['password_hash'];
    }

}
