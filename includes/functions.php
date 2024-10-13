<?php

// connect to database
function connectToDB() {
    // setup database credential
    $host = 'localhost';
    $database_name = 'todo_list';
    $database_user = 'root';
    $database_password = 'GohSheryn0524_';

    // connect to the database
    $database = new PDO(
        "mysql:host=$host;dbname=$database_name",
        $database_user,
        $database_password
    );
    
    return $database;
}

// set error message
function setError( $error_message, $redirect_page ) {
    $_SESSION["error"] = $error_message;
    // redirect back to login page
    header("Location: " . $redirect_page );
    exit;
}


// check if user is logged in or not
function checkIfuserIsNotLoggedIn() {
  if ( !isset( $_SESSION['user'] ) ) {
    header("Location: /login");
    exit;
  }
}

// check if current user is an admin or not
function checkIfIsNotAdmin() {
    if ( isset( $_SESSION['user'] ) && $_SESSION['user']['role'] != 'admin' ) {
        header("Location: /dashboard");
        exit;
    }
}

