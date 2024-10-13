<?php require 'parts/header.php'; ?>
    <div
      class="card rounded shadow-sm"
      style="max-width: 500px; margin: 60px auto 20px auto;"
    >
      <div class="card-body">
        <h3 class="card-title mb-3">My Todo List</h3>
        <?php if ( isset( $_SESSION['user'] ) ) : ?>
        <?php
            // connect to the database
            $database = connectToDB();

            // load the data
            // SQL command (recipe)
            $sql = "SELECT * FROM todos WHERE user_id = :user_id";
            // prepare (prepare your material)
            $query = $database->prepare( $sql );
            // execute (cook)
            $query->execute([
              "user_id" => $_SESSION['user']['id']
            ]);
            // fetch all (eat)
            $tasks = $query->fetchAll();
        ?>
        <!-- logged in user -->
         <p>Welcome back, <?= $_SESSION['user']['name']; ?> (<?= $_SESSION['user']['email']; ?>)</p>
         <ul class="list-group">
        <?php foreach ( $tasks as $task ) : ?>
          <li
            class="list-group-item d-flex justify-content-between align-items-center"
          >
            <div>
                <form method="POST" action="/task/update">
                    <input type="hidden" name="task_id" value="<?= $task['id']; ?>" />
                    <input type="hidden" name="completed" value="<?= $task['completed']; ?>" />
                    <?php if ( $task['completed'] == 1 ) : ?>
                        <button class="btn btn-sm btn-success">
                            <i class="bi bi-check-square"></i>
                        </button>
                        <span class="ms-2"><?= $task['label']; ?></span>
                    <?php else : ?>
                        <button class="btn btn-sm btn-light">
                            <i class="bi bi-square"></i>
                        </button>
                        <span class="ms-2"><?= $task['label']; ?></span>
                    <?php endif; ?>
                </form>
            </div>
            <div>
                <form method="POST" action="/task/delete">
                    <input type="hidden" name="task_id" value="<?= $task['id']; ?>" />
                    <button class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
          </li>
          <?php endforeach; ?>

        </ul>
        <div class="mt-4">
          <?php require 'parts/error_box.php' ?>
          <form 
            method="POST"
            action="/task/add"
            class="d-flex justify-content-between align-items-center">
            <input
              type="text"
              class="form-control"
              placeholder="Add new item..."
              name="task_name"
            />
            <button class="btn btn-primary btn-sm rounded ms-2">Add</button>
          </form>
        </div>
      <?php else : ?>
        <!-- not logged in user -->
        <p>Please login to continue</p>
        <a href="/login">Login</a>
        <a href="/signup">Sign Up</a>
      <?php endif; ?>
      </div>
    </div>

    <!-- Logout + Manage Users button for admin -->
    <?php if ( (isset ( $_SESSION['user'] )) && ($_SESSION['user']['role'] == 'admin') ) : ?>
      <div class="text-center">
        <a href="/manage-users">Manage Users</a>
        <a href="/logout">Logout</a>
      </div>
    <!-- Logout button only for users -->
    <?php elseif ( isset( $_SESSION['user'] ) ) : ?>
      <div class="text-center">
        <a href="/logout">Logout</a>
      </div>
    <?php endif ; ?>

<?php require 'parts/footer.php'; ?>