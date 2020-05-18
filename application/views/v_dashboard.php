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