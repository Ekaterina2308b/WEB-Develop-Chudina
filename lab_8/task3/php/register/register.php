<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $login = htmlspecialchars(trim($_POST['login']));
    $password = htmlspecialchars(trim($_POST['password']));
    $birthdate = htmlspecialchars(trim($_POST['birthdate']));

    if (empty($fullname) || empty($login) || empty($password) || empty($birthdate)) {
        die("Все поля должны быть заполнены!");
    }


    $servername = "localhost";
    $username = "root";
    $dbpassword = "123";
    $dbname = "registration";

    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (fullname, login, password, birthdate) 
            VALUES ('$fullname', '$login', '$password', '$birthdate')";

    if ($conn->query($sql) === TRUE) {
        echo "Регистрация успешна!";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
