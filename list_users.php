<a href="index.php">Link to the form >></a> <br><br>

<?php

require_once './connecting_DSN.php';

//Display the user table database in the HTML

$stmt_all_data = $pdo->prepare('
SELECT *
FROM users
INNER JOIN users_has_addresses uha 
    on users.id_user = uha.users_id_user
INNER JOIN addresses a 
    on uha.addresses_id_address = a.id_address
INNER JOIN countries c 
    on a.countries_id_country = c.id_country
');

$stmt_all_data->execute([]);
$user_all_data = $stmt_all_data->fetchAll();

 foreach ($user_all_data as $row) {
    echo "{$row['first_name']} - {$row['last_name']} - {$row['birthdate']} - {$row['email']} - {$row['phone']} - {$row['civility']} - {$row['sex']} - {$row['street']} - {$row['postal_code']} - {$row['city']} - {$row['country_name']}<br><br>";
}