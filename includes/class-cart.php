<?php

class Cart
{
    public function __construct()
    {

    }

    public function listAllProductsinCart()
    {
        $list = [];
        //check cart if empty
        if(isset($_SESSION['cart'])) {
            foreach($_SESSION['cart'] as $product_id => $quantity) {
                //init Products class
                $products_obj = new Products();
                //retrive product on id
                $product = $products_obj->findProduct($product_id);

                //push product_id and quantity into $list
                $list[] = [
                    'id' => $product_id,
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'total' => $product['price'] * $quantity,
                    'quantity' => $quantity
                ];
            }// end - foreach
        } //end - isset
        return $list;
    }

    public function total()
    {
        $cart_total = 0;
        //get all products in cart
        $list = $this->listAllProductsinCart();

        //calculate cart total
        foreach($list as $product) {
            $cart_total += $product['total'];
        }


        return $cart_total;
    }

    public function add( $product_id )
    {
        if ( isset( $_SESSION['cart'] ) ) {
            // assign $_SESSION['cart'] to $cart
           $cart = $_SESSION['cart']; 
        } else {
            // if no existing data, create empty array for $cart
            $cart = [];
        }

        // add product_id to $cart
        if(isset($cart[$product_id]))
        {
            //add one to value
            //long method
            //$cart[$product_id] = $cart[$product_id] + 1;
            //short method
            $cart[$product_id] += 1;
        } else {
            $cart[ $product_id ] = 1; // 1 = quantity
        }
        
        // assign $cart to $_SESSION['cart']
        $_SESSION['cart'] = $cart;
    }

    /**
    * remove product from cart
    */

    public function removeProductFromCart($product_id)
    {
        //make sure product is in cart session
        if(isset($_SESSION['cart'][$product_id])) {
            //unset it
            unset($_SESSION['cart'][$product_id]);
        }
    }

    // empty the cart
    public function emptyCart()
    {
        unset($_SESSION['cart']);
    }
}