<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/styledub.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title>Создание товаров</title>
</head>
<body class="body edit_product_body">
    <?php include 'php/connectdb.php' ?>
    <form class="create_form" action="" method="post">
        <input type="text" name="name" placeholder="Название" required>
        <input type="text" name="photo" placeholder="Фото" required>
        <input type="text" name="size" placeholder="Размеры" required>
        <textarea name="description" placeholder="Описание" required></textarea>
        <input type="number" name="price" placeholder="Цена" required>
        <button type="submit">Создать</button>
    </form>
    <a href="admin_panel_products.php"><button>Назад</button></a>
    <?php
    // Обработка отправки формы
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $photo = $_POST['photo'];
        $size = $_POST['size'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        // Здесь вы можете добавить код для отправки этих данных в вашу базу данных

        $sql = "INSERT INTO Product (Name, Photo, Size, Description, Price) VALUES ('$name', '$photo', '$size', '$description', '$price')";
        if (mysqli_query($mysqli, $sql)) {
            echo "Товар добавлен";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
        }
    }
    exit();
    ?>
</body>
</html>
