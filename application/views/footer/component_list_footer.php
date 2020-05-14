<!-- DataTables -->
<script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
    var table = $("#table-component").DataTable({
        ajax: {
            url: "component",
            dataSrc: function(data) {
                return data.map(function(component) {
                    return {
                        name: component.name,
                        stock: component.stock,
                        action: "<button class='btn btn-primary' onClick='updateStock("+component.id+","+component.stock+","+'"'+component.name+'"'+")'>Update Stock</button>"
                    }
                });
            }
        },
        columns: [
            {data: "name"},
            {data: "stock"},
            {data: "action"}
        ]
    })

    function updateStock(id, stock, name) {
        $("#edit-modal").modal("show");
        $("#component-id").val(id);
        $("#component-name").val(name);
        $("#component-stock").val(stock);
    }

    function confirmUpdate() {
        var id = $("#component-id").val();
        var stock = $("#component-stock").val();
        $.ajax({
            url: "component/update",
            method: "POST",
            data: {
                id: id,
                stock: stock
            },
            success: function() {
                alert("Success update component stock");
                table.ajax.reload();
            },
            error: function() {
                alert("Failed to update component stock");
            }
        })
    }
</script>