<?php

class Products
{
    public $database;

    public function __construct()
    {
        try {
            //try to connect to db
            $this->database = connecttodb();
        } catch (PDOException $error) {
            die("Database Connection Failed");
        }
    }
    
      /**
       * Summary of listAllProducts
       * retrieve all productes from database
       */

    public function listAllProducts()
    {
        // prepare the database, execute and fetchAll
        $statement = $this->database->prepare('SELECT * FROM products');
        //execute
        $statement->execute();
        /**
         * fetchall
         * use PDO::FETCH_OBJ if array ->name
         * use PDO::FETCH_ASSOC if object ['name]
         * leave empty for PDO::FETCH_BOTH
        */
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findProduct($product_id)
    {

        //find product on product_id
        $statement = $this->database->prepare('SELECT * FROM products WHERE id = :id');

        $statement->execute([
            'id' => $product_id
        ]);
        
        //retreive product
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    // . $error->getMessage()

}