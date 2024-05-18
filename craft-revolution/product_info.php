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
	<link rel="stylesheet" type="text/css" href="css/adapt.css">
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
	<main>
		<!-- products cards -->
		<div class="products">
			<?php
			    // Проверяем, установлено ли подключение к базе данных
			    if ($mysqli) {
			        $product_id = $_GET['id'];
			        $result = $mysqli->query("SELECT * FROM Product WHERE ID = '$product_id'");
			        if ($result) {
			            while ($myrow = $result->fetch_assoc()) {
			                echo "<div class='product_card_info'>";
			                echo "<div class='product_img_info'><img src='".htmlspecialchars($myrow['Photo'])."' class='product_image_info'></div>";
			                echo "<div class='prod_card_t'>";
			                echo "<h2 class='product_name_info'>".htmlspecialchars($myrow['Name'])."</h2>";
			                echo "<p class='product_size_info'>Размер: ".htmlspecialchars($myrow['Size'])."</p>";
			                echo "<p class='product_description_info'>".htmlspecialchars($myrow['Description'])."</p>";
			                echo "<p class='product_price_info'>Цена: ".htmlspecialchars($myrow['Price'])." ₽/м3</p>";
			                echo "<button class='product_button' onclick='addToCart($product_id); location.reload();'>";
							echo "<p>Добавить</p>";
							echo "<img src='../img/cartb.svg' class='img-head-b_info'><img src='img/cartbl.svg' class='img-head_info'>";
							echo "</button>";
			                echo "</div>";
			                echo "</div>";
			            }
			        } else {
			            echo "Ошибка выполнения запроса: " . $mysqli->error;
			        }
			    } else {
			        echo "Подключение к базе данных не установлено.";
			    }
			?>

		</div>
		<p class="h1_up">Также ищут</p>
		<div class="products">
			<?php
			    // Проверяем, установлено ли подключение к базе данных
			    if ($mysqli) {
			        $result2 = $mysqli->query("SELECT * FROM Product WHERE ID != '$product_id' ORDER BY RAND() LIMIT 3");
			        if ($result2) {
			            while ($myrow2 = $result2->fetch_assoc()) {
			                $current_product_id = $myrow2['ID'];
			                echo "<div class='product_card'>";
			                echo "<div class='product_img'><a href='product_info.php?id=$current_product_id' class='product_img_link'><img src='".htmlspecialchars($myrow2['Photo'])."' class='product_image'></a></div>";
			                echo "<div class='product_card_body'>";
			                echo "<div class='product_name'>".htmlspecialchars($myrow2['Name'])."</div>";
			                echo "<div class='product_price'>".htmlspecialchars($myrow2['Price'])." ₽/м3</div>";
			              	echo "<button class='product_button' onclick='addToCart($current_product_id); location.reload();'>";
							echo "<p>Добавить</p>";
							echo "<img src='../img/cartb.svg' class='img-head-b_info'><img src='img/cartbl.svg' class='img-head_info'>";
							echo "</button>";
			                echo "</div>";
			                echo "</div>";
			            }
			        } else {
			            echo "Ошибка выполнения запроса: " . $mysqli->error;
			        }
			        $mysqli->close();
			    } else {
			        echo "Подключение к базе данных не установлено.";
			    }
			    echo "
				<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
				<script>
				function addToCart(product_id) {
				    $.ajax({
				        url: 'php/add_to_cart.php',
				        type: 'POST',
				        data: { id: product_id },
				        success: function(result) {
				            // Обновляем счетчик корзины
				            $('#cart_count').html(result);

				            // Обновляем счетчик количества товара
				            var product_count = $('#product_count_' + product_id);
				            var current_count = parseInt(product_count.html()) || 0;
				            product_count.html(current_count + 1);
				        }
				    });
				}

				// Загружаем счетчик корзины при загрузке страницы
				$(document).ready(function() {
				    $.ajax({
				        url: 'php/get_cart_count.php',
				        success: function(result) {
				            $('#cart_count').html(result);
				        }
				    });
				});
				</script>
				<script>
				function addToCart(current_product_id) {
				    $.ajax({
				        url: 'php/add_to_cart.php',
				        type: 'POST',
				        data: { id: current_product_id },
				        success: function(result) {
				            // Обновляем счетчик корзины
				            $('#cart_count').html(result);

				            // Обновляем счетчик количества товара
				            var product_count = $('#product_count_' + current_product_id);
				            var current_count = parseInt(product_count.html()) || 0;
				            product_count.html(current_count + 1);
				        }
				    });
				}

				// Загружаем счетчик корзины при загрузке страницы
				$(document).ready(function() {
				    $.ajax({
				        url: 'php/get_cart_count.php',
				        success: function(result) {
				            $('#cart_count').html(result);
				        }
				    });
				});
				</script>
				";
			?>
		</div>
	</main>
		<!-- footer -->
	<?php 
		include('tpl/footer.php')
	?>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>