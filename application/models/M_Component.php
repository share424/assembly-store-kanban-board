<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Component extends CI_Model
{
    public function getAll()
    {
        return $this->db->get("component")->result();
    }

    public function getByProductId($id)
    {
        return $this->db->where("product_id", $id)
                        ->get("component")
                        ->result();
    }

    public function get($id)
    {
        return $this->db->where("id", $id)
                        ->get("component")->result();
    }

    public function insert($data)
    {
        return $this->db->insert("component", $data);
    }

    public function update($id, $data)
    {
        return $this->db->where("id", $id)
                        ->update("component", $data);
    }
}