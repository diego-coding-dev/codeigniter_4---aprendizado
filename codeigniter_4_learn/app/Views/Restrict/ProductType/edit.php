<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Atualizar dados</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-md-12 col-lg-6">

        <?php echo form_open("privado/tipo_de_produtos/atualizar", ['class' => 'user', 'autocomplete' => 'off']); ?>

        <div class="form-group">
            <label>Categoria de produto</label>
            <input type="text" class="form-control  <?php echo session('error_validation.description') ? 'border border-danger' : ''; ?>" id="description" name="description" placeholder="<?php echo esc($productType->description); ?>">
            <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.description') ?></h6>
        </div>

        <a href="<?php echo site_url('privado/tipo_de_produtos'); ?>" class="btn btn-danger btn-sm">Voltar</a>
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