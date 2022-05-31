<nav aria-label="breadcrumb">
    <ol class="breadcrumb">

        <?php if ($linkActive === '0') : ?>
            <li class="breadcrumb-item active">
                Clientes
            </li>
        <?php endif; ?>

        <?php if ($linkActive === '1') : ?>
            <li class="breadcrumb-item">
                <a href="<?php echo site_url('privado/vendas/adicionar/clientes/listar/todos') ?>">Clientes</a>
            </li>
            <li class="breadcrumb-item active">
                Produtos disponíveis
            </li>
        <?php endif; ?>

        <?php if ($linkActive === '2') : ?>
            <li class="breadcrumb-item">
                <a href="<?php echo site_url('privado/vendas/adicionar/clientes/listar/todos') ?>">Clientes</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo site_url('privado/vendas/adicionar/produtos/listar/todos') ?>">Produtos disponíveis</a>
            </li>
            <li class="breadcrumb-item active">
                Dados adicionais
            </li>
        <?php endif; ?>

        <?php if ($linkActive === '3') : ?>
            <li class="breadcrumb-item">
                <a href="<?php echo site_url('privado/vendas/adicionar/clientes/listar/todos') ?>">Clientes</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo site_url('privado/vendas/adicionar/produtos/listar/todos') ?>">Produtos disponíveis</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo site_url('privado/vendas/adicionar/dados_adicionais') ?>">Dados adicionais</a>
            </li>
            <li class="breadcrumb-item active">
                Resumo
            </li>
        <?php endif; ?>

    </ol>
</nav>