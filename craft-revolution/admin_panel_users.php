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
				<a href="admin_panel_application.php"><div class="mod_button bt_2">Заказы</div></a>
				<div class="mod_button bt_3 active_bt"><a>Пользователи</a></div>
			</div>
			<div class="mod">
			    <?php include 'php/connectdb.php' ?>
			    <table class="table">
			        <tr>
			            <th>ID</th>
			            <th>SurName</th>
			            <th>FirName</th>
			            <th>MidName</th>
			            <th>Phone</th>
			            <th>Email</th>
			            <th>Type</th>
			            <th colspan="2">Action</th>
			        </tr>

			        <?php
			        // Получение данных из базы данных
			        $sql = "SELECT ID, SurName, FirName, MidName, Phone, Email, Password, Type FROM User";
			        $result = $mysqli->query($sql);

			        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
			            $id_to_delete = $_POST['delete'];

			            // Удаление пользователя из базы данных
			            $sql = "DELETE FROM User WHERE ID = $id_to_delete";
			            if ($mysqli->query($sql) === TRUE) {
			                echo "Пользователь успешно удален";
			                echo '<script type="text/javascript">
						        window.location.href = window.location.href;
						    </script>';
			            } else {
			                echo '<script>window.alert("Ошибка при удалении пользователя: удалите существующие заявки данного пользователя")</script>';
			            } 
			        }

			        if ($result->num_rows > 0) {
			            // Вывод данных каждого пользователя
			            while($row = $result->fetch_assoc()) {
			                echo "<tr><td>" 
			                        . $row["ID"]. 
			                    "</td><td>" 
			                        . $row["SurName"]. 
			                    "</td><td>" 
			                        . $row["FirName"]. 
			                    "</td><td>" 
			                        . $row["MidName"]. 
			                    "</td><td>" 
			                        . $row["Phone"]. 
			                    "</td><td>" 
			                        . $row["Email"]. 
			                    "</td><td>" 
			                        . $row["Type"]. 
			                    "</td><td>
			                        <form method='post'>
			                            <input type='hidden' name='delete' value='" . $row["ID"]. "'>
			                            <input class='action_button' type='submit' value='Удалить'>
			                        </form>
			                    </td><td>
			                    <a href='edit_user.php?id=" . $row["ID"]. "'><button class='action_button' type='button'>Изменить</button></a>
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
	<!-- footer -->
	<?php 
		include('tpl/footer.php')
	?>
</body>
</html>