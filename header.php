<?php

if (isset($_POST['Log_out'])) {
    disconnect();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title>Testing php and db interactions</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <script crossorigin="anonymous"
            src="https://kit.fontawesome.com/240835c993.js"></script>
    <style>
        .button_fixed {
            position: fixed;
            right: 10px;
            bottom: 10px;
        }
    </style>
</head>
<body>
<nav class="navbar mx-3"
     role="navigation"
     aria-label="main navigation">
    <div class="navbar-brand">
        <a role="button"
           class="navbar-burger"
           aria-label="menu"
           aria-expanded="false"
           data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div id="navbarBasicExample"
         class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item"
               href="index.php">Form
            </a>
            <a class="navbar-item"
               href="list_users.php">Users
            </a>
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <form action="index.php"
                      method="post">
                    <label for="Log_out">
                        <input class="button is-primary"
                               type="submit"
                               id="Log_out"
                               name="Log_out"
                               value="Log out">
                    </label>
                </form>
            </div>
        </div>
    </div>
</nav>