<?php

    // remove the user session
    unset( $_SESSION['user'] );

    // redirect back to index.php
    header("Location: index.php");
    exit;