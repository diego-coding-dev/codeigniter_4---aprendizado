<?php echo $this->extend('layout/main'); ?>


<?php echo $this->section('title'); ?>
<?php echo $title ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-black-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row d-flex justify-content-center">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total de clientes:</div>
                        <div class="h5 mb-0 font-weight-bold text-black-800"><?= $totalClients;  ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total de vendas</div>
                        <div class="h5 mb-0 font-weight-bold text-black-800"><?= $totalSales; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-handshake fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total de acquisições</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-black-800"><?= $totalAcquisitions; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wrench fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total de produtos</div>
                        <div class="h5 mb-0 font-weight-bold text-black-800"><?= $totalProducts; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total de fornecedores</div>
                        <div class="h5 mb-0 font-weight-bold text-black-800"><?= $totalProviders; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tie fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total de funcionários:</div>
                        <div class="h5 mb-0 font-weight-bold text-black-800"><?= $totalEmployees;  ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-address-card fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php echo $this->endSection(); ?>