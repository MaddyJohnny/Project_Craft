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
	<title>Изменен</title>
</head>
<body class="body edit_product_body">
    <?php include 'php/connectdb.php' ?>
    <?php
    $id = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM Product WHERE ID = '$id'");
    $row = mysqli_fetch_assoc($result);
    ?>
    
    <form class="edit_form" action="" method="post">
        <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
        <input type="text" name="name" value="<?php echo $row['Name']; ?>" placeholder="Название" required>
        <input type="text" name="photo" value="<?php echo $row['Photo']; ?>" placeholder="Фото" required>
        <input type="text" name="size" value="<?php echo $row['Size']; ?>" placeholder="Размер" required>
        <textarea name="description" placeholder="Описание" required><?php echo $row['Description']; ?></textarea>
        <input type="number" name="price" value="<?php echo $row['Price']; ?>" placeholder="Цена" required>
        <button type="submit">Обновить</button>
    </form>
    <a href="admin_panel_products.php"><button>Назад</button></a>
    <?php
    // Обработка отправки формы
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $photo = $_POST['photo'];
        $size = $_POST['size'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        // Здесь вы можете добавить код для отправки этих данных в вашу базу данных

        $sql = "UPDATE Product SET Name = '$name', Photo = '$photo', Size = '$size', Description = '$description', Price = '$price' WHERE ID = '$id'";
        if (mysqli_query($mysqli, $sql)) {
            echo "Данные обновлены";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
        }
    }
    exit();
    ?>
</body>
</html>