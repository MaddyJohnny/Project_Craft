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
	<title>Изменить заказ</title>
</head>
<body class="body edit_application_body">
    <?php include 'php/connectdb.php' ?>
    <?php
    $id = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM Application WHERE ID = '$id'");
    $row = mysqli_fetch_assoc($result);
    
    // Получить все записи из таблицы User и Application_Status
    $users = mysqli_query($mysqli, "SELECT * FROM User");
    $statuses = mysqli_query($mysqli, "SELECT * FROM Application_Status");
    ?>
    
    <form class="edit_form" action="" method="post">
        <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
        
        <!-- Выпадающий список для User_ID -->
        <select name="user_id" required>
            <?php while($user = mysqli_fetch_assoc($users)): ?>
                <option value="<?php echo $user['ID']; ?>" <?php if($user['ID'] == $row['User_ID']) echo 'selected'; ?>>
                    <?php echo $user['MidName']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <!-- Выпадающий список для Status_ID -->
        <select name="status_id" required>
            <?php while($status = mysqli_fetch_assoc($statuses)): ?>
                <option value="<?php echo $status['ID']; ?>" <?php if($status['ID'] == $row['Status_ID']) echo 'selected'; ?>>
                    <?php echo $status['Status']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <input type="date" name="date" value="<?php echo $row['Date']; ?>" placeholder="Дата" required>
        <button type="submit">Обновить</button>
    </form>
    <a href="admin_panel_application.php"><button>Назад</button></a>
    <?php
    // Обработка отправки формы
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $user_id = $_POST['user_id'];
        $status_id = $_POST['status_id'];
        $date = $_POST['date'];

        // Здесь вы можете добавить код для отправки этих данных в вашу базу данных

        $sql = "UPDATE Application SET User_ID = '$user_id', Status_ID = '$status_id', Date = '$date' WHERE ID = '$id'";
        if (mysqli_query($mysqli, $sql)) {
            echo "Данные заказа обновлены";
            echo '<script type="text/javascript">
                window.location.href = window.location.href;
            </script>';
        } else {
            echo "Ошибка: " . $sql . "<br>" . mysqli_error($mysqli);
        }
    }

    // Получение данных о товарах в заказе
    $products = mysqli_query($mysqli, "SELECT Application_Product.ID, Application_Product.Application_ID, Application_Product.Product_ID, Application_Product.Count, Product.Name, Product.Photo, Product.Size, Product.Description, Product.Price FROM Application_Product INNER JOIN Product ON Application_Product.Product_ID = Product.ID WHERE Application_Product.Application_ID = '$id'");

    echo "<table class='table'>";
    echo "<tr><th>ID</th><th>Product</th><th>Count</th><th>Action</th></tr>";
    while($product = mysqli_fetch_assoc($products)) {
        echo "<tr>";
        echo "<td>" . $product['ID'] . "</td>";
        echo "<td><span class='product_info'>" . $product['Name'] . "<div class='product_details' style='display:none;'><img src='" . $product['Photo'] . "' alt='Фото товара'><p>" . $product['Description'] . "</p><p>Размер: " . $product['Size'] . "</p><p>Цена: " . $product['Price'] . " руб.</p></div></span></td>";
        echo "<td>" . $product['Count'] . "</td>";
        echo "<td><form class='del_button' method='post'><input type='hidden' name='delete_product' value='" . $product['ID'] . "'><input type='submit' value='Удалить'></form></td>";
        echo "</tr>";
    }
    echo "</table>";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product'])) {
        $product_id_to_delete = $_POST['delete_product'];

        // Удаление товара из заказа
        $sql = "DELETE FROM Application_Product WHERE ID = $product_id_to_delete";
        if (mysqli_query($mysqli, $sql)) {
            echo "Товар удален из заказа";
        } else {
            echo "Ошибка при удалении товара: " . mysqli_error($mysqli);
        }
    }
    ?>
</body>

</html>
