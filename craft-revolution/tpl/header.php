<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/styleheader.css">
</head>
<body>
	<?php
        session_start();
        echo "<script>console.log('Session started!');</script>";
    ?>
    <?php include 'php/connectdb.php';
    ?>
	<div class="header">
		<a href="index.php" class="nav_link">
		<div class="header_logo">
			<img src="../img/logo2.svg" class="logo">
			<p class="logo_text">Строительная<br>революция</p>
		</div>
		</a>
		<div class="nav_menu">
			<div class="nav_menu_div nmd_cart">
				<img src="../img/cart.svg" class="img_cart">
				<a class="nav_link" href="cart.php">Корзина</a>
				<?php include 'php/get_cart_count.php';?>
			</div>
			<div class="nav_menu_div nmd_user">
				<img src="../img/user.svg" class="img_user">
				<?php 
				if (isset($_SESSION['phone']))
				{
					echo "<a class='nav_link' href='user_panel.php'>Профиль</a>";
				}
				else{
					echo "<a class='nav_link' href='login.php'>Войти</a>";
				}
				?>
			</div>
		</div>
	</div>
</body>
</html>