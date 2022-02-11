<?php

require_once './connecting_DSN.php';

if (isset($_POST['submit'])) {

    //Enter a country in my 'countries' table in my database
    $country = ucfirst(mb_strtolower(trim($_POST['country'])));
    // Test if country exists : Check in database
    $stmt_country_exist_or_not = $pdo->prepare(
            'SELECT * FROM countries WHERE country_name = :country');

    $stmt_country_exist_or_not->execute([
            'country' => $country
    ]);

    $existant_country = $stmt_country_exist_or_not->fetchAll();

    if ($existant_country) {
        $id_country = $existant_country[0]['id_country'];
    } else {
        //Enter the new country in my database
        $stmt_country = $pdo->prepare(
                'INSERT INTO countries (country_name)
                   VALUE (:country) ');
        $stmt_country->execute([
                'country' => $country
        ]);

        $id_country = $pdo->lastInsertId();
    }

    //Enter an address in my 'address' table in my database
    $stmt_address = $pdo->prepare(
            'INSERT INTO addresses (street, postal_code, city, countries_id_country) 
                   VALUES (:street, :postal_code, :city, :countries_id_country)');

    $stmt_address->execute([
            'street' => $_POST['street'],
            'postal_code' => $_POST['postal_code'],
            'city' => $_POST['city'],
            'countries_id_country' => $id_country
    ]);

    $id_address = $pdo->lastInsertId();


    //Enter a user in my 'users' table in my database
    $stmt_user = $pdo->prepare(
            'INSERT INTO users (first_name, last_name, birthdate, email, phone, civility, sex)
                   VALUES (:first_name, :last_name, :birthdate, :email, :phone, :civility, :sex) ');

    $stmt_user->execute([
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'birthdate' => $_POST['birthdate'],
            'email' => mb_strtolower($_POST['email']),
            'phone' => $_POST['phone'],
            'civility' => $_POST['civility'],
            'sex' => $_POST['sex'],
    ]);

    $id_user = $pdo->lastInsertId();

    //Linking 'users' and 'address' in my 'user_has_address' table in my database
    $stmt_users_has_addresses = $pdo->prepare(
            'INSERT INTO users_has_addresses (users_id_user, addresses_id_address) 
                   VALUES (:users_id_user, :addresses_id_address)');

    $stmt_users_has_addresses->execute([
       'users_id_user' => $id_user,
       'addresses_id_address' => $id_address,
    ]);

}
?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta content="width=device-width, initial-scale=1"
              name="viewport">
        <title>Testing php and db interactions</title>
        <script crossorigin="anonymous"
                src="https://kit.fontawesome.com/240835c993.js"></script>
        <link rel="stylesheet"
              href="stylesheet.css">
    </head>
    <body>
    <h1>Testing php and databases interactions with PDO</h1>
    <h2>Notice : All of these data are going to be collected to my computer</h2>
    <a href="list_users.php">See the users page with their data >></a>
    <form action="index.php"
          method="post">
        <h3>User Table</h3>
        <label for="first_name">First name<br>
            <input type="text"
                   name="first_name"
                   placeholder="Enter your first name"
                   required><br><br>
        </label>
        <label for="last_name">Last name<br>
            <input type="text"
                   name="last_name"
                   placeholder="Enter your last name"
                   required><br><br>
        </label>
        <label for="birthdate">Birthdate<br>
            <input type="date"
                   name="birthdate"
                   placeholder="Enter your birthdate"
                   required><br><br>
        </label>
        <label for="email">Email<br>
            <input type="email"
                   name="email"
                   placeholder="Enter your email"
                   required><br><br>
        </label>
        <label for="phone">Phone number<br>
            <input type="tel"
                   name="phone"
                   maxlength="10"
                   placeholder="Enter your phone number"><br>
        </label>
        <p>Civility</p>
        <div class="radio_civility">
            <input id="civility"
                   type="radio"
                   name="civility"
                   value="1"
                   checked>
            <label for="civility">Single</label>
            <input id="civility"
                   type="radio"
                   name="civility"
                   value="2">
            <label for="civility">Married</label>
            <input id="civility"
                   type="radio"
                   name="civility"
                   value="3">
            <label for="civility">Divorced</label>
        </div>
        <p>Gender</p>
        <div class="radio_sex">
            <input id="sex"
                   type="radio"
                   name="sex"
                   value="1"
                   checked>
            <label for="sex">Male</label>
            <input id="sex"
                   type="radio"
                   name="sex"
                   value="2">
            <label for="sex">Female</label>
            <input id="sex"
                   type="radio"
                   name="sex"
                   value="3"><br>
            <label for="sex">Other</label>
        </div>
        <h3>Address table</h3>
        <label for="country">Country<br>
            <input type="text"
                   name="country"
                   placeholder="Enter your country"
                   required><br><br>
        </label>
        <label for="street">Street<br>
            <input type="text"
                   name="street"
                   placeholder="Enter your street"
                   required><br><br>
        </label>
        <label for="postal_code">Postal code<br>
            <input type="number"
                   min="1000"
                   max="9999"
                   name="postal_code"
                   placeholder="NPA"><br><br>
        </label>
        <label for="city">City<br>
            <input type="text"
                   name="city"
                   placeholder="Enter your city"
                   required><br><br>
        </label>
        <input id="submit_id"
               type="submit"
               name="submit"
               value="submit"><br><br><br>
    </form>
    </body>
    </html>