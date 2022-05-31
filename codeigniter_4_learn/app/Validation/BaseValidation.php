<?php

namespace App\Validation;

class BaseValidation {

    /**
     * função que seleciona as regras que serão utilizadas com base nos campos fornecidos pelo POST
     * @param array dados vindo do POST
     * @param array regras vindas da classe UserValidation
     * @return array regras que serão utilizadas na validação
     */
    protected function selectRules(array $dataDB, array $rules): array {

        $rulesSelected = array();

        foreach ($dataDB as $keyData => $valueData) {

            foreach ($rules as $keyRules => $valueRules) {

                if ($keyRules === $keyData) {

                    $rulesSelected[$keyRules] = $valueRules;
                }
            }
        }

        return $rulesSelected;
    }

    /**
     * função que seleciona os dados vindo do POST
     * @param array dados vindos do POST
     * @return array|null dados vindos do POST já selecionados
     */
    protected function checkEmptyFields(array $dataDB): array|null {

        foreach ($dataDB as $key => $value) {

            if (empty($dataDB[$key])) {

                unset($dataDB[$key]);
            }
        }

        return $dataDB;
    }

}
