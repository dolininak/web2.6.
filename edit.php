<?php
if (isset($_GET['id'])) {
    // Получаем данные пользователя по ID
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM application WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch();

    // Отображаем форму для редактирования данных
    
    
    echo '<form action="update.php" method="post">';
    echo '<input type="hidden" name="id" value="' . $user['id'] . '">';
    echo 'Name: <input type="text" name="name" value="' . $user['name'] . '"><br>';
    echo 'Tel: <input type="text" name="tel" value="' . $user['tel'] . '"><br>';
    echo 'Email: <input type="text" name="email" value="' . $user['email'] . '"><br>';                
    echo 'Date:<input name="data"  type="date"   placeholder="Введите дату рождения" value="' . $user['data'] . '"> <br>';
    echo 'Gender:<br>';
    echo '<input name="pol" type="radio" value="female" ' . ($user['pol'] == 'female' ? 'checked' : '') . '> Женский<br>';
    echo '<input name="pol" type="radio" value="male" ' . ($user['pol'] == 'male' ? 'checked' : '') . '> Мужской<br>';

    echo 'Favorite Programming Languages:<br>';
    echo '<select multiple="multiple" name="languages[]">';
    $selectedLanguages = explode(',', $user['languages']);
    $languages = array("Pascal", "C", "C++", "JavaScript", "PHP", "Python", "Java", "Haskell", "Clojure", "Prolog", "Scala");
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