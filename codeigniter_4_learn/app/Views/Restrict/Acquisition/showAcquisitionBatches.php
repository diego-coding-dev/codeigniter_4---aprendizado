<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Itens do pedido</h1>
</div>

<a href="<?php echo site_url("$previousURL") ?>" class="btn btn-secondary btn-sm">Voltar</a>

<!-- Content Row -->
<div class="row">


    <?php foreach ($listBatches as $batch): ?>

        <div class="col-xl-2 col-md-3 mt-3 mb-3">
            <div class="card border-left-secondary text-white shadow h-100 py-2">
                <div class="card-body">
                    <label class="text-black-50"><strong><?php echo esc($batch->batch); ?></strong></label>
                    <div class="text-black-50 medium"><?php echo esc($batch->total); ?>&nbsp;unidades</div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>


</div>
<?php echo $this->endSection(); ?>
