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
				<div class="mod_button bt_1 active_bt"><a>Товары</a></div>
				<a href="admin_panel_application.php"><div class="mod_button bt_2">Заказы</div></a>
				<a href="admin_panel_users.php"><div class="mod_button bt_3">Пользователи</div></a>
			</div>
			<div class="mod">			
			    <table class="table">
			        <tr>
			            <th>ID</th>
			            <th>Name</th>
			            <th>Size</th>
			            <th>Description</th>
			            <th>Price</th>
			            <th colspan="2">Action</th>
			        </tr>

			        <?php
			        // Получение данных из базы данных
			        $sql = "SELECT ID, Name, Size, Description, Price FROM Product";
			        $result = $mysqli->query($sql);

			        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
					    $id_to_delete = $_POST['delete'];

					    // Удаление товара из базы данных
					    $sql = "DELETE FROM Product WHERE ID = $id_to_delete";
					    if ($mysqli->query($sql) === TRUE) {
					        echo "Товар успешно удален";
					        header('Location: ' . $_SERVER['REQUEST_URI']);
					    } else {
					        echo "Ошибка при удалении товара: " . $mysqli->error;
					    }

					    $mysqli->close();
					}

			        if ($result->num_rows > 0) {
			            // Вывод данных каждого товара
			            while($row = $result->fetch_assoc()) {
			                echo "<tr><td>" 
								. $row["ID"]. 
							"</td><td>" 
								. $row["Name"]. 
							"</td><td>" 
								. $row["Size"]. 
							"</td><td>" 
								. $row["Description"]. 
							"</td><td>" 
								. $row["Price"]. 
							"</td><td>
								<form method='post'>
								    <input type='hidden' name='delete' value='" . $row["ID"]. "'>
								    <input class='action_button' type='submit' value='Удалить'>
								</form>
							</td><td>
								<a href='edit_product.php?id=" . $row["ID"]. "'><button class='action_button' type='button'>Изменить</button></a>
							</td></tr>";

			            }
			        } else {
			            echo "0 results";
			        }
			        ?>
			    </table>
    			<a href="create_product.php"><button class="add_product">Добавить товар</button></a>		
			</div>	
		</div>
	</main>
	<?php include 'tpl/footer.php'?>
</body>
</html>