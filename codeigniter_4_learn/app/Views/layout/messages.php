<?php if (session()->has('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Concluído!</strong>&nbsp;<?php echo session('success'); ?>
    </div>
<?php endif; ?>

<?php if (session()->has('warning')) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Atenção!</strong>&nbsp;<?php echo session('warning'); ?>
    </div>
<?php endif; ?>

<?php if (session()->has('danger')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Aviso!</strong> &nbsp;<?php echo session('danger'); ?>
    </div>
<?php endif; ?>

<?php if (session()->has('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Aviso!</strong> &nbsp;<?php echo session('error'); ?>
    </div>
<?php endif; ?>

<?php if (session()->has('info')) : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Aviso!</strong> &nbsp;<?php echo session('info'); ?>
    </div>
<?php endif; ?>

<?php if (session()->has('login')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Credenciado!</strong>&nbsp;<?php echo session('login'); ?>
    </div>
<?php endif; ?>
