<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/stylel.css">
	<link rel="stylesheet" type="text/css" href="css/adapt.css">
	<link rel="icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
	<title>Личный кабинет</title>
</head>
<body class="body prof_body">
	<!-- header -->
    <?php include 'php/connectdb.php';
    include 'tpl/header.php';
    session_start()
    ?>
	<!-- main -->
	<main>
		<div class="mod_block">
			<div class="mod_nav">
				<div class="mod_button bt_1 active_bt">Пользователь</div>
				<a href="user_panel_application.php"><div class="mod_button bt_2">Заказы</div></a>
			</div>
			<div class="mod user_panel">
				<div>
					<?php
						if ($mysqli) {
							$result = $mysqli->query("SELECT * FROM User WHERE Phone = '".$_SESSION['phone']."'");
							if ($result) {
		            		$row = $result->fetch_assoc();
		            		echo "<p class='user_info'>Имя: " . $row['FirName'] . "</p>";
		                	echo "<p class='user_info'>Фамилия: " . $row['SurName'] . "</p>";
		                	echo "<p class='user_info'>Отчество: " . $row['MidName'] . "</p>";
		                	echo "<p class='user_info'>Контактный телефон: " . $row['Phone'] . "</p>";
		                	echo "<p class='user_info'>Почта: " . $row['Email'] . "</p>";
		                	echo "<a href = 'php/destroysession.php'><button>Выйти</button></a>";
		                	if ($row['Type'] == 'admin') {
		                		echo "<a href = 'admin_panel_users.php'><button>Войти в панель администратора</button></a>";
		                	}
		                	} }
		                	else {
		    				echo "Подключение к базе данных не установлено.";
					}
					?>
				</div>
				<img src="img/logo2.svg" class="img_profile">
			</div>	
		</div>
	</main>
	<?php 
		include('tpl/footer.php')
	?>
</body>
</html>