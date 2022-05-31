<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Exibindo informações</h1>
</div>

<a href="<?php echo site_url('privado/funcionarios') ?>" class="btn btn-secondary btn-sm">Voltar</a>
<a href="<?php echo site_url("privado/funcionarios/editar") ?>" class="btn btn-primary btn-sm">Editar dados</a>

<div class="mt-3">
    <label>Nome:</label>
    <h5>&nbsp;<?php echo esc($employee->first_name) . '&nbsp;' . esc($employee->last_name); ?></h5>
    <label class="mt-3">Endereço:</label>
    <h5>&nbsp;<?php echo esc($employee->address); ?></h5>
    <label class="mt-3">Complemento:</label>
    <h5>

        <?php if ($employee->address_complement) : ?>
            &nbsp;<?php echo esc($employee->address_complement); ?>
        <?php else : ?>
            &nbsp;Não cadastrado.
        <?php endif; ?>

    </h5>
    <label class="mt-3">Email:</label>
    <h5>&nbsp;<?php echo esc($employee->email); ?></h5>
    <label class="mt-3">Telefones:</label>

    <?php foreach ($telephonesEmployee as $telephone) : ?>

        <h5>&nbsp;<?php echo esc($telephone->telephone); ?>&nbsp;-&nbsp;<?php echo esc($telephone->description); ?></h5>
    <?php endforeach; ?>

    <label class="mt-3">Situação da conta:</label>

    <?php if (!$employee->is_active && $employee->is_first_login) : ?>

        <h5>&nbsp;não ativado</h5>
    <?php elseif ($employee->is_active) : ?>

        <h5>&nbsp;ativado&emsp;&emsp;
            <a href="<?php echo site_url('privado/funcionarios/editar/desativar') ?>" style="text-decoration: none;" class="btn btn-danger btn-sm">
                <i class="fas fa-fw fa-grimace fa-lg"></i>&nbsp;desativar
            </a>
        </h5>
    <?php else : ?>

        <h5>&nbsp;desativado&emsp;
            <a href="<?php echo site_url('privado/funcionarios/editar/ativar') ?>" style="text-decoration: none;" class="text-success">
                Ativar conta
            </a>
        </h5>
    <?php endif; ?>

    <label class="mt-3">Adimissão:</label>
    <h5>&nbsp;<?php echo esc($employee->created_at->humanize()); ?></h5>
</div>
<?php echo $this->endSection(); ?>