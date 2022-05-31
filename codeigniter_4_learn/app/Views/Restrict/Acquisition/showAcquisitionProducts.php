<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Itens do pedido</h1>
</div>

<a href="<?php echo site_url('privado/aquisicoes/mostrar/' . $acquisitionId) ?>" class="btn btn-secondary btn-sm">Voltar</a>

<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">
        <?php if (count($productsAcquisiton) > 0) : ?>
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>
                            Descrição
                        </th>
                        <th class="text-center">
                            Número de lotes
                        </th>
                        <th class="text-center">
                            Quantidade
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productsAcquisiton as $product) : ?>
                        <tr>
                            <td>
                                <?php echo esc($product->description); ?>
                            </td>

                            <?php foreach ($listBatchQuantity as $batch): ?>

                                <?php if ($product->id == $batch['productAcquisitionId']): ?>

                                    <td class="text-center" style="width: 150px;">

                                        <a style="width: 40px;" href="<?php echo site_url('privado/aquisicoes/mostrar/lotes/' . $product->id); ?>" class="btn btn-primary btn-circle btn-sm">
                                            <strong><?php echo esc($batch['batchTotal']); ?></strong>
                                        </a>

                                    </td>

                                <?php endif; ?>

                            <?php endforeach; ?>

                            <td class="text-center" style="width: 150px;">
                                <?php echo esc($product->total); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <h4 class="text-center">Não foi possível obeter os dados</h4>
        <?php endif; ?>
    </div>
</div>
<?php echo $this->endSection(); ?>
