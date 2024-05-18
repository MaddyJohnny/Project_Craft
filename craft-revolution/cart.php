<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width = device-width, 
	initial-scale = 1, shrink-to-fit = no">
	<link rel="icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/stylesmall.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
	<title>Интернет-магазин "Строительная революция"</title>
</head>
<body class="body body_main">
	<!-- header -->
	<?php
        session_start();
        echo "<script>console.log('Session started!');</script>";
    ?>
    <?php include 'php/connectdb.php';
    ?>
	<?php 
		include('tpl/header.php')
	?>
	<!-- main -->
	<main>
		<?php
			include 'php/connectdb.php';
			session_start();

			if (!isset($_SESSION['cart'])) {
			    $_SESSION['cart'] = array();
			}

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    if (isset($_POST['remove'])) {
			        $id = $_POST['id'];
			        unset($_SESSION['cart'][$id]);
			    } elseif (isset($_POST['update'])) {
			        $id = $_POST['id'];
			        $quantity = $_POST['quantity'];
			        $_SESSION['cart'][$id] = $quantity;
			    }
			}
			echo "<div class='cart_table'>";
			echo "<table>";
			echo "<tr class='tr_cart'><th class='th_cart'>№</th><th class='th_cart'>Название</th><th class='th_cart'>Размер</th><th class='th_cart'>Цена</th><th class='th_cart'>Количество</th><th></th class='th_cart'></tr>";
			
			$total = 0;
			$row_number = 1;
			if(empty($_SESSION['cart'])) {
    		echo "<tr class='tr_cart'><td colspan='5' class='n_cart'>Здесь пока пусто...</td></tr>";
			}
			foreach ($_SESSION['cart'] as $id => $quantity) {
		    $result = mysqli_query($mysqli, "SELECT * FROM Product WHERE ID=$id");
		    if ($result === false) {
		        printf("Error: %s\n", mysqli_error($mysqli));
		        exit();
		    }
		    $row = mysqli_fetch_assoc($result);

			    echo "<tr class='tr_cart'>";
			    echo "<td class='td_cart'>" . $row_number . "</td>";
			    echo "<td class='td_cart'>" . $row['Name'] . "</td>";
			    echo "<td class='td_cart'>" . $row['Size'] . "</td>";
			    echo "<td class='td_cart'>" . $row['Price'] . " ₽/м3</td>";
				echo "<td class='td_cart'><form method='POST' id='updateForm$id'><input type='number' class='quantity' name='quantity' data-id='$id' value='$quantity' min='1' onchange='this.form.submit()'><input type='hidden' name='id' value='$id'><input type='hidden' name='update' value='Update'></form></td>";
			    echo "<td class='td_cart'><form method='POST'><input type='hidden' name='id' value='$id'><input type='submit' name='remove' value='Удалить' class='btn_rem'></form></td>";
			    echo "</tr>";

			    $total += $row['Price'] * $quantity;
			    $row_number++;
			}

			echo "</table>";
			echo "</div>";

			echo "<div class='result_cart'>";
			echo "<h2 class = 'h2_ut'>Общая сумма:" . $total . " ₽</h2>";

			if (isset($_SESSION['phone'])) {
		    if (empty($_SESSION['cart'])) {
		        echo "<p class='cart_a'>Корзина пуста</a>";
		    } else {
		        echo "<a href='checkout.php' class='cart_a'><button class='cart_but'>Оформить</button></a>";
		    }
			} else {
		    	echo "<a href='login.php' class='warn_unlog'>Войдите в систему, чтобы оформить заказ</a>";
			}
			echo "</div>";
		?>
	</main>
	<!-- footer -->
	<?php 
		include('tpl/footer.php')
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>