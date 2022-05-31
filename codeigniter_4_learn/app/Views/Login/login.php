<?php echo $this->extend('layout/mainPublic'); ?>


<?php echo $this->section('content'); ?>

<h1 class="">Área restrita.</h1>
<h4 class="">Por favor, insira suas credênciais.</h4>

<?php echo form_open('publico/autenticacao/autenticar', ['class' => 'user', 'autocomplete' => 'off']); ?>

<div class="form-group">
    <label>Usuário</label>
    <input type="text" class="form-control " id="username" name="username" placeholder="Usuário">
    <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.username') ?></h6>
</div>
<div class="form-group">
    <label>Senha</label>
    <input type="password" class="form-control " id="password_hash" name="password_hash" placeholder="Senha">
    <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.password_hash') ?></h6>
</div>
<div class="form-group text-left">
    <button style="width: 150px;" type="submit" class="btn btn-primary">
        Autenticar
    </button>
</div>

<?php echo form_close(); ?>

<hr>
<a class="small" href="<?php echo site_url("autenticacao/credenciais"); ?>">Esqueceu sua senha?</a>

<?php echo $this->endSection(); ?>