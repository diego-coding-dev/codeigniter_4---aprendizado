<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a id="teste" class="nav-link" href="<?php echo site_url('privado/principal'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Clientes -->
    <li class="nav-item active">
        <a id="teste" class="nav-link" href="<?php echo site_url('privado/clientes'); ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Cliente</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - funcionarios -->
    <li class="nav-item active">
        <a id="teste" class="nav-link" href="<?php echo site_url('privado/funcionarios'); ?>">
            <i class="fas fa-fw fa-address-card"></i>
            <span>Funcionários</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - fornecedores -->
    <li class="nav-item active">
        <a id="teste" class="nav-link" href="<?php echo site_url('privado/fornecedores'); ?>">
            <i class="fas fa-fw fa-truck-loading"></i>
            <span>Fornecedores</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Mercadorias
    </div>

    <!-- Nav Item - produtos -->
    <li class="nav-item active">
        <a id="teste" class="nav-link" href="<?php echo site_url('privado/produtos'); ?>">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Produtos</span>
        </a>
    </li>
    
    <!-- Nav Item - tipo de produtos -->
    <li class="nav-item active">
        <a id="teste" class="nav-link" href="<?php echo site_url('privado/tipo_de_produtos'); ?>">
            <i class="fas fa-fw fa-th-list"></i>
            <span>Categorias de produtos</span>
        </a>
    </li>
    
    <!-- Nav Item - estoque -->
    <li class="nav-item active">
        <a id="teste" class="nav-link" href="<?php echo site_url('privado/estoque'); ?>">
            <i class="fas fa-fw fa-warehouse"></i>
            <span>Estoque de produtos</span>
        </a>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Operações
    </div>

    <!-- Nav Item - compras -->
    <li class="nav-item active">
        <a id="teste" class="nav-link" href="<?php echo site_url('privado/aquisicoes/listar'); ?>">
            <i class="fas fa-fw fa-dolly-flatbed"></i>
            <span>Compras</span>
        </a>
    </li>
    
    <!-- Nav Item - vendas -->
    <li class="nav-item active">
        <a id="teste" class="nav-link" href="<?php echo site_url('privado/vendas/listar'); ?>">
            <i class="fas fa-fw fa-dolly"></i>
            <span>Vendas</span>
        </a>
    </li>

</ul>
<!-- End of Sidebar -->