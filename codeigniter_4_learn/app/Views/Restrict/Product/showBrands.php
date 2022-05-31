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
    <h1 class="h3 mb-0 text-black-800">Adicionando novo produto</h1>
</div>

<div class="mb-3">
    <a href="<?php echo site_url('privado/produtos') ?>" class="btn btn-danger btn-sm">Voltar</a>
    <?php echo $this->include('Restrict/Product/complement/resumeModal'); ?>
</div>

<?php echo $this->include('Restrict/Product/complement/navTabs'); ?>

<!-- Search -->
<div class="row d-flex justify-content-center mt-3">
    <div class="col-sm-6">
        <?php echo form_open('privado/produtos/adicionar/marca/procurar', ['class' => 'user', 'autocomplete' => 'off']); ?>
        <div class="input-group">
            <input type="text" class="form-control border-0 small" <?php echo isset($indexSearch) ? esc($indexSearch) : null; ?>  placeholder="<?php echo isset($indexSearch) ? esc($indexSearch) : 'Procurar...'; ?>" id="description" name="description">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>

        <h6 class="text-danger mt-1">&nbsp;<?= session()->get('error_validation.description'); ?></h6>

        <?php echo form_close(); ?>
    </div>
</div>

<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">
        <?php if (count($brandsList) > 0) : ?>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($brandsList as $brand) : ?>
                        <tr>
                            <td>
                                <?php echo esc($brand->description); ?>
                            </td>
                            <td style="width: 110px;">
                                <a href="<?php echo site_url('privado/produtos/adicionar/marca/selecionar/') . $brand->id; ?>" style="text-decoration: none;" type="button" class="btn btn-success btn-inline btn-sm"><i class="fas fa-fw fa-plus fa-lg text-black"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <hr>
            <?php echo $pager->links(); ?>

        <?php else : ?>
            <h4 class="text-center">Não há categorias do produto registrados</h4>
        <?php endif; ?>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>