<?php
//require the header
session_start();

require 'includes/functions.php';
require 'includes/class-products.php';
require 'includes/class-cart.php';


$cart = new Cart();

// make sure it's POST request
if ( $_SERVER["REQUEST_METHOD"] == 'POST' ) {

    //if$_post action is remove then trigger function
    if(isset($_POST['action']) && $_POST['action'] =='remove' )
    {
        //remove from cart
        $cart->removeProductFromCart($_POST['product_id']);
    } else {
        // make sure product_id is available in $_POST
        if ( isset( $_POST['product_id'] ) ) 
        {
            // add product_id into cart
            $cart->add( $_POST['product_id'] );
        }
    }
}





require 'parts/header.php'
?>

        <div class="container mt-5 mb-2 mx-auto" style="max-width: 900px;">
            
            <div class="min-vh-100">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h1">My Cart</h1>
                </div>
    
                <!-- List of products user added to cart -->
                <table class="table table-hover table-bordered table-striped table-light">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($cart->listAllProductsinCart())):?>
                        <tr>
                            <td colspan="5">
                                Your cart is empty.
                            </td>
                        </tr>
                    <?php else:?>
                    <?php foreach($cart->listAllProductsinCart() as $product): ?>
                        <tr>
                            <td><?php echo $product['name']; ?></td>
                            <td>$<?php echo $product['price']; ?></td>
                            <td><?php echo $product['quantity'];?></td>
                            <td><?php echo $product['total']; ?></td>
                            <td>
                                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                                    <!-- specify as remove -->
                                    <input type="hidden" name="action" value="remove">
                                    <!-- specify item to be removed -->
                                    <input type="hidden" name="product_id" value="<?php echo $product['id'];?>">
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach;?>
                        <tr>
                            <td colspan="3" class="text-end">Total</td>
                            <td>$<?php echo $cart->total();?></td>
                            <td></td>
                        </tr>
                    <?php endif;?> <!-- end -empty -->
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center my-3">
                    <a href="/" class="btn btn-light btn-sm">Continue Shopping</a>
                    <!-- only show Checkout if item in cart -->
                    <?php if(!empty($cart->listAllProductsinCart())): ?>
                        <form action="/checkout" method="POST">
                            <input type="hidden" name="" value="">
                            <button class="btn btn-primary">Checkout</a>
                        </form>
                    <?php endif;?>
                </div>

            </div>

            <!-- footer -->
            <div class="d-flex justify-content-between align-items-center pt-4 pb-2">
                <div class="text-muted small">© 2022 <a href="/" class="text-muted">My Store</a></div>
                <div class="d-flex align-items-center gap-3">
                    <a href="/login" class="btn btn-light btn-sm">Login</a>
                    <a href="/signup" class="btn btn-light btn-sm">Sign Up</a>
                    <a href="/orders" class="btn btn-light btn-sm">My Orders</a>
                </div>
            </div>

        </div>
        
<?php
//require the footer
require 'parts/footer.php'
?>