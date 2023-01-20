<?php 

class Dbislem extends CI_Controller{
	
	public function index()
    {

        // tüm ürünleri getirmek için kullanılan metot
        $rows = $this->db->get("product")->result();

        foreach ($rows as $row)
        {
            print_r($row);
        }

    }

    public function insertProduct()
    {
        // ürün yükleme metodu
        $kaynak = file_get_contents("file:///D:/sql/products.json");
        $result = json_decode($kaynak,true);
        foreach ($result as $res)
        {
            $product_id=$res['product_id'];
            $product_title = $res['title'];
            $category_id = $res['category_id'];
            $category_title = $res['category_title'];
            $author = $res['author'];
            $list_price = $res['list_price'];
            $stock_quantity = $res['stock_quantity'];
            $data = array(
                'product_id'=>$product_id,
                'title'=>$product_title,
                'category_id'=>$category_id,
                'category_title'=>$category_title,
                'author'=> $author,
                'list_price' =>$list_price,
                'stock_quantity'=>$stock_quantity
            );
           $result = $this->db->insert('product',$data);
        }
        if($result == 1)
        {
            echo "Ürün Yükleme İşlemi Başarılı";
        }
        else {
            echo "Ürün yüklemede hata oluştu";
        }

    }
}

?>