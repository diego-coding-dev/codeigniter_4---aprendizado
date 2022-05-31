<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Exibindo informações</h1>
</div>

<a href="<?php echo site_url('privado/aquisicoes/listar') ?>" class="btn btn-secondary btn-sm">Voltar</a>

<a href="<?php echo site_url('privado/aquisicoes/mostrar/produtos/' . $acquisitionData->id) ?>" class="btn btn-primary btn-sm">Itens do pedido</a>

<div class="mt-3">
    <label>Fornecedor:</label>
    <h5>&nbsp;<?php echo esc($acquisitionData->corporate_name); ?></h5>
    <label class="mt-3">CNPJ:</label>
    <h5>&nbsp;<?php echo esc($acquisitionData->cnpj); ?></h5>
    <label class="mt-3">Número do documento:</label>
    <h5>&nbsp;<?php echo esc($acquisitionData->document_number); ?></h5>
    <label class="mt-3">Valor:</label>
    <h5><label>&nbsp;R$&nbsp;</label><label class="presentMoney"><?php echo esc($acquisitionData->operation_value); ?></label></h5>
    <label class="mt-2">Registrado há:</label>
    <h5>&nbsp;<?php echo esc($acquisitionData->created_at->humanize()); ?></h5>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>