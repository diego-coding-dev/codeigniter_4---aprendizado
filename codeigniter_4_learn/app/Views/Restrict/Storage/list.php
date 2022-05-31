<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Estoque</h1>
</div>

<!-- Search -->
<div class="row d-flex justify-content-center mt-2">
    <div class="col-sm-6">

        <?php echo form_open('privado/estoque/procurar', ['class' => 'user', 'autocomplete' => 'off']); ?>

        <div class="input-group">
            <input type="text" class="form-control border-0 small" <?php echo isset($indexSearch) ? esc($indexSearch) : null; ?> placeholder="<?php echo isset($indexSearch) ? esc($indexSearch) : 'Procurar...'; ?>" id="description" name="description">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>

        <h6 class="text-danger mt-1">&nbsp;<?= session()->get('error_validation.description'); ?></h6>


        <?php echo form_close(); ?>

    </div>
</div>

<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">

        <?php if (count($storageProducts) > 0) : ?>

            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($storageProducts as $product) : ?>

                        <tr>
                            <td>
                                <?php echo esc($product->product); ?>
                            </td>
                            <td>
                                <?php echo esc($product->category); ?>
                            </td>
                            <td style="width: 110px;" class="text-center">
                                <a href="<?php echo site_url('privado/estoque/mostrar/' . $product->product_id) ?>" style="text-decoration: none;"><i class="fas fa-fw fa-eye fa-lg"></i></a>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>

            <hr>
            <?php echo $pager->links(); ?>

        <?php else : ?>

            <h4 class="text-center mt-3">Nenhum item foi encontrado.</h4>

        <?php endif; ?>

    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- Máscara para os campos -->
<script src="<?php echo site_url('layout/') ?>js/jquery.mask.min.js"></script>
<script src="<?php echo site_url('layout/') ?>js/app.js"></script>
<?php echo $this->endSection(); ?>