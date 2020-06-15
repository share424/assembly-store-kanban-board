<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Order extends CI_Model
{
    public function getAll()
    {
        return $this->db->select("orders.id, component.name, quantity, start_date, end_date, status, product.name as product, product.id as product_id, component.id as component_id, stock, actual_start, actual_finish, visible, level, done")
                        ->join("component", "component.id = orders.component_id")
                        ->join("product", "product.id = component.product_id")
                        ->get("orders")->result();
    }

    public function get($id)
    {
        return $this->db->where("id", $id)
                        ->get("orders")->result();
    }

    public function insert($data)
    {
        return $this->db->insert("orders", $data);
    }

    public function delete($id)
    {
        return $this->db->where("id", $id)
                        ->delete("orders");
    }

    public function update($id, $data)
    {
        return $this->db->where("id", $id)
                        ->update("orders", $data);
    }
}