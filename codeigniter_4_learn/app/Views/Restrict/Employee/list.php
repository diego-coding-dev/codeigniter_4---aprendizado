<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-black-800">Lista de funcionários</h1>
</div>
<a href="<?php echo site_url('privado/funcionarios/adicionar') ?>" class="btn btn-primary btn-sm">Adicionar</a>

<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">
        <?php if (count($employeesList) > 0) : ?>
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
                            Adimissão
                        </th>
                        <th>
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employeesList as $employee) : ?>
                        <tr>
                            <td>
                                <?php echo esc($employee->first_name) . '&nbsp;' . esc($employee->last_name); ?>
                            </td>
                            <td>
                                <?php echo esc($employee->address); ?>
                            </td>
                            <td>
                                <?php echo esc($employee->email); ?>
                            </td>
                            <td style="width: 180px;">
                                <?php echo esc($employee->created_at->humanize()); ?>
                            </td>
                            <td style="width: 110px;">
                                <a href="<?php echo site_url('privado/funcionarios/editar/mostrar/' . $employee->id) ?>" style="text-decoration: none;"><i class="fas fa-fw fa-eye fa-lg"></i></a>
                                <a href="<?php echo site_url('privado/funcionarios/excluir/' . $employee->id) ?>" style="text-decoration: none;"><i class="text-danger fas fa-fw fa-trash fa-lg"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <hr>
            <?php echo $pager->links(); ?>

        <?php else : ?>
            <h4 class="text-center">Não há funcionários registrados</h4>
        <?php endif; ?>
    </div>
</div>
<?php echo $this->endSection(); ?>