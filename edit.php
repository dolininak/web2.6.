<?php
if (isset($_GET['id'])) {
    include ('conf3.php');
    $db = new PDO('mysql:host=localhost;dbname=u67432', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT u.id, u.name, u.tel, u.email, u.data, u.pol, u.bio, u.login, u.pass, GROUP_CONCAT(pl.languages) AS languages1
    FROM application u
    JOIN application_programming_language upl ON u.id = upl.application_id
    JOIN programming_language pl ON upl.programming_language_id = pl.id
    WHERE u.id = :id
    GROUP BY u.id");
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
    echo '<select multiple="multiple" class="form_input2';

echo '" name="languages[]">';

echo '<option disabled>Выберите ваш любимый язык программирования</option>';

$languages = array("100" => "Pascal", "101" => "C", "102" => "C++", "103" => "JavaScript", "104" => "PHP", "105" => "Python", "106" => "Java", "107" => "Haskel", "108" => "Clojure", "109" => "Prolog", "110" => "Scala");
$languagesArray = explode(',', $user['languages1']);

foreach ($languages as $key => $language) {
    echo '<option value="' . $key . '"';
    if (in_array($key, $languagesArray)) {
        echo ' selected';
    }
    echo '>' . $language . '</option>';
}

echo '</select><br>';

    echo '<textarea placeholder="Ваша биография" name="bio">' . $user['bio'] . '</textarea><br>';
    
                       
    echo '<input type="submit" value="Update">';
    echo '</form>';

}
?>