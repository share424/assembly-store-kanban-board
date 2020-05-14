<?php
    $footer = "create_product_footer.php";
    $products = $this->M_Product->getAll();
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Select Component</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="product">Product</label>
            <select name="product" id="product" class="form-control">
                <?php
                    foreach($products as $product) {
                        echo "<option value='$product->id'>$product->name</option>";
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <table class="table table-bordered" id="table-component">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Component ID</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Component List</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <table class="table table-bordered" id="table-cart">
                <thead>
                    <tr>
                        <th>Component ID</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="form-group">
            <label>Duration</label>

            <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                <i class="far fa-calendar-alt"></i>
                </span>
            </div>
            <input type="text" class="form-control float-right" id="reservation">
            </div>
            <!-- /.input group -->
        </div>
        <button class="btn btn-primary" id="btn-submit">Submit</button>
    </div>
    
</div>