<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');
// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
$session_started = false;

if ( session_start() && $_COOKIE[session_name()]) {
  $session_started = true;
  if (!empty($_SESSION['login'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
      session_destroy();
    // Если есть логин в сессии, то пользователь уже авторизован.
    // TODO: Сделать выход (окончание сессии вызовом session_destroy()
    //при нажатии на кнопку Выход).
    // Делаем перенаправление на форму.
    header('Location: ./');
    exit();
  
}
}}


// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>

<form action="login.php" method="POST">
  <input type="text" name="login" />
  <input type="password" name="password" />
  <input type="submit" value="Войти" />
  <input type="submit" name="logout" value="Выход" />
</form>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках.
 // Проверка логина и пароля в базе данных
 $login = $_POST['login'];
 $password = $_POST['password'];

 include ('conf3.php');
 $db = new PDO('mysql:host=localhost;dbname=u67432', $user, $pass,
   [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
 $stmt = $db->prepare("SELECT * FROM application WHERE login = :login AND pass = :password");
 $stmt->execute(['login' => $login, 'password' => $password]);
 $user = $stmt->fetch();

 if (!$user) {
     // Вывод сообщения об ошибке
     echo "Неверный логин или пароль";
 } else {
     if (!$session_started) { 
         session_start(); 
     } 
     // Если все ок, то авторизуем пользователя. 
     
     $_SESSION['login'] = $login; 
     $_SESSION['password'] = $password;
     // Записываем ID пользователя. 
     $_SESSION['uid'] = $user['id']; 

     // Делаем перенаправление. 
     header('Location: ./'); 
 }
}
//   if (!$session_started) {
//     session_start();
//   }
//   // Если все ок, то авторизуем пользователя.
//   $_SESSION['login'] = $_POST['login'];
//   // Записываем ID пользователя.
//   $_SESSION['uid'] = 123;

//   // Делаем перенаправление.
//   header('Location: ./');
// }
