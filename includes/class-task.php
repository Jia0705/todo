<?php

class Task
{
    public $database;

     // run this code when the object is created
     function __construct() {
        $this->database = connectToDB();
    }

    public function add(){
        $task_name = $_POST['task_name'];

    // make sure task_name is not empty
        if ( empty( $task_name ) ) {
            setError( "Please insert a task", "/" );
        } else {
            // add task into todos table
            // sql command
            $sql = "INSERT INTO todos (`label`,`user_id`) VALUES (:label, :user_id)";
            // prepare
            $query = $this -> database ->prepare( $sql );
            // execute
            $query->execute([
                'label' => $task_name,
                'user_id' => $_SESSION['user']['id']
            ]);

            // redirect back to /
            header("Location: /");
            exit;
        }
    }
    public function delete(){
        $id = $_POST['task_id'];

        // delete the task from the table
        // sql command
        $sql = "DELETE FROM todos WHERE id = :id";
        // prepare
        $query = $this -> database ->prepare( $sql );
        // execute
        $query->execute([
            'id' => $id
        ]);

        // redirect back to /
        header("Location: /");
        exit;
    }
    public function update(){
        
        $id = $_POST['task_id'];
        $completed = $_POST['completed'];

        // update the task
        if ( $completed == 1 ) {
            // sql command
            $sql = "UPDATE todos set completed = 0 WHERE id = :id";
        } else {
            // sql command
            $sql = "UPDATE todos set completed = 1 WHERE id = :id";
        }

        // prepare
        $query = $this -> database ->prepare( $sql );
        // execute
        $query->execute([
            'id' => $id
        ]);
        // redirect back to /
        header("Location: /");
        exit;
      }
}