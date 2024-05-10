<?php
if (isset($_GET['id'])) {
    // Удаляем пользователя по ID
    $id = $_GET['id'];
    include ('conf3.php');
    $db = new PDO('mysql:host=localhost;dbname=u67432', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $stmt1 = $db->prepare("DELETE FROM application_programming_language WHERE application_id = :id");
    $stmt1->bindParam(':id', $id);
    $stmt1->execute();
    

    $stmt = $db->prepare("DELETE FROM application WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo 'User with ID ' . $id . ' has been deleted.';
}
