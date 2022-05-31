<?php

namespace App\Libraries\Session;

class ShoppingCart {

    /**
     * carrinho de itens
     * @var array
     */
    private $itensCart;

    /**
     * objeto sessão
     * @var \Config\Services::session()
     */
    private $session;

    public function __construct() {
        $this->itensCart = array();
        $this->session = \Config\Services::session();
    }

    /**
     * função para adicionar itens no carrinho
     * @param array 
     */
}
