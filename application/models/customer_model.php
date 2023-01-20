<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class  Customer_Model extends CI_Model
{
    public function updateProductStock($product_id, $quantity)
    {
        $this->db->set('stock_quantity', $quantity);
        $this->db->where('product_id', $product_id);
        $this->db->update('product');
    }

    public function getProduct($product_id)
    {
        $this->db->select('product_id,title,list_price,stock_quantity');
        $this->db->from('product');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get()->result();

        return $result;
    }

    public function getOrder()
    {

            $this->db->select('ordernumber');
            $this->db->from('customer_Order');
            $this->db->order_by("ordernumber", "desc");
            $orderresult = $this->db->get()->result();

        return $orderresult;
    }

    public function getOrderHeader($orderid)
    {
        $this->db->select('*');
        $this->db->from('customer_order');
        $this->db->where('ordernumber', $orderid);
        $result=$this->db->get()->result();

        return $result;
    }

    public function getOrderDetail($orderid)
    {
        $this->db->select('*');
        $this->db->from('customer_order_lines');
        $this->db->where('order_id', $orderid);
        $resultdetail=$this->db->get()->result();
        return $resultdetail;
    }
}
