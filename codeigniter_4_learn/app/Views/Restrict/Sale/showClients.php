<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Registrando nova venda</h1>
</div>

<div class="mb-3">
    <a href="<?php echo site_url('privado/vendas/listar') ?>" class="btn btn-danger btn-sm">Voltar</a>

    <?php echo $this->include('Restrict/Sale/complement/resumeModal'); ?>

    <a href="<?php echo site_url('privado/vendas/adicionar/carrinho/mostrar') ?>" class="btn btn-primary btn-sm"> <i class="fa fa-shopping-cart">&nbsp;<?php echo $totalInCart; ?></i></a>
</div>

<?php echo $this->include('Restrict/Sale/complement/navTabs'); ?>

<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">
        <?php if (count($clientsList) > 0) : ?>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>
                            Nomes
                        </th>
                        <th>
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientsList as $client) : ?>
                        <tr>
                            <td>
                                <?php echo esc($client->first_name . ' ' . $client->last_name); ?>
                            </td>
                            <td style="width: 110px;">
                                <a href="<?php echo site_url('privado/vendas/adicionar/clientes/selecionar/' . $client->id); ?>" style="text-decoration: none;" type="button" class="btn btn-success btn-inline btn-sm"><i class="fas fa-fw fa-plus fa-sm"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <hr>
            <?php echo $pager->links(); ?>

        <?php else : ?>
            <h4 class="text-center">Não há clientes registrados</h4>
        <?php endif; ?>
    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>