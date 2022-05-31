<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('styles'); ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Adicionar fornecedor</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-md-12 col-lg-6">

        <?php echo form_open('privado/fornecedores/adicionar', ['class' => 'user', 'autocomplete' => 'off']); ?>

        <a href="<?php echo site_url('privado/fornecedores'); ?>" class="btn btn-secondary btn-sm">Voltar</a>

        <button type="submit" class="btn btn-primary btn-sm">
            Registrar
        </button>

        <div class="form-group row mt-3">
            <div class="col-sm-6">
                <label>Razão social</label>
                <input type="text" class="form-control  <?php echo session('error_validation.corporate_name') ? 'border border-danger' : ''; ?>" id="corporate_name" name="corporate_name" placeholder="Razão Social">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.corporate_name') ?></h6>
            </div>
            <div class="col-sm-6">
                <label>CNPJ</label>
                <input type="text" class="cnpj form-control  <?php echo session('error_validation.cnpj') ? 'border border-danger' : ''; ?>" id="cnpj" name="cnpj" placeholder="CNPJ">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.cnpj') ?></h6>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6">
                <label>Contato</label>
                <input type="text" class="form-control  <?php echo session('error_validation.contact') ? 'border border-danger' : ''; ?>" id="contact" name="contact" placeholder="Contato">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.contact') ?></h6>
            </div>
            <div class="col-sm-6">
                <label>Email</label>
                <input type="email" class="form-control  <?php echo session('error_validation.email') ? 'border border-danger' : ''; ?>" id="email" name="email" placeholder="Email">
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.email') ?></h6>
            </div>
        </div>

        <div class="form-group">
            <label>Endereço</label>
            <textarea type="text" class="form-control  <?php echo session('error_validation.address') ? 'border border-danger' : ''; ?>" id="address" name="address" placeholder="Endereço"></textarea>
            <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.address') ?></h6>
        </div>
        <div class="form-group">
            <label>Complemento</label>
            <input type="text" class="form-control  <?php echo session('error_validation.address_complement') ? 'border border-danger' : ''; ?>" id="address_complement" name="address_complement" placeholder="Complemento">
            <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.address_complement') ?></h6>
        </div>

        <?php echo form_close(); ?>

        <hr style="margin-top: 25px;">

        <h4>Adicionar telefone</h4>

        <?php echo form_open("privado/fornecedores/adicionar/telefone", ['class' => 'user', 'autocomplete' => 'off']); ?>

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

                    <?php foreach ($telephoneTypeList as $telephoneType): ?>

                        <option value='<?php echo esc($telephoneType->id) . '-' . esc($telephoneType->description); ?>'>&nbsp;<?php echo esc($telephoneType->description); ?></option>

                    <?php endforeach; ?>

                </select>
                <h6 class="text-danger mt-1">&nbsp;<?= session('error_validation.telephone_type') ?></h6>
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>

        <?php echo form_close(); ?>

    </div>

    <div class="col-md-12 col-lg-6">

        <?php echo $this->include('layout/restrict_messages'); ?>

        <h4>Telefones</h4>

        <?php echo $this->include('Restrict/Provider/complement/listTelephone'); ?>

    </div>

</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>