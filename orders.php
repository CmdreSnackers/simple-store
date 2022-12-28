<?php
//require the header
session_start();

require 'includes/functions.php';

require 'parts/header.php'
?>
    <div class="container mt-5 mb-2 mx-auto" style="max-width: 900px;">
      <div class="min-vh-100">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h1 class="h1">My Orders</h1>
        </div>

        <!-- List of orders placed by user in table format -->
        <table
          class="table table-hover table-bordered table-striped table-light"
        >
          <thead>
            <tr>
              <th scope="col">Order ID</th>
              <th scope="col">Products</th>
              <th scope="col">Total Amount</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>
                <ul class="list-unstyled">
                  <li>Product 1</li>
                  <li>Product 2</li>
                </ul>
              </td>
              <td>$80</td>
              <td>Pending Payment</td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>
                <ul class="list-unstyled">
                  <li>Product 3</li>
                  <li>Product 4</li>
                </ul>
              </td>
              <td>$60</td>
              <td>Completed</td>
            </tr>
          </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center my-3">
          <a href="/" class="btn btn-light btn-sm"
            >Continue Shopping</a
          >
        </div>
      </div>

      <!-- footer -->
      <div class="d-flex justify-content-between align-items-center pt-4 pb-2">
        <div class="text-muted small">
          © 2022 <a href="/" class="text-muted">My Store</a>
        </div>
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

