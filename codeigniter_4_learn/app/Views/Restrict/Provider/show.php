<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Exibindo informações</h1>
</div>

<a href="<?php echo site_url('privado/fornecedores') ?>" class="btn btn-secondary btn-sm">Voltar</a>
<a href="<?php echo site_url("privado/fornecedores/editar") ?>" class="btn btn-primary btn-sm">Editar dados</a>

<div class="mt-3">
    <label>Razão social:</label>
    <h5>&nbsp;<?php echo esc($provider->corporate_name); ?></h5>
    <label class="mt-3">CNPJ:</label>
    <h5>&nbsp;<?php echo esc($provider->cnpj); ?></h5>
    <label class="mt-3">Contato:</label>
    <h5>&nbsp;<?php echo esc($provider->contact); ?></h5>
    <label class="mt-3">Email:</label>
    <h5>&nbsp;<?php echo esc($provider->email); ?></h5>
    <label class="mt-3">Endereço:</label>
    <h5>&nbsp;<?php echo esc($provider->address); ?></h5>
    <label class="mt-3">Complemento:</label>
    <h5>
        <?php if ($provider->address_complement) : ?>
            &nbsp;<?php echo esc($provider->address_complement); ?>
        <?php else : ?>
            &nbsp;Não cadastrado.
        <?php endif; ?>
    </h5>
    <label class="mt-3">Telefones:</label>

    <?php foreach ($telephones_provider as $telephone): ?>

        <h5>&nbsp;<?php echo esc($telephone->telephone . ' - ' . $telephone->description); ?></h5>

    <?php endforeach; ?>

    <label class="mt-3">Cadastrado há:</label>
    <h5>&nbsp;<?php echo esc($provider->created_at->humanize()); ?></h5>
</div>
<?php echo $this->endSection(); ?>