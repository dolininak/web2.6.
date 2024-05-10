<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.
include ('conf3.php');
$db = new PDO('mysql:host=localhost;dbname=u67432', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
// Запрос к таблице Admins
$stmt = $db->prepare("SELECT login, password FROM Admins WHERE login = 'admin'");
$stmt->execute();
$row = $stmt->fetch();

$login = $row['login'];
$hashedPassword = $row['password'];
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != $login ||
    md5($_SERVER['PHP_AUTH_PW']) != $hashedPassword) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}

print('Вы успешно авторизовались и видите защищенные паролем данные.');
include ('conf3.php');
    $db = new PDO('mysql:host=localhost;dbname=u67432', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
try {
$stmt = $db->prepare("
SELECT u.id, u.name, u.tel, u.email, u.data, u.pol, u.bio, u.login, u.pass, GROUP_CONCAT(pl.languages) AS languages1
FROM application u
JOIN application_programming_language upl ON u.id = upl.application_id
JOIN programming_language pl ON upl.programming_language_id = pl.id
GROUP BY u.id
");
$stmt->execute();
$users = $stmt->fetchAll();

// Отображение данных в виде таблицы
echo '<table>';
echo '<tr><th>ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Date</th><th>Gender</th><th>Biografy</th><th>Login</th><th>Password</th><th>Languages</th><th>Actions</th></tr>';
foreach ($users as $user) {
    echo '<tr>';
    echo '<td>' . $user['id'] . '</td>';
    echo '<td>' . $user['name'] . '</td>';
    echo '<td>' . $user['tel'] . '</td>';
    echo '<td>' . $user['email'] . '</td>';
    echo '<td>' . $user['data'] . '</td>';
    echo '<td>' . $user['pol'] . '</td>';
    echo '<td>' . $user['bio'] . '</td>';
    echo '<td>' . $user['login'] . '</td>';
    echo '<td>' . $user['pass'] . '</td>';
    echo '<td>' . $user['languages1'] . '</td>';
    echo '<td><a href="edit.php?id=' . $user['id'] . '">Edit</a> | <a href="delete.php?id=' . $user['id'] . '">Delete</a></td>';
    echo '</tr>';
}
echo '</table>';}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}


include ('conf3.php');
$db = new PDO('mysql:host=localhost;dbname=u67432', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

  $stmt = $db->prepare("SELECT pl.languages AS language, COUNT(*) AS total_lovers_sum
  FROM application ap
  INNER JOIN application_programming_language apl ON ap.id = apl.application_id
  INNER JOIN programming_language pl ON apl.programming_language_id = pl.id
  GROUP BY pl.languages;");


$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $row) {
    echo $row['language'] . ' has ' . $row['total_lovers_sum'] . ' lovers.' . PHP_EOL;
}



// *********
// Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
// Реализовать просмотр и удаление всех данных.
// *********
