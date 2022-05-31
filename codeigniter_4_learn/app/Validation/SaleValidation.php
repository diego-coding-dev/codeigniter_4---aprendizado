<?php

namespace App\Validation;

class SaleValidation extends BaseValidation {

    private $rules = [
        'document_number' => [
            'label' => 'document_number',
            'rules' => 'required|max_length[20]|is_unique[sales.document_number]'
        ],
        'operation_value' => [
            'label' => 'operation_value',
            'rules' => 'required'
        ]
    ];
    private $rulesMessageErrors = [
        'document_number' => [
            'required' => 'NF é obrigatório.',
            'max_length' => 'O padrão está incorreto.',
            'is_unique' => 'Esta NF já está cadastrada.'
        ],
        'operation_value' => [
            'required' => 'O valor da NF é obrigatório.'
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
