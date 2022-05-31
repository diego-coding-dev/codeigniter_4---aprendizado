<nav aria-label="breadcrumb">
    <ol class="breadcrumb">

        <?php if ($linkActive === '1') : ?>
            <li class="breadcrumb-item active">
                Tipo de produto
            </li>
        <?php endif; ?>

        <?php if ($linkActive === '2') : ?>
            <li class="breadcrumb-item">
                <a href="<?php echo site_url('privado/produtos/adicionar/tipo_produto/listar/todos') ?>">Tipo de produto</a>
            </li>
            <li class="breadcrumb-item active">
                Marca do produto
            </li>
        <?php endif; ?>

        <?php if ($linkActive === '3') : ?>
            <li class="breadcrumb-item">
                <a href="<?php echo site_url('privado/produtos/adicionar/tipo_produto/listar/todos') ?>">Tipo de produto</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo site_url('privado/produtos/adicionar/marca/listar/todos') ?>">Marca do produto</a>
            </li>
            <li class="breadcrumb-item active">
                Descrição
            </li>
        <?php endif; ?>
    </ol>
</nav>