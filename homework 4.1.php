<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
header("Content-Type: text/html; charset=utf-8");
$pdo = new PDO("mysql:host=localhost;dbname=global","root", "root", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
$pdo->exec('SET NAMES utf8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $_POST['isbn'];
    $name = $_POST['name'];
    $author = $_POST['author'];
    $sql = "SELECT * FROM books WHERE ((name LIKE :name) AND (isbn LIKE :isbn) AND (author LIKE :author))";
    $statement = $pdo->prepare($sql);
    $statement->execute(["name"=>"%{$name}%","isbn"=>"%{$isbn}%","author"=>"%{$author}%"]);
}else{
    $sql = "SELECT * FROM books";
    $statement = $pdo->prepare($sql);
    $statement->execute();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.22/css/uikit.min.css" />
</head>
<body>


<div class="uk-container uk-container-small22 uk-margin-large-top">
    <h1>Библиотека успешного человека</h1>
    <form method="POST">
        <div class="uk-grid-small" uk-grid>
            <div class="uk-width-auto"><input class="uk-input" type="text" name="isbn" placeholder="ISBN" value="<?php if (!empty($_POST)){echo $_POST['isbn'];} ?>"></div>
            <div class="uk-width-auto"><input class="uk-input" type="text" name="name" placeholder="Название книги" value="<?php if (!empty($_POST)){echo $_POST['name'];} ?>"></div>
            <div class="uk-width-auto"><input class="uk-input" type="text" name="author" placeholder="Автор книги" value="<?php if (!empty($_POST)){echo $_POST['author'];} ?>"></div>
            <div class="uk-width-auto"><button type="submit" class="uk-button uk-button-primary">Поиск</button></div>
        </div>
    </form>
    <table class="uk-table uk-table-striped uk-table-small uk-table-hover">
        <thead>
        <tr>
            <th class="uk-table-expand">Название</th>
            <th class="uk-table-shrink">Автор</th>
            <th class="uk-table-shrink uk-text-nowrap">Год выпуска</th>
            <th class="uk-table-shrink">Жанр</th>
            <th class="uk-table-shrink">ISBN</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($statement as $row) : ?>
            <tr>
                <td><?=$row['name']?></td>
                <td class="uk-text-nowrap"><?=$row['author']?></td>
                <td class="uk-text-nowrap"><?=$row['year']?></td>
                <td><?=$row['genre']?></td>
                <td class="uk-text-nowrap"><?=$row['isbn']?></td>
            </tr>
        <?php endforeach;?>

        </tbody>

    </table>
</div>



<script src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.22/js/uikit.min.js"
        integrity="sha256-ZfxNpEyIHFt0qMdwt/+cIhDnyZCykGkVd1uNz6TU/jY=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.22/js/uikit-icons.min.js"
        integrity="sha256-BtKiVFqAoEVJYnSoG1tt98EQ11R3QjUCB9AtrW+66wo=" crossorigin="anonymous"></script>
</body>
</html>