<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Últimas vendas</h1>
</div>

<a href="<?php echo site_url('privado/vendas/adicionar') ?>" class="btn btn-primary btn-sm">Adicionar</a>

<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">

        <?php if (count($salesList) > 0) : ?>

            <table class="table table-striped mt-4">
                <thead>
                    <tr>
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

                    <?php foreach ($salesList as $sale) : ?>
                        <tr>
                            <td>
                                <?php echo esc($sale->document_number); ?>
                            </td>
                            <td style="width: 180px;">
                                <?php echo esc($sale->created_at->humanize()); ?>
                            </td>
                            <td style="width: 110px;">
                                <a href="<?php echo site_url('privado/vendas/mostrar/' . $sale->id) ?>" style="text-decoration: none;"><i class="fas fa-fw fa-eye fa-lg"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>

        <?php else : ?>
            <h4 class="text-center">Não há vendas registradas</h4>
        <?php endif; ?>

    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>