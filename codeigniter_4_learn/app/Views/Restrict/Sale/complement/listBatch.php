<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">
        <?php if ($listBatch) : ?>

            <?php if (count($listBatch) > 0) : ?>
                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th>
                                Lote
                            </th>
                            <th>
                                Quantidade
                            </th>
                            <th class="text-center">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listBatch as $batch) : ?>
                            <tr>
                                <td>
                                    <?php echo esc($batch['batch']); ?>
                                </td>
                                <td style="width: 110px;">
                                    <?php echo esc($batch['total']); ?>
                                </td>
                                <td class="text-center" style="width: 110px;">
                                    <a href="<?php echo site_url('privado/aquisicoes/adicionar/lotes/remover/' . $batch['id_session'] . '/' . $productData->id) ?>" class="text-danger" style="text-decoration: none;"><i class="fas fa-fw fa-trash fa-lg"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        <?php else : ?>
            <h5 class="text-center text-danger" style="margin-top: 55px;">Não há lotes adicionados</h5>
        <?php endif; ?>
    </div>
</div>