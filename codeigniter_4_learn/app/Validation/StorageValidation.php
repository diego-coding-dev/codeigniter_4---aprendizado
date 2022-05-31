<?php

namespace App\Validation;

class StorageValidation extends BaseValidation {

    private $rules = [
        'cost_price' => [
            'label' => 'cost_price',
            'rules' => 'required|permit_empty'
        ],
        'sale_price' => [
            'label' => 'sale_price',
            'rules' => 'required|permit_empty'
        ]
    ];
    private $rulesMessageErrors = [
        'cost_price' => [
            'required' => 'O preço de custo é obrigatório.'
        ],
        'sale_price' => [
            'required' => 'O preço de venda é obrigatório.'
        ]
    ];

    /**
     * função que devolve as regras de validação
     * @return array regras de validação
     */
    public function getRules(): array {
        return $this->rules;
    }

    /**
     * função que devolve as mensagens de erro de validação
     * @return array mensagens de erro de validação
     */
    public function getRulesErrors(): array {
        return $this->rulesMessageErrors;
    }

    /**
     * função que seleciona as regras que serão utilizadas com base nos campos fornecidos pelo POST
     * @param array dados vindo do POST
     * @return array regras que serão utilizadas na validação
     */
    public function selectRulesToValid(array $dataDB): array {
        return parent::selectRules($dataDB, $this->getRules());
    }

    /**
     * função que seleciona os dados vindo do POST que não estão vazios
     * @param array dados vindos do POST
     * @return array|null dados vindos do POST já selecionados
     */
    public function checkEmptyFields($dataDB): array|null {
        return parent::checkEmptyFields($dataDB);
    }

}
