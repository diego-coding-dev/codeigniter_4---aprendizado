<?php

namespace App\Validation;

class ClientValidation extends BaseValidation
{

    private $rules = [
        'first_name' => [
            'label' => 'first_name',
            'rules' => 'required'
        ],
        'last_name' => [
            'label' => 'last_name',
            'rules' => 'required'
        ],
        'address' => [
            'label' => 'address',
            'rules' => 'required'
        ],
        'address_complement' => [
            'label' => 'address_complement',
            'rules' => 'permit_empty|max_length[100]'
        ],
        'email' => [
            'label' => 'email',
            'rules' => 'required'
        ],
        'telephone' => [
            'label' => 'telephone',
            'rules' => 'required|regex_match[/^\([1-9]{2}\) [0-9]{4,5}\-[0-9]{4}$/]|is_unique[clients_phone.telephone]'
        ],
        'telephone_type' => [
            'label' => 'telephone_type',
            'rules' => 'required'
        ]
    ];
    private $rulesMessageErrors = [
        'first_name' => [
            'required' => 'O primeiro nome é obrigatório.'
        ],
        'last_name' => [
            'required' => 'O último nome é obrigatório.'
        ],
        'address' => [
            'required' => 'O endereço é obrigatório.'
        ],
        'address_complement' => [
            'max_length' => 'Complemento de endereço execede o tamanho permitido.'
        ],
        'email' => [
            'required' => 'O email é obrigatório.'
        ],
        'telephone' => [
            'required' => 'O telefone é obrigatório.',
            'regex_match' => 'Telefone está com formato inválido.',
            'is_unique' => 'Este telefone já está cadastrado'
        ],
        'telephone_type' => [
            'required' => 'Escolha o tipo de telefone.'
        ]
    ];

    /**
     * função que devolve as regras de validação
     * @return array regras de validação
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * função que devolve as mensagens de erro de validação
     * @return array mensagens de erro de validação
     */
    public function getRulesErrors(): array
    {
        return $this->rulesMessageErrors;
    }

    /**
     * função que seleciona as regras que serão utilizadas com base nos campos fornecidos pelo POST
     * @param array dados vindo do POST
     * @return array regras que serão utilizadas na validação
     */
    public function selectRulesToValid(array $dataDB): array
    {
        return parent::selectRules($dataDB, $this->getRules());
    }

    /**
     * função que seleciona os dados vindo do POST que não estão vazios
     * @param array dados vindos do POST
     * @return array|null dados vindos do POST já selecionados
     */
    public function checkEmptyFields($dataDB): array|null
    {
        return parent::checkEmptyFields($dataDB);
    }
}
