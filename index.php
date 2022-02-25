<?php

require_once './connecting_DSN.php';

function Cleantext($text): string
{
    return ucfirst(mb_strtolower(trim($text)));
}

if (isset($_POST['submit'])) {

    //Enter a country in my 'countries' table in my database
    $country = Cleantext($_POST['country']);
    //Test if country exists : Check in database
    $stmt_country_exist_or_not = $pdo->prepare(
            'SELECT * FROM countries WHERE country_name = :country');

    $stmt_country_exist_or_not->execute([
            'country' => $country
    ]);

    $existant_country = $stmt_country_exist_or_not->fetch();

    if ($existant_country) {
        $id_country = $existant_country['id_country'];
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
            'street' => Cleantext($_POST['street']),
            'postal_code' => $_POST['postal_code'],
            'city' => Cleantext($_POST['city']),
            'countries_id_country' => $id_country
    ]);

    $id_address = $pdo->lastInsertId();


    //Enter a user in my 'users' table in my database
    $stmt_user = $pdo->prepare(
            'INSERT INTO users (first_name, last_name, birthdate, email, phone, civility, sex)
                   VALUES (:first_name, :last_name, :birthdate, :email, :phone, :civility, :sex) ');

    $stmt_user->execute([
            'first_name' => Cleantext($_POST['first_name']),
            'last_name' => Cleantext($_POST['last_name']),
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

    ?>
    <div class="notification is-success is-light">
        <button class="delete"></button>
        You got added to my database !
        Check your little card
        <a href="list_users.php#<?= $_POST['first_name'] . "-" . $_POST['last_name'] . "-" . $id_user ?>">here</a> !
    </div>
    <?php

}

require_once './header.php'
?>

    <section class="section">
        <div class="container">
            <h1 class="title is-1">
                Testing php and databases interactions with PDO</h1>
            <h2 class="subtitle">Notice : All of these data are going to be collected to my computer</h2><br>
            <div class="columns is-multiline">
                <div class="is-child box column is-8 is-offset-2">
                    <form action="index.php"
                          method="post">
                        <h3 class="title is-3">User Table</h3>
                        <label for="first_name">First name<br>
                            <input class="input is-normal"
                                   type="text"
                                   name="first_name"
                                   placeholder="Enter your first name"
                                   required><br><br>
                        </label>
                        <label for="last_name">Last name<br>
                            <input class="input is-normal"
                                   type="text"
                                   name="last_name"
                                   placeholder="Enter your last name"
                                   required><br><br>
                        </label>
                        <label for="birthdate">Birthdate<br>
                            <input class="input is-normal"
                                   type="date"
                                   name="birthdate"
                                   placeholder="Enter your birthdate"
                                   required><br><br>
                        </label>
                        <label for="email">Email<br>
                            <input class="input is-normal"
                                   type="email"
                                   name="email"
                                   placeholder="Enter your email - Example : test.test@example.com"
                                   required><br><br>
                        </label>
                        <label for="phone">Phone number<br>
                            <input class="input is-normal"
                                   type="tel"
                                   name="phone"
                                   maxlength="10"
                                   placeholder="Enter your phone number - Example : 0791234567"><br>
                        </label><br>
                        <p>Civility</p>
                        <div>
                            <input id="civility"
                                   type="radio"
                                   name="civility"
                                   value="1"
                                   checked>
                            <label class="radio"
                                   for="civility">Single</label>
                            <input id="civility"
                                   type="radio"
                                   name="civility"
                                   value="2">
                            <label class="radio"
                                   for="civility">Married</label>
                            <input id="civility"
                                   type="radio"
                                   name="civility"
                                   value="3">
                            <label class="radio"
                                   for="civility">Divorced</label>
                        </div>
                        <br>
                        <p>Gender</p>
                        <div>
                            <input id="sex"
                                   type="radio"
                                   name="sex"
                                   value="1"
                                   checked>
                            <label class="radio"
                                   for="sex">Male
                            </label>
                            <input id="sex"
                                   type="radio"
                                   name="sex"
                                   value="2">
                            <label class="radio"
                                   for="sex">Female
                            </label>
                            <input id="sex"
                                   type="radio"
                                   name="sex"
                                   value="3">
                            <label class="radio"
                                   for="sex">Other
                            </label>
                        </div>
                        <br>
                        <h3 class="title is-3">Address table</h3>
                        <label for="country">Country<br>
                            <input class="input is-normal"
                                   type="text"
                                   name="country"
                                   placeholder="Enter your country"
                                   required><br><br>
                        </label>
                        <label for="street">Street<br>
                            <input class="input is-normal"
                                   type="text"
                                   name="street"
                                   placeholder="Enter your street"
                                   required><br><br>
                        </label>
                        <label for="postal_code">Postal code<br>
                            <input class="input is-normal"
                                   type="number"
                                   min="100"
                                   max="999999"
                                   name="postal_code"
                                   placeholder="NPA"><br><br>
                        </label>
                        <label for="city">City<br>
                            <input class="input is-normal"
                                   type="text"
                                   name="city"
                                   placeholder="Enter your city"
                                   required><br><br>
                        </label>
                        <input class="button is-primary is-outlined is-light"
                               id="submit_id"
                               type="submit"
                               name="submit"
                               value="Submit"><br><br><br>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php

require_once './footer.php';