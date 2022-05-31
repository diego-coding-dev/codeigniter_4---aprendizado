<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Lista de clientes</h1>
</div>

<a href="<?php echo site_url('privado/clientes/adicionar') ?>" class="btn btn-primary btn-sm">Adicionar</a>

<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">
        <?php if (count($clientsList) > 0) : ?>
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>
                            Nome
                        </th>
                        <th>
                            Endereço
                        </th>
                        <th>
                            Email
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
                    <?php foreach ($clientsList as $client) : ?>
                        <tr>
                            <td>
                                <?php echo esc($client->first_name) . '&nbsp;' . esc($client->last_name); ?>
                            </td>
                            <td>
                                <?php echo esc($client->address); ?>
                            </td>
                            <td>
                                <?php echo esc($client->email); ?>
                            </td>
                            <td style="width: 180px;">
                                <?php echo esc($client->created_at->humanize()); ?>
                            </td>
                            <td style="width: 110px;">
                                <a href="<?php echo site_url('privado/clientes/editar/mostrar/' . $client->id) ?>" style="text-decoration: none;"><i class="fas fa-fw fa-eye fa-lg"></i></a>
                                <a href="<?php echo site_url('privado/clientes/excluir/' . $client->id) ?>" style="text-decoration: none;"><i class="text-danger fas fa-fw fa-trash fa-lg"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <hr>
            <?php echo $pager->links(); ?>

        <?php else : ?>
            <h4 class="text-center">Não há clientes registrados</h4>
        <?php endif; ?>
    </div>
</div>
<?php echo $this->endSection(); ?>