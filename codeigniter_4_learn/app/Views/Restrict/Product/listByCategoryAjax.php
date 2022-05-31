<?php if (count($productsList) > 0) : ?>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>
                    Descrição
                </th>
                <th>
                    Categoria
                </th>
                <th>
                    Valor de custo(R$)
                </th>
                <th>
                    Valor de venda(R$)
                </th>
                <th>
                    Ações
                </th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($productsList as $product) : ?>
                <tr>
                    <td>
                        <?php echo esc($product->description); ?>
                    </td>
                    <td>
                        <?php echo esc($product->category); ?>
                    </td>
                    <td class="presentMoney">
                        <?php echo esc($product->cost_price); ?>
                    </td>
                    <td class="presentMoney">
                        <?php echo esc($product->sale_price); ?>
                    </td>
                    <td style="width: 110px;">
                        <a href="<?php echo site_url('privado/produtos/mostrar/' . $product->id) ?>" style="text-decoration: none;"><i class="fas fa-fw fa-eye fa-lg"></i></a>
                        <a href="<?php echo site_url('privado/produtos/excluir/' . $product->id) ?>" style="text-decoration: none;"><i class="fas fa-fw fa-trash fa-lg"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <h4 class="text-center">Não há produtos nesta categoria</h4>
<?php endif; ?>