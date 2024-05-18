<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/stylel.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
	<title></title>
</head>
<body class="body prof_body">
	<?php include 'php/connectdb.php';
    include 'tpl/header.php';
    session_start()
    ?>
	<!-- main -->
	<main>
		<div class="mod_block">
			<div class="mod_nav">
				<a href="admin_panel_products.php"><div class="mod_button bt_1">Товары</div></a>
				<div class="mod_button bt_2 active_bt">Заказы</div>
				<a href="admin_panel_users.php"><div class="mod_button bt_3">Пользователи</div></a>
			</div>
			<div class="mod">
			    <?php include 'php/connectdb.php' ?>
			    <table class="table">
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Status</th>
        <th>Date</th>
        <th>Products</th>
        <th colspan="2">Action</th>
    </tr>

    <?php
    // Получение данных из базы данных
    $sql = "SELECT Application.ID, User.MidName, Application_Status.Status, Application.Date "
        . "FROM Application "
        . "INNER JOIN User ON Application.User_ID = User.ID "
        . "INNER JOIN Application_Status ON Application.Status_ID = Application_Status.ID;";

    $result = $mysqli->query($sql);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
        $id_to_delete = $_POST['delete'];

        // Удаление пользователя из базы данных
        $sql = "DELETE FROM Application WHERE ID = $id_to_delete";
        if ($mysqli->query($sql) === TRUE) {
            echo "Запись успешно удалена";
            echo '<script type="text/javascript">
                window.location.href = window.location.href;
            </script>';
        } else {
            echo "Ошибка при удалении записи: " . $mysqli->error;
        }

        $mysqli->close();
    }

    if ($result->num_rows > 0) {
        // Вывод данных каждого пользователя
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" 
                    . $row["ID"]. 
                "</td><td>" 
                    . $row["MidName"]. 
                "</td><td>" 
                    . $row["Status"]. 
                "</td><td>" 
                    . $row["Date"]. 
                "</td><td>";

            // Получение данных о продуктах
            $product_sql = "SELECT Product.ID, Product.Name, Product.Photo, Product.Size, Product.Description, Product.Price "
                . "FROM Application_Product "
                . "INNER JOIN Product ON Application_Product.Product_ID = Product.ID "
                . "WHERE Application_Product.Application_ID = " . $row["ID"];

            $product_result = $mysqli->query($product_sql);
            if ($product_result->num_rows > 0) {
                echo "<select class='selector'>";
                while($product_row = $product_result->fetch_assoc()) {
                    echo "<option title='Name: " . $product_row["Name"] . ", Size: " . $product_row["Size"] . ", Description: " . $product_row["Description"] . ", Price: " . $product_row["Price"] . "'>" . $product_row["Name"] . "</option>";
                }
                echo "</select>";
            } else {
                echo "No products";
            }

            echo "</td><td>
                <form method='post'>
                    <input type='hidden' name='delete' value='" . $row["ID"]. "'>
                    <input class='action_button' type='submit' value='Удалить'>
                </form>
            </td><td>
            <a href='edit_application.php?id=" . $row["ID"]. "'><button class='action_button' type='button'>Изменить</button></a>
            </td></td>";
        }
    } else {
        echo "0 results";
    }
    ?>
</table>


			</div>
		</div>
	</main>
	<?php 
		include('tpl/footer.php')
	?>
</body>
</html>