<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('styles'); ?>

<style>
    .select_custom {
        border-radius: 30px;
        height: 50px;
    }
</style>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Atualizar dados</h1>
</div>

<?php echo $this->include('Restrict/Storage/complement/navTabs'); ?>

<!-- Content Row -->
<div class="row mt-3">
    <div class="col-md-12 col-lg-6">

        <?php echo form_open("privado/estoque/atualizar", ['class' => 'user', 'autocomplete' => 'off']); ?>

        <div class="form-group">
            <label>Descrição</label>
            <h5>&nbsp;<?php echo $storage->product ?></h5>
        </div>
        <br>
        <div class="form-group row">
            <div class="col-sm-6">
                <label>Preço de custo&nbsp;(R$)</label>
                <input type="text" class="money form-control form-control-user <?php echo session('error_validation.cost_price') ? 'border border-danger' : ''; ?>" id="cost_price" name="cost_price" placeholder="<?php echo esc($storage->cost_price); ?>">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.cost_price') ?></h6>
            </div>
            <div class="col-sm-6">
                <label>Preço de venda&nbsp;(R$)</label>
                <input type="text" class="money form-control form-control-user cnpj <?php echo session('error_validation.sale_price') ? 'border border-danger' : ''; ?>" id="sale_price" name="sale_price" placeholder="<?php echo esc($storage->sale_price); ?>">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.sale_price') ?></h6>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">
            Atualizar
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