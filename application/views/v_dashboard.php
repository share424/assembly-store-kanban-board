<?php
    $orders = $this->M_Order->getAll();
    $waiting = 0;
    $on_progress = 0;
    $finish = 0;
    foreach($orders as $order) {
        if($order->status == "waiting") $waiting++;
        else if($order->status == "on-progress") $on_progress++;
        else $finish++;
    }
    $footer = "dashboard_footer.php";
?>
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
        <div class="inner">
        <h3><?php echo $waiting ?></h3>

        <p>Waiting</p>
        </div>
        <div class="icon">
        <i class="ion ion-bag"></i>
        </div>
    </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
        <div class="inner">
        <h3><?php echo $on_progress ?></h3>

        <p>On Progress</p>
        </div>
        <div class="icon">
        <i class="ion ion-stats-bars"></i>
        </div>
    </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
        <div class="inner">
        <h3><?php echo $finish ?></h3>

        <p>Finish</p>
        </div>
        <div class="icon">
        <i class="ion ion-person-add"></i>
        </div>
    </div>
    </div>
</div>
<!-- /.row -->

<!-- BAR CHART -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Aileron</h3>
    </div>
    <div class="card-body">
        <div class="chart">
            <canvas id="barChart-Aileron" style="height:230px; min-height:230px"></canvas>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<!-- BAR CHART -->
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Elevator</h3>
    </div>
    <div class="card-body">
        <div class="chart">
            <canvas id="barChart-Elevator" style="height:230px; min-height:230px"></canvas>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<!-- BAR CHART -->
<div class="card card-danger">
    <div class="card-header">
        <h3 class="card-title">Rudder</h3>
    </div>
    <div class="card-body">
        <div class="chart">
            <canvas id="barChart-Rudder" style="height:230px; min-height:230px"></canvas>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->