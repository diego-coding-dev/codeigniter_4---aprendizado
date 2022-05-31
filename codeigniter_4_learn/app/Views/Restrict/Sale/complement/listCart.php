<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Carrinho</h1>
</div>

<a href="<?php echo site_url($previousURL) ?>" class="btn btn-secondary btn-sm">Voltar</a>

<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">

        <?php if (count($itensCart) > 0) : ?>

            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>
                            Descrição
                        </th>
                        <th>
                            Quantidade (UN)
                        </th>
                        <th>
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (count($errorsItensCart) > 0) : ?>

                        <?php foreach ($itensCart as $item) : ?>

                            <tr>

                                <?php foreach ($errorsItensCart as $value) : ?>

                                    <?php if ($value == $item['session_id']) : ?>

                                        <td class="text-danger">
                                            <?php echo esc($item['product']); ?>
                                        </td>
                                        <td>
                                            <?php echo esc($item['total']); ?>
                                        </td>
                                        <td style="width: 110px;">
                                            <a href="<?php echo site_url('privado/vendas/adicionar/carrinho/deletar/' . $item['session_id']) ?>" class="text-danger" style="text-decoration: none;"><i class="fas fa-fw fa-trash fa-lg"></i></a>
                                        </td>

                                    <?php else: ?>

                                        <td>
                                            <?php echo esc($item['product']); ?>
                                        </td>
                                        <td>
                                            <?php echo esc($item['total']); ?>
                                        </td>
                                        <td style="width: 110px;">
                                            <a href="<?php echo site_url('privado/vendas/adicionar/carrinho/deletar/' . $item['session_id']) ?>" class="text-danger" style="text-decoration: none;"><i class="fas fa-fw fa-trash fa-lg"></i></a>
                                        </td>

                                    <?php endif; ?>

                                    <?php break; ?>

                                <?php endforeach; ?>

                            </tr>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <?php foreach ($itensCart as $item) : ?>

                            <tr>
                                <td>
                                    <?php echo esc($item['product']); ?>
                                </td>
                                <td>
                                    <?php echo esc($item['total']); ?>
                                </td>
                                <td style="width: 110px;">
                                    <a href="<?php echo site_url('privado/vendas/adicionar/carrinho/deletar/' . $item['session_id']) ?>" class="text-danger" style="text-decoration: none;"><i class="fas fa-fw fa-trash fa-lg"></i></a>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>
            </table>

        <?php else : ?>

            <h4 class="text-center">O carrinho está vazio</h4>

        <?php endif; ?>
    </div>
</div>

<?php echo $this->endSection(); ?>