<div class="row" style="margin-left: auto;">
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-20">
            <div class="card-body">
            <div class="card-body-icon">
                <i class="fa fa-fw fa-user-md"></i>
            </div>
            <div class="mr-5"><?php echo $dentis; ?> Dentis</div>
            </div>
            <a href="<?= base_url() ?>index.php/dentist" class="card-footer text-white clearfix small z-1" href="#">
            <span class="float-left">View Details</span>
            <span class="float-right">
                <i class="fa fa-angle-right"></i>
            </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-warning o-hidden h-20">
            <div class="card-body">
            <div class="card-body-icon">
                <i class="fa fa-fw fa-user"></i>
            </div>
            <div class="mr-5"><?php echo $patient; ?> Patient</div>
            </div>
            <a href="<?= base_url() ?>index.php/patient" class="card-footer text-white clearfix small z-1" href="#">
            <span class="float-left">View Details</span>
            <span class="float-right">
                <i class="fa fa-angle-right"></i>
            </span>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-20">
            <div class="card-body">
            <div class="card-body-icon">
                <i class="fa fa-fw fa-envelope"></i>
            </div>
            <div class="mr-5"><?php echo $claim; ?> Request!</div>
            </div>
            <a href="<?= base_url() ?>index.php/request" class="card-footer text-white clearfix small z-1" href="#">
            <span class="float-left">View Details</span>
            <span class="float-right">
                <i class="fa fa-angle-right"></i>
            </span>
            </a>
        </div>
    </div>
</div>