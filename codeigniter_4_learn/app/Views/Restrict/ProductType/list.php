<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Lista de categorias de produtos</h1>
</div>
<a href="<?php echo site_url('privado/tipo_de_produtos/adicionar') ?>" class="btn btn-primary btn-sm">Adicionar</a>

<!-- Search -->
<div class="row d-flex justify-content-center mt-2">
    <div class="col-sm-6">
        <?php echo form_open('privado/tipo_de_produtos/procurar', ['class' => 'user', 'autocomplete' => 'off']); ?>
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
        <?php if (count($productsTypeList) > 0) : ?>
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>
                            Descrição
                        </th>
                        <th>
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productsTypeList as $productType) : ?>
                        <tr>
                            <td>
                                <?php echo esc($productType->description); ?>
                            </td>
                            <td style="width: 110px;">
                                <a href="<?php echo site_url('privado/tipo_de_produtos/editar/' . $productType->id) ?>" style="text-decoration: none;"><i class="fas fa-fw fa-edit fa-lg"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <hr>
            <?php echo $pager->links(); ?>

        <?php else : ?>
            <h4 class="text-center mt-3">Não há categorias registradas</h4>
        <?php endif; ?>
    </div>
</div>
<?php echo $this->endSection(); ?>