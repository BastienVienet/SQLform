<?php

require_once './connecting_DSN.php';

//Getting the date from the user
$stmt_all_data = $pdo->prepare('
SELECT *
FROM users
INNER JOIN users_has_addresses uha 
    on users.id_user = uha.users_id_user
INNER JOIN addresses a 
    on uha.addresses_id_address = a.id_address
INNER JOIN countries c 
    on a.countries_id_country = c.id_country
WHERE id_user = :id_user
');

//Getting the id from the URL and retrieving all the data from that id line
$stmt_all_data->execute([
        'id_user' => $_GET['id']
]);
$user_all_data = $stmt_all_data->fetch();

if (isset($_POST['submit'])) {

    //Delete in 'users_has_addresses' table
    $stmt_user = $pdo->prepare('
    DELETE FROM users_has_addresses
    WHERE users_id_user = :users_id_user;
    ');

    $stmt_user->execute([
            'users_id_user' => $_GET['id']
    ]);

    //Delete in 'users' table
    $stmt_user = $pdo->prepare('
    DELETE FROM users
    WHERE id_user = :id_user;
    ');

    $stmt_user->execute([
            'id_user' => $_GET['id']
    ]);

    ?>

    <div class="notification is-success is-light">
        <button class="delete"></button>
        You successfully deleted your profile data!
        Create a new user
        <a href="index.php">here</a> or see the user cards <a href="list_users.php">here</a> !
    </div>

    <?php
}

require_once './header.php';

?>

    <section class="section">
        <div class="container">
            <h1 class="title is-1">
                Are you sure you want to delete your data ?</h1>
            <h2 class="subtitle">Notice : This action is irreversible, and you won't be able to have your data back. Be
                                 careful before proceeding.</h2><br>
            <div class="columns is-multiline">
                <div class="is-child box column">
                    <form action="delete_user.php?id=<?= $user_all_data['id_user'] ?>"
                          method="post">
                        <input class="button is-danger is-outlined is-light"
                               id="submit_id"
                               type="submit"
                               name="submit"
                               value="Yes">
                        <a href="list_users.php#<?= $user_all_data['first_name'] . "-" . $user_all_data['last_name'] . "-" . $_GET['id'] ?>">
                            <input class="button is-info is-outlined is-light"
                                   id="delete_user_no"
                                   name="delete_user_no"
                                   value="No, go back to my card.">
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php

require_once 'footer.php';