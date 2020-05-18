<!-- jquery-ui -->
<script src="<?php echo base_url() ?>assets/plugins/jquery-ui/jquery-ui.js"></script>

<script>
    var todo = {Elevator: [], Aileron: [], Rudder: [], all: []};
    var doing = {Elevator: [], Aileron: [], Rudder: [], all: []};
    var done = {Elevator: [], Aileron: [], Rudder: [], all: []};

    loadAll();

    $('ul[id^="sort"]').sortable({
        connectWith: '.sortable',
        receive: function(e, ui) {
            var status_id = $(ui.item).parent(".sortable").data("status");
            var task_id = $(ui.item).data("task-id");
            console.log({statis: status_id, id: task_id});
            $.ajax({
                url: "order/move",
                method: "POST",
                data: {
                    id: task_id,
                    status: status_id
                },
                success: function(data) {
                    loadAll();
                },
                error: function(err) {
                    alert('Gagal memindahkan kartu');
                }
            })
        }
    }).disableSelection();

    function loadAll() {
        todo = {Elevator: [], Aileron: [], Rudder: [], all: []};
        doing = {Elevator: [], Aileron: [], Rudder: [], all: []};
        done = {Elevator: [], Aileron: [], Rudder: [], all: []};
        $.ajax({
            url: "order/get_all",
            method: "GET",
            success: function(data) {
                data = $.parseJSON(data);
                for(let i = 0; i<data.length; i++) {
                    if(data[i].status == 'waiting') {
                        todo[data[i].product].push(data[i]);
                        todo.all.push(data[i]);
                    } else if(data[i].status == 'on-progress') {
                        doing[data[i].product].push(data[i]);
                        doing.all.push(data[i]);
                    } else {
                        done[data[i].product].push(data[i]);
                        done.all.push(data[i]);
                    }
                }
                populateData();
            }
        });
    }

    function createCard(data) {
        if(data.visible == 0) {
            return "";
        }
        var color = "orange";
        if(data.status == "on-progress") {
            color = "blue";
        } else if(data.status == 'finish') {
            color = "green";
        }

        var str = '<li class="text-row ui-sortable-handle" data-task-id="'+data.id+'">';
        if(data.status == "finish") {
            str    +=    '<button type="button" onClick="hide('+data.id+')" class="close" >&times;</button>';
        }
        str    +=    "<ul>";
        str    +=        "<li>"+data.name+"</li>";
        str    +=        "<li>"+data.quantity+"</li>";
        str    +=        "<li>"+data.start_date+"</li>";
        str    +=        "<li>"+data.end_date+"</li>";
        str    +=        '<li style="text-align: right; color: '+color+'">'+data.status+'</li>';
        if(data.stock < data.quantity && data.status == 'waiting') {
            str+=        '<li style="text-align: right; color: red">'+(data.stock - data.quantity)+'</li>';
        }
        str    +=    "</ul>";
        str    += "</li>";
        return str;
    }

    function populateData() {
        populateCard("all", "todo", todo.all);
        populateCard("all", "doing", doing.all);
        populateCard("all", "done", done.all);

        populateCard("aileron", "todo", todo.Aileron);
        populateCard("aileron", "doing", doing.Aileron);
        populateCard("aileron", "done", done.Aileron);

        populateCard("elevator", "todo", todo.Elevator);
        populateCard("elevator", "doing", doing.Elevator);
        populateCard("elevator", "done", done.Elevator);

        populateCard("rudder", "todo", todo.Rudder);
        populateCard("rudder", "doing", doing.Rudder);
        populateCard("rudder", "done", done.Rudder);
    }

    function populateCard(name, status, data) {
        $("#sort-"+name+"-"+status).empty();
        data.forEach(function(order) {
            var card = createCard(order);
            $("#sort-"+name+"-"+status).append(card);
        });
    }

    function hide(id) {
        $.ajax({
            url: "order/hide",
            method: "POST",
            data: {
                id: id
            },
            success: function() {
                loadAll();
            },
            error: function() {
                alert("Terjadi kesalahan");
            }
        })
    }
</script>