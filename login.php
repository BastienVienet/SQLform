<?php

require_once './authentification.php';


if (isset($_POST['submit'])) {
    if(connect($_POST['username'], $_POST['password'])) {
        header('Location: index.php');
        exit();
    } else { ?>
        <div class="notification is-danger is-light">
            <button class="delete"></button>
        Authentification failed. The username and/or the password is not correct
        </div>
    <?php }
}


require_once './header.php';

?>

    <section class="section">
        <div class="container">
            <h1 class="title is-1">
                Connect you here to access the database and all the infos !</h1>
            <h2 class="subtitle">Notice : Only the administrator can do that.</h2><br>
            <div class="columns is-multiline">
                <div class="is-child box column is-8 is-offset-2">
                    <form action="login.php"
                          method="post">
                        <label for="first_name">Username<br>
                            <input class="input is-normal"
                                   type="text"
                                   name="username"
                                   placeholder="Enter your username"
                                   required><br><br>
                        </label>
                        <label for="last_name">Password<br>
                            <input class="input is-normal"
                                   type="password"
                                   name="password"
                                   placeholder="Enter your password"
                                   required><br><br>
                        </label>
                        <input class="button is-primary is-outlined is-light"
                               id="submit_id"
                               type="submit"
                               name="submit"
                               value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php

require_once './footer.php';