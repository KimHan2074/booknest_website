<?php 

class cartModel extends DModel {

    public function __construct() {
        parent::__construct();
    }

    public function getCartByUserIdAndStatus($user_id, $status) {
        $sql = "SELECT * FROM `orders` WHERE `user_id` = :user_id AND `status` = :status LIMIT 1";
        
        $data = [':user_id' => $user_id, 'status' => $status];
        return $this->db->select($sql, $data);
    }
    public function getUserCart($user_id, $status) {
        $sql = "SELECT 
                    books.book_id,
                    books.title,
                    books.price,
                    order_items.quantity,
                    (books.price * order_items.quantity) AS total_price_per_item,
                    images.path AS image_path,
                    orders.total_price
                FROM 
                    orders
                JOIN 
                    order_items ON orders.order_id = order_items.order_id
                JOIN 
                    books ON order_items.book_id = books.book_id
                LEFT JOIN 
                    images ON books.book_id = images.book_id
                WHERE 
                    orders.user_id = :user_id
                    AND orders.status = :status
                GROUP BY 
                    order_items.order_item_id
                ORDER BY 
                    books.title ASC;
                ";
        
        $data = [':user_id' => $user_id,
                 ':status' => $status];
        return $this->db->select($sql, $data);
    }
    
    public function createNewCart($table_orders, $data) {
        return $this->db->insertCart($table_orders, $data);
    }

}