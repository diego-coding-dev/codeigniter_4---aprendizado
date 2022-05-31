<?php

namespace App\Validation;

class ProviderValidation extends BaseValidation {

    private $rules = [
        'corporate_name' => [
            'label' => 'corporate_name',
            'rules' => 'required'
        ],
        'cnpj' => [
            'label' => 'cnpj',
            'rules' => 'required|regex_match[/^(\d{2}\.?\d{3}\.?\d{3}\/?\d{4}-?\d{2})$/]'
        ],
        'contact' => [
            'label' => 'contact',
            'rules' => 'required'
        ],
        'address' => [
            'label' => 'address',
            'rules' => 'required'
        ],
        'address_complement' => [
            'label' => 'address',
            'rules' => 'permit_empty'
        ],
        'email' => [
            'label' => 'email',
            'rules' => 'required'
        ],
        'telephone' => [
            'label' => 'telephone',
            'rules' => 'required|regex_match[/^\([1-9]{2}\) [0-9]{4,5}\-[0-9]{4}$/]|is_unique[providers_phone.telephone]'
        ],
        'telephone_type' => [
            'label' => 'telephone_type',
            'rules' => 'required'
        ]
    ];
    private $rulesMessageErrors = [
        'corporate_name' => [
            'required' => 'A razão social é obrigatório.',
        ],
        'cnpj' => [
            'required' => 'O CNPJ é obrigatório.',
            'regex_match' => 'CNPJ em formato inválido.'
        ],
        'contact' => [
            'required' => 'O contato é obrigatório.'
        ],
        'address' => [
            'required' => 'O endereço é obrigatório.'
        ],
        'email' => [
            'required' => 'O email é obrigatório.'
        ],
        'telephone' => [
            'required' => 'O telefone é obrigatório.',
            'regex_match' => 'O telefone está com formato inválido.',
            'is_unique' => 'Este telefone já está cadastrado.'
        ],
        'telephone_type' => [
            'required' => 'Escolha o tipo do telefone.'
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
