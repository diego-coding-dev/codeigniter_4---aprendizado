<?php echo $this->extend('layout/mainPublic'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-3">Por favor, atualize suas credênciais.</h4>
</div>

<!-- Content Row -->
<div class="col-md-12">
    <?php echo form_open("privado/funcionarios/atualizar_credencial/$employeeId", ['class' => 'user', 'autocomplete' => 'off']); ?>
    <div class="form-group">
        <label>Senha</label>
        <input type="password" class="form-control <?php echo session('error_validation.password_hash') ? 'border border-danger' : ''; ?>" id="password_hash" name="password_hash" placeholder="Senha">
        <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.password_hash') ?></h6>
    </div>
    <div class="form-group">
        <label>Confirme a senha</label>
        <input type="password" class="form-control <?php echo session('error_validation.confirm_password') ? 'border border-danger' : ''; ?>" id="confirm_password" name="confirm_password" placeholder="Confirmar senha">
        <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.confirm_password') ?></h6>
    </div>
    <button type="submit" class="btn btn-primary btn-user">
        Atualizar
    </button>
    <a href="<?php echo site_url('privado/funcionarios/sair'); ?>" class="btn btn-danger btn-user">Sair</a>
    <?php echo form_close(); ?>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>