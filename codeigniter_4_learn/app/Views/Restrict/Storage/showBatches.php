<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<!-- Page Heading -->
<div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Exibindo informações</h1>
</div>

<?php echo $this->include('Restrict/Storage/complement/navTabs'); ?>

<div class="row d-flex justify-content-center">
    <?php if (count($batches) > 0): ?>

        <?php foreach ($batches as $batch): ?>

            <div class="col-lg-2 col-md-5 mt-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Lote: <?php echo esc($batch->batch); ?></div>
                                <div class="h5 mb-0 font-weight-bold text-black-800"><?php echo esc($batch->total) ?>&nbsp;unidades</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-boxes fa-2x text-black-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    

        <?php endforeach; ?>

    <?php else: ?>

        <h4 class="text-center mt-3"> Não há lotes para este produto. </h4>

    <?php endif; ?>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>