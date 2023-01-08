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

        //step 4 create bill url
        $bill_url = '';

        //create bill in billplz using api
            //call api to get response data
        $response = callAPI(
            BILLPLZ_API_URL . 'v3/bills', // https://www.billplz-sandbox.com/api/v3/bills
            'POST',
            [
                'collection_id' => BILLPLZ_COLLECTION_ID,
                'email' => $_SESSION['user']['email'],
                'name' => $_SESSION['user']['email'],
                'amount' => $total_amount * 100,
                'callback_url' => 'http://simple-store.local/payment-callback',
                'description' => 'Order #' . $order_id, //order#
                'redirect_url' => 'http://simple-store.local/payment-verification'
            ],
            [
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode(BILLPLZ_API_KEY . ':')
            ]
        );

        //step 5 if response is sucessful, update order with bill id($response->id)
        if(isset($response->id)) {
            $statement = $this->database->prepare(
                'UPDATE orders SET transaction_id = :transaction_id
                WHERE id = :order_id'
            );
            $statement->execute([
                'transaction_id' => $response->id,
                'order_id' => $order_id
            ]);
        }

        //step 6 set bill_url
        if(isset($response->url)) {
            $bill_url = $response->url;
        }


        return $bill_url;
    }

    //update order
    public function updateOrder($transaction_id, $status)
    {
        //update order status using billplz id that was stored as transaction id in db
        $statement = $this->database->prepare(
            'UPDATE orders SET status = :status WHERE transaction_id = :transaction_id'
        );

        $statement->execute([
            'status' => $status,
            'transaction_id' => $transaction_id
        ]);
    }


    //list all the orders by user
    public function listOrders($user_id)
    {
        // load the order data based on given user_id
        $statement = $this->database->prepare(
            'SELECT * FROM orders WHERE user_id = :user_id
            ORDER BY id DESC'
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