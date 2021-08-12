<?php

    session_start();
    echo "Loggin Out";
    session_destroy();
    header("Location: /")
?>