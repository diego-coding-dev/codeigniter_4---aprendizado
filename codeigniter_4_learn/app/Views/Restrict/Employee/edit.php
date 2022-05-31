<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('styles'); ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-black-800">Atualizar dados</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-md-12 col-lg-6">

        <?php echo form_open("privado/funcionarios/editar/atualizar/$employee->id", ['class' => 'user', 'autocomplete' => 'off']); ?>

        <div class="form-group row">
            <div class="col-sm-6">
                <label>Primeiro nome</label>
                <input type="text" class="form-control <?php echo session('error_validation.first_name') ? 'border border-danger' : ''; ?>" id="first_name" name="first_name" placeholder="<?php echo esc($employee->first_name); ?>">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.first_name') ?></h6>
            </div>
            <div class="col-sm-6">
                <label>Segundo nome</label>
                <input type="text" class="form-control <?php echo session('error_validation.last_name') ? 'border border-danger' : ''; ?>" id="last_name" name="last_name" placeholder="<?php echo esc($employee->last_name); ?>">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.last_name') ?></h6>
            </div>
        </div>
        <div class="form-group">
            <label>Endereço</label>
            <textarea type="text" class="form-control <?php echo session('error_validation.address') ? 'border border-danger' : ''; ?>" id="address" name="address" placeholder="<?php echo esc($employee->address); ?>"></textarea>
            <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.address') ?></h6>
        </div>
        <div class="form-group">
            <label>Complemento</label>
            <input type="text" class="form-control <?php echo session('error_validation.address_complement') ? 'border border-danger' : ''; ?>" id="address_complement" name="address_complement" placeholder="<?php echo $employee->address_complement ? esc($employee->address_complement) : 'Não cadastrado'; ?>">
            <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.address_complement') ?></h6>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control <?php echo session('error_validation.email') ? 'border border-danger' : ''; ?>" id="email" name="email" placeholder="<?php echo esc($employee->email); ?>">
            <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.email') ?></h6>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Atualizar</button>
        <a href="<?php echo site_url("privado/funcionarios/editar/mostrar/$employee->id"); ?>" class="btn btn-danger btn-sm">Voltar</a>

        <?php echo form_close(); ?>

        <hr style="margin-top: 25px;">

        <h4>Adicionar telefone</h4>

        <?php echo form_open("privado/funcionarios/editar/adicionar_telefone", ['class' => 'user', 'autocomplete' => 'off']); ?>

        <div class="form-group row">
            <div class="col-sm-6">
                <label>Telefone</label>
                <input type="text" class="form-control sp_celphones <?php echo session('error_validation.telephone_1') ? 'border border-danger' : ''; ?>" id="telephone1" name="telephone" placeholder="Telefone">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.telephone') ?></h6>
            </div>
            <div class="col-sm-4">
                <label>Tipo de telefone</label>
                <select class="form-select form-control" aria-label="Default select example" id="telephone_type" name="telephone_type">
                    <option value=''>&nbsp;Escolha...</option>

                    <?php foreach ($telephoneTypeList as $telephoneType) : ?>

                        <option value='<?php echo esc($telephoneType->id) . '-' . esc($telephoneType->description); ?>'>&nbsp;<?php echo esc($telephoneType->description); ?></option>

                    <?php endforeach; ?>

                </select>
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.telephone_type') ?></h6>
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-fw fa-plus"></i>
                </button>
            </div>
        </div>

        <?php echo form_close(); ?>

    </div>

    <div class="col-md-12 col-lg-6">

        <?php echo $this->include('layout/restrict_messages'); ?>

        <h4>Telefones</h4>

        <?php echo $this->include('Restrict/Employee/complement/listTelephoneEdit'); ?>

    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>