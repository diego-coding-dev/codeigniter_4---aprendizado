<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Lista de fornecedores</h1>
</div>

<a href="<?php echo site_url('privado/fornecedores/adicionar') ?>" class="btn btn-primary btn-sm">Adicionar</a>

<!-- Search -->
<div class="row d-flex justify-content-center mt-2">
    <div class="col-sm-6">

        <?php echo form_open('privado/fornecedores/procurar', ['class' => 'user', 'autocomplete' => 'off']); ?>

        <div class="input-group">
            <input type="text" class="form-control border-0 small" <?php echo isset($indexSearch) ? esc($indexSearch) : null; ?> placeholder="<?php echo isset($indexSearch) ? esc($indexSearch) : 'Procurar...'; ?>" id="corporate_name" name="corporate_name">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>

        <h6 class="text-danger mt-1">&nbsp;<?= session()->get('error_validation.corporate_name'); ?></h6>

        <?php echo form_close(); ?>
    </div>
</div>

<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">

        <?php if (count($providersList) > 0) : ?>

            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>
                            Razão Social
                        </th>
                        <th>
                            Endereço
                        </th>
                        <th>
                            Contato
                        </th>
                        <th>
                            Registrado em
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
                            <td>

                                <?php echo esc($provider->address); ?>

                            </td>
                            <td>

                                <?php echo esc($provider->contact); ?>

                            </td>
                            <td style="width: 180px;">

                                <?php echo esc($provider->created_at->humanize()); ?>

                            </td>
                            <td style="width: 110px;">
                                <a href="<?php echo site_url('privado/fornecedores/editar/mostrar/' . $provider->id) ?>" style="text-decoration: none;"><i class="fas fa-fw fa-eye fa-lg"></i></a>
                                <a href="<?php echo site_url('privado/fornecedores/excluir/' . $provider->id) ?>" style="text-decoration: none;"><i class="text-danger fas fa-fw fa-trash fa-lg"></i></a>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>

            <hr>
            <?php echo $pager->links(); ?>

        <?php else : ?>

            <h4 class="text-center mt-3">Não há fornecedores registrados</h4>

        <?php endif; ?>

    </div>
</div>
<?php echo $this->endSection(); ?>