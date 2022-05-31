<!-- Content Row -->
<div class="row d-flex justify-content-center">
    <div class="col-sm-12">
        <?php if ($telephoneList) : ?>

            <?php if (count($telephoneList) > 0) : ?>

                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th>
                                Número
                            </th>
                            <th>Tipo</th>
                            <th class="text-center">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($telephoneList as $telephone) : ?>
                            <tr>
                                <td>
                                    <?php echo esc($telephone['telephone']); ?>
                                </td>
                                <td>
                                    <?php echo esc($telephone['telephone_description']); ?>
                                </td>
                                <td class="text-center" style="width: 110px;">
                                    <a href="<?php echo site_url('privado/clientes/adicionar/telefone/excluir/' . $telephone['id_session']) ?>" class="text-danger" style="text-decoration: none;"><i class="fas fa-fw fa-trash fa-lg"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php endif; ?>

        <?php else : ?>

            <h5 class="text-center text-danger" style="margin-top: 55px;">Não há telefones adicionados</h5>

        <?php endif; ?>
    </div>
</div>