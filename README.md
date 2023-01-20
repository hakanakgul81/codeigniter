
# D&R 

PHP dilinde codeigniter framework'ü üzerinde bu geliştirme yapılmıştır.
Veritabanı olarak MySQL kullanılmıştır.

Veritabanı dr.sql dosyasında yer almaktadır.

Sipariş Oluşturma servisi:

http://localhost/codeigniter/order/addorder

Servisin tetiklenebilmesi için gerekli bilgiler 
Collection olarak ayrıca iletilecektir.


Sipariş Sorgulama Servisi:

http://localhost/codeigniter/order/getOrderResult/27

Servisin tetiklenebilmesi için gerekli bilgiler Collection olarak 
ayrıca iletilecektir. 


Ayrıca ürünleri json dosya okuma yöntemiyle veritabanına eklenmiştir.
Yeni ürün eklenmek istendiğinde bu fonksiyon kullanılabilir.

application\controllers\dbislem\insertProduct.PHP
dosyasında gerekli kodları bulunmaktadır.