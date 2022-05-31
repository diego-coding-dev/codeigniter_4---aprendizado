<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Registrando nova aquisição</h1>
</div>

<div class="mb-3">
    <a href="<?php echo site_url('privado/aquisicoes/listar') ?>" class="btn btn-danger btn-sm">Voltar</a>
    <?php echo $this->include('Restrict/Acquisition/complement/resumeModal'); ?>
    <a href="<?php echo site_url('privado/aquisicoes/adicionar/carrinho/mostrar') ?>" class="btn btn-primary btn-sm"> <i class="fa fa-shopping-cart">&nbsp;<?php echo $totalInCart; ?></i></a>
</div>

<?php echo $this->include('Restrict/Acquisition/complement/navTabs'); ?>

<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">
        <?php if ($totalInCart > 0 && $totalBatches > 0) : ?>

            <a href="<?php echo site_url('privado/aquisicoes/adicionar/dados_adicionais') ?>" class="btn btn-success btn-sm">Dados adicionais</a>

        <?php endif; ?>

        <?php if (count($productsList) > 0) : ?>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productsList as $product) : ?>
                        <tr>
                            <td>
                                <?php echo esc($product->product); ?>
                            </td>
                            <td>
                                <?php echo esc($product->category); ?>
                            </td>
                            <td style="width: 110px;"><a href="<?php echo site_url('privado/aquisicoes/adicionar/produtos/selecionar/' . $product->id); ?>" style="text-decoration: none;" type="button" class="btn btn-success btn-inline btn-sm"><i class="fas fa-fw fa-plus fa-sm"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <hr>
            <?php echo $pager->links(); ?>

        <?php else : ?>
            <h4 class="text-center">Não há produtos registrados</h4>
        <?php endif; ?>
    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>