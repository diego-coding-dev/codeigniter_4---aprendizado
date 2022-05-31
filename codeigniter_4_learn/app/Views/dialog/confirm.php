<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<div class="row d-flex justify-content-center">
    <div class="col-sm-12 text-center">
        <h4 style="padding-top: 150px;" class="mb-3"><?php echo $ask; ?></h4>

        <?php if (isset($id)): ?>

            <a href="<?php echo site_url("privado/$entity/$action/$id") ?>" class="btn btn-success">Confirmar</a>
            <a href="<?php echo site_url("privado/$entity/listar") ?>" class="btn btn-secondary">Cancelar</a>

        <?php else: ?>

            <a href="<?php echo site_url("privado/$entity/$action") ?>" class="btn btn-success">Confirmar</a>
            <a href="<?php echo site_url("privado/$entity") ?>" class="btn btn-secondary">Cancelar</a>

        <?php endif ?>
    </div>
</div>
<?php echo $this->endSection(); ?>