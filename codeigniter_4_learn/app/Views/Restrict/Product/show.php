<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Exibindo informações</h1>
</div>

<a href="<?php echo site_url('privado/produtos/listar/todos') ?>" class="btn btn-secondary btn-sm">Voltar</a>
<a href="<?php echo site_url("privado/produtos/editar") ?>" class="btn btn-primary btn-sm">Editar dados</a>

<div class="mt-3">
    <label class="mt-3">Descrição:</label>
    <h5>&nbsp;<?php echo esc($product->description); ?></h5>
    <label class="mt-3">Categoria:</label>
    <h5>&nbsp;<?php echo esc($product->category); ?></h5>
    <label class="mt-3">Situação:</label>
    <?php if ($product->out_of_production) : ?>
        <h5 class="text-danger">&nbsp;produção encerrada</h5>
    <?php else : ?>
        <h5>&nbsp;em produção</h5>
    <?php endif; ?>
    <label class="mt-3">Cadastrado há:</label>
    <h5>&nbsp;<?php echo esc($product->created_at->humanize()); ?></h5>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>