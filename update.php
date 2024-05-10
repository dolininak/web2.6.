<?php


      
      
    
       
         


      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include ('conf3.php');
  $db = new PDO('mysql:host=localhost;dbname=u67432', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    try {
        $stmt = $db->prepare("UPDATE application a INNER JOIN application_programming_language b 
        ON a.id = b.application_id INNER JOIN programming_language  c
  ON b.programming_language_id = c.id SET name = ?, tel = ?, email = ?, data = ?, pol = ?, bio = ?,  WHERE id=?");
          $stmt->execute([
              $_POST['name'],
              $_POST['tel'],
              $_POST['email'],
              $_POST['data'],
              $_POST['pol'],
              $_POST['bio'],
              $_POST['id']
            
          ]);
    $id=$_POST['id'];
          
          $stmt = $db->prepare('DELETE FROM application_programming_language WHERE application_id = $id');
          foreach ($_POST['languages'] as $language) {
            $stmt = $db->prepare("INSERT INTO programming_language (languages) VALUES (?)");
            $stmt->execute([$language]);
      
            $programming_language_id = $db->lastInsertId();
      
            $stmt = $db->prepare("INSERT INTO application_programming_language (application_id, programming_language_id) VALUES (?, ?)");
            $stmt->execute([$id, $programming_language_id]);
          }
          }
      catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
      }
      header('Location: admin.php'); 
    }