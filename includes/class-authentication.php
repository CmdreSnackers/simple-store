<?php
class authentication
{
    public $database;

    public function __construct()
    {
        // this function will trigger on call
        $this->database = connecttodb();
    }

    public function login($email = '', $password = '')
    {
        $error = '';

        // make sure all the fields are filled
        if ( 
            empty( $email ) || 
            empty( $password )
        ) {
            $error = 'All fields are required.';
        }


        if ( !empty( $error ) )
            return $error;


        // find the user in database using the provided email
        $statement = $this->database->prepare(
            'SELECT * FROM users WHERE email = :email'
        );

        $statement->execute([
            'email' => $email 
        ]);

        // fetch one result from database
        $user = $statement->fetch();

        // if $user exists, it means the user exists in the database
        if ( $user ) {
            // check password
            if ( 
                password_verify( $password, $user['password'] ) 
            ) {
                // assign user data to user session
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email']
                ];

                // redirect user back to index
                header('Location: /');
                exit;

            } else {
                return 'invalid email or password';
            }
        } else {
            // user doesn't exists
            return 'invalid email or password';
        }
    }

    public function signup($email = '', $password = '', $confirm = '')
    {

        $error = '';

        if(empty($email) || 
        empty($password) || 
        empty($confirm)) {
            $error = 'Must fill all fields';
        }


        // check to make sure confirm is the same as password
        if(
            !empty($password) && //make sure password is not empty
            !empty($confirm) &&// to make sure confirm is not empty
            $password !== $confirm
        ) {
            $error = 'Passwords should match';
        }

        //if not error, proceed with signup
        if ( !empty( $error ) )
            return $error;

        // make sure user's email wasn't already exists in database
        $statement = $this->database->prepare(
            'SELECT * FROM users WHERE email = :email'
        );

        $statement->execute([
            'email' => $email 
        ]);

        // fetch one result from database
        $user = $statement->fetch();

        // if user exists, return error
        if ( $user ) {
            return 'Email already exists';
        } else {
            // if user doesn't exists, insert user data into database
            $statement = $this->database->prepare(
                'INSERT INTO users ( email, password )
                VALUES (:email, :password )'
            );

            $statement->execute([
                'email' => $email,
                'password' => password_hash( $password, PASSWORD_DEFAULT )
            ]);

            // redirect the user back to /login
            header('Location: /login');
            exit;

        }
    }
}