<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('styles'); ?>


<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-black-800">Atualizar dados</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-md-12 col-lg-6">

        <?php echo form_open("privado/produtos/atualizar", ['class' => 'user', 'autocomplete' => 'off']); ?>

        <div class="form-group">
            <label>Descrição</label>
            <textarea type="text" class="form-control  <?php echo session('error_validation.description') ? 'border border-danger' : ''; ?>" id="description" name="description" placeholder="<?php echo esc($product['description']); ?>"></textarea>
        </div>
        <div class="form-group row">
            <div class="col-sm-3">
                <label>Situação</label>
                <select class=" form-select form-control" aria-label="Default select example" id="out_of_production" name="out_of_production">
                    <option value="active" <?php echo (!$product['out_of_production']) ? 'selected="selected"' : '' ?>>&nbsp;Ativado</option>
                    <option value="deactive" <?php echo ($product['out_of_production']) ? 'selected="selected"' : '' ?>>&nbsp;Desativado</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">
            Atualizar
        </button>
        <a href="<?php echo site_url('privado/produtos/mostrar/' . $product['id']); ?>" class="btn btn-danger btn-sm">Voltar</a>

        <?php echo form_close(); ?>

    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>