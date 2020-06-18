<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_User");
        $this->load->model("M_Product");
        $this->load->model("M_Component");
        $this->load->model("M_Order");
    }
	
	public function index()
	{
		$this->load->view('welcome_message');
    }
    
    public function component()
	{
        $data = $this->input->post("data");
        $start_date = $this->input->post("start_date");
        $end_date = $this->input->post("end_date");

        foreach($data as $component) {
            $this->M_Order->insert([
                "component_id" => $component["id"],
                "quantity" => $component["qty"],
                "start_date" => $start_date,
                "end_date" => $end_date,
                "status" => "waiting",
                "visible" => 1
            ]);
        }
        echo true;
    }
    
    public function get_all()
    {
        $data = [];
        foreach($this->M_Order->getAll() as $row) {
            $row->start_date = (new DateTime($row->start_date))->format('d F Y');
            $row->end_date = (new DateTime($row->end_date))->format('d F Y');
            $data[] = $row;
        }
        echo json_encode($data);
    }

    public function move()
    {
        $id = $this->input->post("id");
        $status = $this->input->post("status");
        $level = $this->input->post("level");
        $order = $this->M_Order->get($id)[0];
        $component = $this->M_Component->get($order->component_id)[0];
        if($order->status == "waiting" && $status == "finish") {
            echo "waiting-finish";
            return;
        }
        if($order->status == "on-progress" && $status == "waiting") {
            echo "on-progress-waiting";
            return;
        }
        if($order->status == "finish") {
            echo "finish";
            return;
        }
        if($component->stock < $order->quantity && $status == "on-progress" && $order->status == "waiting") {
            echo "stock";
            return;
        }
        if($status == "on-progress" && $order->status == "waiting") {
            echo $this->M_Component->update($component->id, [
                "stock" => $component->stock - $order->quantity
            ]);
        }
        
        if($status == "on-progress") {
            $data = [
                "actual_start" => date('Y-m-d')
            ];
        } else {
            $data = [
                "actual_finish" => date('Y-m-d')
            ];
        }
        $data["status"] = $status;
        $data['done'] = 0;
        if($order->status == "waiting") {
            $data['level'] = $component->level;
        } else if($order->status == "on-progress" && $status == "on-progress") {
            if($order->done == 0) {
                echo "set done first";
                return;
            }
            if($this->session->user->role != "assembly") {
                echo "only assembly";
                return;
            }
            echo $this->session->user->role;
            if($level < $order->level) {
                $data['level'] = $level;
            } else {
                echo "wrong level";
                return;
            } 
        }
        if($status == "finish" && $order->level != 5) {
            echo "must from level 5";
            return;
        }
        if($status == "finish" && $order->done == 0) {
            echo "set done first";
            return;
        }
        $data['done'] = 0;
        echo $this->M_Order->update($id, $data);

    }

    public function update()
    {
        $id = $this->input->post("id");
        $data = [
            "quantity" => $this->input->post("quantity")
        ];
        echo $this->M_Order->update($id, $data);
    }

    public function delete()
    {
        $id = $this->input->post("id");
        echo $this->M_Order->delete($id);
    }

    public function hide() 
    {
        $id = $this->input->post("id");
        echo $this->M_Order->update($id, [
            "visible" => 0
        ]);
    }

    public function set_done()
    {
        if($this->session->user->role != "assembly") {
            echo "only assembly";
            return;
        }
        $id = $this->input->post("id");
        echo $this->M_Order->update($id, [
            "done" => 1
        ]);
    }

    public function report()
    {
        $products = $this->M_Product->getAll();
        $reports = [];
        foreach($products as $product) {
            $p = [
                "id" => $product->id,
                "name" => $product->name,
                "components" => []
            ];
            $components = $this->M_Component->getByProductId($product->id);
            foreach($components as $component) {
                $report = $this->M_Order->getReport($component->id);
                $r = [
                    "waiting" => 0,
                    "on-progress" => 0,
                    "finish" => 0
                ];
                foreach($report as $re) {
                    $r[$re->status] = intval($re->jumlah);
                }
                $p["components"][] = [
                    "id" => $component->id,
                    "name" => $component->name,
                    "reports" => $r
                ];
            }
            $reports[] = $p;
        }

        echo json_encode($reports);
    }
}
