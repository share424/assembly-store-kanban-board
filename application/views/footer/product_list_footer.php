<!-- DataTables -->
<script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
    var table = $("#table-product").DataTable({
        ajax: {
            url: "order/get_all",
            dataSrc: function(data) {
                return data.map(function(order) {
                    var action = "";
                    if(order.status == "waiting") {
                        action += "<button onClick='edit("+order.id+")' class='btn btn-success'>Edit</button> ";
                    }
                    action += "<button onClick='deleteComponent("+order.id+")' class='btn btn-danger'>Hapus</button>";
                    return {
                        id: order.id,
                        component_id: order.name,
                        quantity: order.quantity,
                        start_date: order.start_date,
                        end_date: order.end_date,
                        status: order.status,
                        action: action
                    };
                });
            }
        },
        columns: [
            {data: "component_id"},
            {data: "quantity"},
            {data: "start_date"},
            {data: "end_date"},
            {data: "status"},
            {data: "action"}
        ]
    });

    function edit(id) {
        $("#edit-modal").modal("show");
        var order = {};
        for(let i = 0; i<table.ajax.json().length; i++) {
            if(table.ajax.json()[i].id == id) {
                order = table.ajax.json()[i];
                break;
            }
        }
        $("#order-id").val(id);
        $("#product").val(order.product_id);
        $("#component-id").val(order.name);
        $("#component-qty").val(order.quantity);

    }

    function confirmUpdate() {
        var id = $("#order-id").val();
        var qty = $("#component-qty").val();
        $.ajax({
            url: "order/update",
            method: "POST",
            data: {
                id: id,
                quantity: qty
            },
            success: function() {
                alert("Success update order");
                table.ajax.reload();
            },
            error: function() {
                alert("Failed to update order");
            }
        })
    }

    function deleteComponent(id) {
        if(confirm("Are you sure to delete this component order?")) {
            $.ajax({
                url: "order/delete",
                method: "POST",
                data: {
                    id: id
                },
                success: function() {
                    alert("Success delete order");
                    table.ajax.reload()
                },
                error: function() {
                    alert("Failed to delete order");
                }
            })
        }
    }
</script>