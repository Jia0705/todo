<?php
  // start session
  session_start();

  // import all the required files
  require "includes/functions.php";

  // load the class files
  require 'includes/class-auth.php';

  // initiatise the classes
  $auth = new Auth();

  require 'includes/class-task.php';

  $task = new Task();

  require 'includes/class-user.php';

  $user = new User();

  // figure out the url the user is visiting
  $path = $_SERVER["REQUEST_URI"];
  //removes the question mark in url
  $path = parse_url( $path, PHP_URL_PATH );
   
  // once you figure out the path the user is visiting, load relevant content
  switch( $path ) {
    // Auth
    case '/auth/login':
      $auth->login();
      break;
    case '/auth/signup':
      $auth->signup();
      break;
    case '/task/add':
     $task->add();
      break;
    case '/task/update':
      $task->update();
      break;
    case '/task/delete':
      $task->delete();
      break;
    
    //user
    case '/user/delete':
          $user->delete();
          break;

    case '/user/edit':
         $user->edit();
           break;

    case '/user/changepwd':
          $user->changepwd();
          break;

    case '/user/add':
        $user->add();
          break;
    // pages
    case '/login':
      require 'pages/login.php';
      break;
    case '/signup':
      require 'pages/signup.php';
      break;
    case '/logout':
      require 'pages/logout.php';
      break;
    case '/manage-users':
      require 'pages/manage-users.php';
      break;
    case '/user_add':
      require 'pages/manage-users-add.php';
      break;
    case '/user_edit':
      require 'pages/manage-users-edit.php';
      break;
    case '/user_change_psw':
      require 'pages/manage-users-change-psw.php';
      break;
    default:
      require 'pages/home.php';
      break;
  }