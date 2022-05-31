<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Resumo da aquisição</h1>
</div>

<div class="mb-3">
    <a href="<?php echo site_url('privado/aquisicoes/listar') ?>" class="btn btn-danger btn-sm">Voltar</a>

    <?php echo $this->include('Restrict/Acquisition/complement/resumeModal'); ?>

    <a href="<?php echo site_url('privado/aquisicoes/adicionar/carrinho/mostrar') ?>" class="btn btn-primary btn-sm"> <i class="fa fa-shopping-cart">&nbsp;<?php echo $totalInCart; ?></i></a>
</div>

<?php echo $this->include('Restrict/Acquisition/complement/navTabs'); ?>

<div class="row">
    <div class="col-md-12">

        <a href="<?php echo site_url('privado/aquisicoes/adicionar/resumo/confirmar') ?>" class="btn btn-success btn-sm">Registrar aquisição</a>

        <br>

        <label class="mt-3">Fornecedor:</label>
        <h5>&nbsp;<?php echo esc($provider['corporate_name']); ?></h5>

        <hr style="margin-top: 13px;">

        <label class="mt-3">Produtos:</label>
        <?php foreach ($products as $key => $product): ?>

            <h5><label>&nbsp;-&nbsp;<?php echo esc($product['description']); ?></label>&nbsp;[&nbsp;<label><?php echo esc($product['total']); ?>&nbsp;unidades&nbsp;]</label></h5>

        <?php endforeach; ?>

        <hr style="margin-top: 13px;">

        <label class="mt-3">Nota da aquisição:</label>
        <h5>&nbsp;<?php echo esc($additionalData['document_number']); ?></h5>

        <hr style="margin-top: 13px;">

        <label class="mt-3">Valor da aquisição:</label>
        <h5>&nbsp;R$&nbsp;<label class="presentMoney"><?php echo esc($additionalData['operation_value']); ?></label></h5>

        <hr style="margin-top: 13px;">

    </div>
</div>

<?php ?>

<?php $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>