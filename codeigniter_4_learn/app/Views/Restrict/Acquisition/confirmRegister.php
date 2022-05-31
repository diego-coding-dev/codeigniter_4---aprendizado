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
    <div class="col-xl-3 col-md-6 mt-5">
        <h4 class="mb-5">Confirmar o registro?</h4>

        <a href="<?php echo site_url('privado/aquisicoes/adicionar/finalizar') ?>" class="btn btn-success btn-lg">Confirmar</a>

        <a href="<?php echo site_url('privado/aquisicoes/adicionar/resumo') ?>" class="btn btn-danger btn-lg ml-4">Não</a>
    </div>
</div>
<?php echo $this->endSection(); ?>