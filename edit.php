<?php
if (isset($_GET['id'])) {
    include ('conf3.php');
    $db = new PDO('mysql:host=localhost;dbname=u67432', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $id = $_GET['id'];

    $stmt = $db->prepare("SELECT login, pass FROM application WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $login = $result['login'];
    $password = $result['pass'];

    
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
?>