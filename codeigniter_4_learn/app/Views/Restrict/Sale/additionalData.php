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

        <?php echo form_open("privado/vendas/adicionar/dados_adicionais/inserir", ['class' => 'user', 'autocomplete' => 'off']); ?>

        <div class="form-group row">
            <div class="col-sm-4">
                <label>Número do NF</label>
                <input type="text" class="form-control <?php echo session('error_validation.document_number') ? 'border border-danger' : ''; ?>" id="document_number" name="document_number" placeholder="Número do documento">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.document_number') ?></h6>
            </div>
            <div class="col-sm-4">
                <label>Valor</label>
                <input type="text" class="money form-control <?php echo session('error_validation.operation_value') ? 'border border-danger' : ''; ?>" id="operation_value" name="operation_value" placeholder="Valor">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.operation_value') ?></h6>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">
            Adicionar
        </button>

        <?php echo form_close(); ?>

    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>