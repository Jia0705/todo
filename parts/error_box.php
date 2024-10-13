<?php if ( isset(  $_SESSION['error'] ) ) : ?>
    <div class="alert alert-danger" role="alert">
        <?= $_SESSION['error']; ?>
        <?php
            // remove error from $_SESSION after displaying it
            unset( $_SESSION['error'] );
        ?>
    </div>
<?php endif; ?>