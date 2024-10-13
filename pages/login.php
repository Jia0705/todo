<?php require 'parts/header.php'; ?>
    <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
      <div class="card-body">
        <h5 class="card-title text-center mb-3 py-3 border-bottom">
          Login To Your Account
        </h5>
        <?php require 'parts/error_box.php' ?>
        <!-- login form-->
        <form action="/auth/login" method="POST">
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
              type="password"
              class="form-control"
              id="password"
              name="password"
            />
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-fu">Login</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Go back link -->
    <div class="text-center">
      <a href="/" class="text-decoration-none"
        ><i class="bi bi-arrow-left-circle"></i> Go back</a
      >
    </div>

<?php require 'parts/footer.php';