<?php

class User
{
    public $database;

    function __construct() {
        $this->database = connectToDB();
    }

    public function add(){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $role = $_POST['role'];
        
        if ( empty( $name ) || empty( $email ) || empty( $password ) || empty( $confirm_password )  || empty( $role) ) {
            setError( "All the fields are required.", '/user_add' );
        } else if ( $password !== $confirm_password ) {
            //  make sure password is match
            setError( "The password is not match", '/user_add' );
        } else if ( strlen( $password ) < 8 ) {
            // make sure the password length is at least 8 chars
            setError( "Your password must be at least 8 characters", '/user_add' );
        } else {  
    
            // - make sure the email entered does not exists yet
            $sql = "SELECT * FROM users where email = :email";
            $query = $this->database->prepare( $sql );
            $query->execute([
                'email' => $email
            ]);
            $user = $query->fetch(); // get only one row of data
    
            // 4. create the user account. Remember to assign role to the user
            if ( $user ) {
                setError("The email provided has already been used.","/manage-users-add");
            } else {
                // create the user account
                // sql command (recipe)
                $sql = "INSERT INTO users (`name`,`email`,`password`,`role`) VALUES (:name, :email, :password, :role)";
                // prepare (put everything into the bowl)
                $query = $this->database->prepare( $sql );
                // execute (cook it)
                $query->execute([
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash( $password, PASSWORD_DEFAULT ),
                    'role' => $role
                ]);
            
                // redirect back to /manage-users
                $this->redirectBackToManageUsers();
            }
        }
    }

    public function delete(){
        // 2. get the user_id from the form
        $user_id = $_POST["id"];

        // 3. delete the user
        // 3.1
        $sql = "DELETE FROM users where id = :id";
        // 3.2
        $query = $this->database->prepare( $sql );
        // 3.3
        $query->execute([
            'id' => $user_id
        ]);

        // redirect back to /manage-users
        $this->redirectBackToManageUsers();
    }

    public function edit(){
        // 2. get all the data from the form using $_POST
        $name = $_POST['name'];
        $role = $_POST['role'];
        $id = $_POST['id'];
        // 3. do error checking - make sure all the fields are not empty
        if ( empty( $name ) || empty( $role ) ) {
            setError( "All fields are required", '/user_edit?id=' . $id );
        }
        // 4. update the user data
        
        // 4.1
        $sql = "UPDATE users SET name = :name, role = :role WHERE id = :id";
        // 4.2
        $query = $this->database->prepare( $sql );
        // 4.3
        $query->execute([
            'name' => $name,
            'role' => $role,
            'id' => $id
        ]);
        // redirect back to /manage-users
        $this->redirectBackToManageUsers();
    }
    
    public function changepwd() {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $id = $_POST['id'];
        if (empty($password) || empty($confirm_password)) {
            setError("Please fill in all fields.", '/user_change_psw?id=' . $id);
        } else if ($password !== $confirm_password) {
            setError("Passwords must be the same.", '/user_change_psw?id=' . $id);
        } else {
            $sql = "UPDATE users SET password = :password WHERE id = :id";
            $query = $this->database->prepare($sql);
            $query->execute([
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'id' => $id
            ]);

            // redirect back to /manage-users
            $this->redirectBackToManageUsers();
        }
    }

    public function redirectBackToManageUsers() {
        header("Location: /manage-users");
        exit;
    }
}