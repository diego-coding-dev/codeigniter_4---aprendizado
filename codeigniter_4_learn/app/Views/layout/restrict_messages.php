
<?php if (session()->has('restrict_success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Concluído!</strong>&nbsp;<?php echo session('restrict_success'); ?>
    </div>
<?php endif; ?>

<?php if (session()->has('restrict_warning')) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Atenção!</strong>&nbsp;<?php echo session('restrict_warning'); ?>
    </div>
<?php endif; ?>

<?php if (session()->has('restrict_danger')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Aviso!</strong> &nbsp;<?php echo session('restrict_danger'); ?>
    </div>
<?php endif; ?>

<?php if (session()->has('restrict_info')) : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Aviso!</strong> &nbsp;<?php echo session('restrict_info'); ?>
    </div>
<?php endif; ?>
