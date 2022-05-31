<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('styles'); ?>

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
<div class="row">
    <div class="col-md-12 col-lg-6">

        <a href="<?php echo site_url('privado/aquisicoes/adicionar/produtos/listar/todos'); ?>" class="btn btn-success btn-sm">Finalizar este produto</a>

        <hr style="margin-top: 21px;">

        <div class="mt-3">
            <label class="mt-3">Fornecedor:</label>
            <h5>&nbsp;<?php echo esc($provider['corporate_name']); ?></h5>
            <label class="mt-3">Produto:</label>
            <h5>&nbsp;<?php echo esc($productData->product); ?></h5>
            <label class="mt-3">Total de unidades:</label>
            <h5>&nbsp;<?php echo esc($totalProducts); ?></h5>
        </div>

        <hr style="margin-top: 25px;">

        <h4>Adicionar lote</h4>

        <?php echo form_open("privado/aquisicoes/adicionar/lotes/adicionar", ['class' => 'user', 'autocomplete' => 'off']); ?>
        <input type="hidden" value='<?php echo esc($productData->id); ?>' id="storage_id" name="storage_id">
        <div class="form-group row">
            <div class="col-sm-4">
                <label>Lote</label>
                <input type="text" class="form-control <?php echo session('error_validation.batch') ? 'border border-danger' : ''; ?>" id="batch" name="batch" placeholder="Lote">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.batch') ?></h6>
            </div>
            <div class="col-sm-4">
                <label>Quantidade</label>
                <input type="text" class="form-control <?php echo session('error_validation.quantity') ? 'border border-danger' : ''; ?>" id="total" name="total" placeholder="Quantidade">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.total') ?></h6>
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>

    </div>

    <div class="col-md-12 col-lg-6">
        <h4>Lotes adicionados</h4>
        <?php echo $this->include('Restrict/Acquisition/complement/listBatch'); ?>
    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>