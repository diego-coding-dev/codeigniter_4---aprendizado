<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>
            <?php echo $title ?>
        </title>

        <?php echo $this->include('layout/styles'); ?>
        <?php echo $this->renderSection('styles'); ?>

    </head>

    <body class="bg-gradient-primary">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10" style="padding-top: 10%;">      
                    <div class="card border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="p-5">

                                        <?php echo $this->include('layout/messages'); ?>
                                        <?php echo $this->renderSection('content'); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>


    <?php echo $this->include('layout/scripts'); ?>
    <?php echo $this->renderSection('scripts'); ?>

</body>

</html>