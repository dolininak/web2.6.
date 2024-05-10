<?php
if (isset($_GET['id'])) {
    include ('conf3.php');
    $db = new PDO('mysql:host=localhost;dbname=u67432', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM  application a INNER JOIN application_programming_language b 
    ON a.id = b.application_id INNER JOIN programming_language c
ON b.programming_language_id = c.id WHERE a.id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch();
     
    echo '<form action="update.php" method="post">';
    echo '<input type="hidden" name="id" value="' . $user['id'] . '">';
    echo 'Name: <input type="text" name="name" value="' . $user['name'] . '"><br>';
    echo 'Tel: <input type="text" name="tel" value="' . $user['tel'] . '"><br>';
    echo 'Email: <input type="text" name="email" value="' . $user['email'] . '"><br>';                
    echo 'Date:<input name="data"  type="date"   placeholder="Введите дату рождения" value="' . $user['data'] . '"> <br>';
    echo 'Gender:<br>';
    echo '<input name="pol" type="radio" value="female" ' . ($user['pol'] == 'Female' ? "checked" : '') . '> Женский<br>';
    echo '<input name="pol" type="radio" value="male" ' . ($user['pol'] == 'Male' ? "checked" : '') . '> Мужской<br>';

    echo 'Favorite Programming Languages:<br>';
    echo '<select multiple="multiple" name="languages[]">';
    $selectedLanguages = explode(',', $user['languages']);
    $languages = array("100", "101", "102", "103", "104", "105", "106", "107", "108", "109", "110");
    foreach ($languages as $language) {
        echo '<option value="' . $language . '" ' . (in_array($language, $selectedLanguages) ? 'selected' : '') . '>' . $language . '</option>';
    }
    echo '</select><br>';

    echo '<textarea placeholder="Ваша биография" name="bio">' . $user['bio'] . '</textarea><br>';

    echo '<input type="checkbox" name="agreement" value="on" ' . ($user['agreement'] == 'on' ? 'checked' : '') . '> Согласен с условиями<br>';              
    
                       
    echo '<input type="submit" value="Update">';
    echo '</form>';

}
?>