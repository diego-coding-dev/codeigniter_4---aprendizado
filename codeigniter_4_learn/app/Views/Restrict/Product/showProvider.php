<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('styles'); ?>

<style>
    .select_custom {
        border-radius: 30px;
        height: 50px;
    }
</style>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Adicionando novo produto</h1>
</div>

<div class="mb-3">
    <a href="<?php echo site_url('privado/produtos/listar') ?>" class="btn btn-danger btn-sm">Voltar</a>
    <?php echo $this->include('Restrict/Product/complement/resumeModal'); ?>
</div>

<?php echo $this->include('Restrict/Product/complement/navTabs'); ?>

<!-- Search -->
<div class="row d-flex justify-content-center mt-3">
    <div class="col-sm-6">
        <form class="user">
            <div class="input-group">
                <input type="text" class="form-control border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">
        <?php if (count($providersList) > 0) : ?>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>
                            Razão social
                        </th>
                        <th>
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($providersList as $provider) : ?>
                        <tr>
                            <td>
                                <?php echo esc($provider->corporate_name); ?>
                            </td>
                            <td style="width: 110px;">
                                <a href="<?php echo site_url('privado/produtos/adicionar/selecionar_fornecedor/') . $provider->id; ?>" style="text-decoration: none;" type="button" class="btn btn-success btn-inline btn-sm"><i class="fas fa-fw fa-plus fa-lg text-black"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <h4 class="text-center">Não há fornecedores registrados</h4>
        <?php endif; ?>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>