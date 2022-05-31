<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('styles'); ?>
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
<div class="row">
    <div class="col-md-12 col-lg-6">

        <a href="<?php echo site_url('privado/vendas/adicionar/produtos/listar/todos'); ?>" class="btn btn-secondary btn-sm mb-3">Voltar</a>

        <hr style="margin-top: 0px;">

        <div class="mt-3">
            <label>Produto:</label>
            <h5>&nbsp;<?php echo esc($productData->product); ?></h5>
        </div>

        <hr style="margin-top: 25px;">

        <div class="mt-3">
            <label>Quantidade em estoque:</label>
            <h5>&nbsp;<?php echo esc($productData->total); ?>&nbsp;unidades</h5>
        </div>

        <hr style="margin-top: 25px;">

        <?php echo form_open("privado/vendas/adicionar/produtos/finalizar", ['class' => 'user', 'autocomplete' => 'off']); ?>

        <input type="hidden" value='<?php echo esc($productData->product); ?>' id="product" name="product">

        <div class="form-group row">

            <input type="hidden" value='<?php echo esc($productData->id); ?>' id="storage_id" name="storage_id">

            <div class="col-sm-4">
                <label>Quantidade</label>
                <input type="text" class="form-control <?php echo session('error_validation.quantity') ? 'border border-danger' : ''; ?>" id="total" name="total" placeholder="Quantidade">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.total') ?></h6>
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary">ok</button>
            </div>
        </div>

        <?php echo form_close(); ?>

    </div>

</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>