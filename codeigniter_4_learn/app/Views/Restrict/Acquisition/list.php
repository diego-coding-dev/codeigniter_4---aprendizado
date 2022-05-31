<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Últimas compras</h1>
</div>

<a href="<?php echo site_url('privado/aquisicoes/adicionar') ?>" class="btn btn-primary btn-sm">Adicionar</a>

<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">
        <?php if (count($acquisitionsList) > 0) : ?>
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>
                            Fornecedor
                        </th>
                        <th>
                            NF
                        </th>
                        <th>
                            Registrado há
                        </th>
                        <th>
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($acquisitionsList as $acquisition) : ?>
                        <tr>
                            <td>
                                <?php echo esc($acquisition->corporate_name); ?>
                            </td>
                            <td style="width: 150px;">
                                <?php echo esc($acquisition->document_number); ?>
                            </td>
                            <td style="width: 180px;">
                                <?php echo esc($acquisition->created_at->humanize()); ?>
                            </td>
                            <td style="width: 110px;">
                                <a href="<?php echo site_url('privado/aquisicoes/mostrar/' . $acquisition->id) ?>" style="text-decoration: none;"><i class="fas fa-fw fa-eye fa-lg"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>

        <?php else : ?>
            <h4 class="text-center">Não há compras registradas</h4>

        <?php endif; ?>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>