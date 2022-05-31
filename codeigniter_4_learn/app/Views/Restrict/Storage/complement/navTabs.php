<a href="<?php echo site_url('privado/estoque') ?>" class="btn btn-secondary btn-sm mb-3">Voltar</a>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?php echo ($linkActive === '1') ? 'active' : null; ?>" href="<?php echo site_url('privado/estoque/mostrar/' . $productId); ?>">Informação</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($linkActive === '2') ? 'active' : null; ?>" href="<?php echo site_url('privado/estoque/lotes'); ?>">Lotes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($linkActive === '3') ? 'active' : null; ?>" href="<?php echo site_url('privado/estoque/editar'); ?>">Atualizar dados</a>
    </li>
</ul>