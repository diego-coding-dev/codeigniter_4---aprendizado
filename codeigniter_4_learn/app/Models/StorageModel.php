<?php

namespace App\Models;

use CodeIgniter\Model;

class StorageModel extends Model {

    protected $DBGroup = 'default';
    protected $table = 'storage';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'App\Entities\StorageEntity';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'quantity', 'cost_price', 'sale_price'
    ];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * função que insere o produto no estoque, por transaction (quando cadastra o produto)
     * @param int $productId id do produto recém registrado no sistema
     * @return bool
     */
    public function addInStorage(int $productId): bool {

        $dataDB['product_id'] = $productId;

        return $this->protect(false)->insert($dataDB);
    }

    /**
     * função que atualiza dados do produto no estoque
     * @param int $storageId id do estoque do produto
     * @param array $dataDB dados para serem atualizados
     * @return bool
     */
    public function updateStorage(int $storageId, array $dataDB) {

        $db = db_connect();

        return $db->table($this->table)->where('id', $storageId)->update($dataDB);
    }

    /**
     * função que retorna um item existente no estoque
     * @param array $dataDB dados para verificar na cláusula WHERE
     * @return object|null App\Entities\StorageEntity | null
     */
    public function getFromStorage(array $dataDB): object|null {

        return $this->setTable('storage_view')->where($dataDB)->first();
    }

    /**
     * função que seleciona todos os produtos do estoque
     * @param $storage produto do estoque
     * @return array
     */
    public function getDistinctAll(string $storage): array {

        if ($storage === 'todos' || !$storage) {

            return $this->setTable('storage_products_distinct_view')->paginate(10);
        } else {

            return $this->setTable('storage_products_distinct_view')->like('product', str_replace('-', ' ', $storage), 'both')->paginate(10);
        }
    }

    /**
     * função que atualiza a quantidade de um determinado produto no estoque
     * @param int $storageId id do estoque do produto
     * @param string $total total do produto a ser atualizado
     * @param string $operation operação a ser realizada, 'sum' para soma e 'sub' para subtração
     * @return bool
     */
    public function updateQuantityByTransaction(int $storageId, string $total, string $operation): bool {

        $db = db_connect();

        switch ($operation) {
            case 'sum':

                $db->query('CALL add_product_storage(' . $storageId . ',' . $total . ')');
                break;

            case 'sub':

                $db->query('CALL remove_product_storage(' . $storageId . ',' . $total . ')');
                break;
        }

        return true;
    }

    /**
     * função que retorna o total de um produto, independente do fornecedor
     * @param object $dataProduct dados de um determinado produto 
     * @return int total de produtos
     */
    public function getTotalProducts($dataProduct): int {

        $db = db_connect();

        $result = $db->table('storage_view')->select('total')->where('deleted_at', null)->where('product_id', $dataProduct->product_id)->get()->getResult();

        foreach ($result as $row) {

            return $row->total;
        }
    }

    /**
     * função para atualizar o total pelo id (por transaction em SaleModel)
     * @param int $storageId id do estoque
     * @param int $total total do produto no estoque para ser atualizado
     * @return bool
     */
    function updateTotalById(int $storageId, int $total): bool {

        $db = db_connect();

        return $db->table('storage')->where('id', $storageId)->update(['total' => $total]);
    }

}
