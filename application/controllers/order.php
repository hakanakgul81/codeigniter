<?php

class order extends CI_Controller
{
    public function addOrder()
    {
        $shipping_price = 10;

        $this->load->model("Customer_Model");

        $OrderLines = file_get_contents('php://input');
        $orderdetail = json_decode($OrderLines, true);
        $orderheader = array();
        $orderheader = $orderdetail[0];

        array_shift($orderdetail);


        $order_products = array();
        $total = 0;
        $count = 0;
        $quantity = 0;
        foreach ($orderdetail as $product) {

            $result = $this->Customer_Model->getProduct($product['product_id']);
            if($result ==null)
            {
                print_r("Ürün Bulunamadı, Sipariş oluşturulamadı");
                exit;
            }

            $quantity = $result[0]->stock_quantity - $product['quantity'];

            if($result[0]->stock_quantity < $product['quantity'])
            {
                echo "Yeterli miktarda stok bulunmadığı için sipariş verilemez. ToplamStok Sayısı: ".$result[$count]->stock_quantity;
                exit;
            }


            $this->Customer_Model->updateProductStock($product['product_id'],$quantity);

            $result[0]->quantity= $product['quantity'];
            $result[0]->total = $result[0]->list_price * $product['quantity'];
            $order_products = array_merge($order_products,$result);
            $total = $total + $result[0]->total;

        }

        if($total < 50)
        {
            $total = $total + 10;
            $orderheader['shipping_method'] = 'Standart Kargo';
        }
        else {
            $orderheader['shipping_method'] = 'Ucretsiz Kargo';
        }

        $data = array(
            'customer_firstname'=>$orderheader['customer_firstname'],
            'customer_lastname'=>$orderheader['customer_lastname'],
            'phone'=>$orderheader['phone'],
            'email'=>$orderheader['email'],
            'city'=>$orderheader['city'],
            'district'=>$orderheader['district'],
            'total'=>$total,
            'shipping_method'=>$orderheader['shipping_method']
        );

        $result1 = $this->db->insert('customer_Order',$data);

        if($result1 != 1)
        {
            echo "sipariş oluşurken hata oluştu.";
        }

        $orderresult= $this->Customer_Model->getOrder();

        $order_id = $orderresult[0]->ordernumber;
        $ordertotal = 0;
        foreach ($order_products as $orderp)
        {
          $datadetail = array(
              'order_id'=>$order_id,
              'product_id'=>$orderp->product_id,
              'name'=>$orderp->title,
              'quantity'=>$orderp->quantity,
              'price'=>$orderp->list_price,
              'total'=>$orderp->total,
          );

          $result2=$this->db->insert('customer_order_lines',$datadetail);
          if($result2 != 1)
          {
              echo "sipariş detayları oluşurken hata oluştu.";
          }
        }

        echo "siparişiniz başarıyla oluştu. Sipariş numaranız: ".$order_id;
    }
    public function getOrderResult($orderid)
    {
        $this->load->model("Customer_Model");

        $result = $this->Customer_Model->getOrderHeader($orderid);

        $resultdetail = $this->Customer_Model->getOrderDetail($orderid);
        echo "<pre>";
        print_r($result[0]);
        echo "Sipariş Detayları<br>";
        print_r($resultdetail);
    }
}