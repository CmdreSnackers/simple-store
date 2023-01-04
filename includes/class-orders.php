<?php

class Orders
{
    public $database;

    public function __construct()
    {
        try {
            //db connect
            $this->database = connecttodb();
        } catch (PDOException $error) {
            die("Database connection failed");
        }

    }

    public function createNewOrder(
        $user_id, // find user who made order
        $total_amount = 0, // find total amount
        $products_in_cart = [] // get products in order
    )
    {
        //step 1 insert new order into db
        $statement = $this->database->prepare(
            'INSERT INTO orders (user_id, total_amount, transaction_id)
            VALUES (:user_id, :total_amount, :transaction_id)'
        );

        $statement->execute([
            'user_id' => $user_id,
            'total_amount' => $total_amount,
            'transaction_id' => ''
        ]);

        //step 2 retrieve order id
        //lastinsertid allows us to retrieve id of new order just made above
        $order_id = $this->database->lastInsertId();

        //step 3 create orders_products bridge
        foreach($products_in_cart as $product_id => $quantity)
        {
            // insert each product in cart as new row in orders_product
            $statement = $this->database->prepare(
                'INSERT INTO orders_products (order_id, product_id, quantity)
                VALUES (:order_id, :product_id, :quantity)'
            );

            $statement->execute([
                'order_id' => $order_id,
                'product_id' => $product_id,
                'quantity' => $quantity
            ]);
        }


    }


    //list all the orders by user
    public function listOrders($user_id)
    {
        // load the order data based on given user_id
        $statement = $this->database->prepare(
            'SELECT * FROM orders WHERE user_id = :user_id'
        );

        $statement->execute([
            'user_id' => $user_id
        ]);

        //fetch all the orders data
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    //list out all products inside a order
    public function listProductsOrder($order_id)
    {
        //retrieve products data using JOIN
        $statement = $this->database->prepare(
            'SELECT
            products.id,
            products.name,
            orders_products.order_id,
            orders_products.quantity
            FROM orders_products
            JOIN products
            ON orders_products.product_id = products.id
            WHERE order_id = :order_id'
        );

        $statement->execute([
            'order_id' => $order_id
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }
}