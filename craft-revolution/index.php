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
	<?php include 'tpl/header.php';
    ?>
	<?php
        session_start();
        echo "<script>console.log('Session started!');</script>";
    ?>
    <?php include 'php/connectdb.php';
    ?>

	<!-- main -->
	<main>
		<div class="slider">
			<div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active img1" data-bs-interval="4000">
						<img src="img/ad1.png" class="d-block ia" alt="Lenin">
					</div>
					<div class="carousel-item img2" data-bs-interval="4000">
						<img src="img/ad2.png" class="d-block ia" alt="Stalin">
					</div>
				</div>
				<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
				</button>
			</div>
		</div>

		<!-- products cards -->
		<div class="products">

		<?php session_start();
		
		// Проверяем, установлено ли подключение к базе данных
		if ($mysqli) {
		    $result = $mysqli->query("SELECT * FROM Product");
		    if ($result) {
		        while ($myrow = $result->fetch_assoc()) {
		            $product_id = $myrow['ID'];
		            echo "<div class='product_card'>";
		            echo "<div class='product_img'><a href='product_info.php?id=$product_id' class='product_img_link'><img src='".htmlspecialchars($myrow['Photo'])."' class='product_image'></a></div>";
		            echo "<div class='product_card_body'>";
		            echo "<div class='product_name'>".htmlspecialchars($myrow['Name'])."</div>";
		            echo "<div class='product_price'>".htmlspecialchars($myrow['Price'])." ₽/м3</div>";
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
		";
		?>
		</div>

		<!-- location -->
		<div class="location">
			<h1>Наши контакты</h1>
			<div>
				<iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A7945d015446d8f0b870df108b15a98bdc3633daef7fad401348e214731a815bb&amp;source=constructor" width="750" height="500" frameborder="0"></iframe>
				<div>
					<p class="location_text">Телефон менеджера: +7 (495) 148-88-88</p>
					<p class="location_text">Телефон выдачи: +7 (985) 770-71-78 </p>
					<p class="location_text">Адрес: МО г. Коломна, Песковское шоссе, 47Б</p>
				</div>
			</div>
		</div>

		<!-- about us -->
		<div class="about_us">
			<h1>О нас</h1>
			<p>Добро пожаловать на сайт “Строительная революция” - вашего надежного поставщика пиломатериалов.</p>
			<br>
			<p>Мы - команда профессионалов, которая ценит качество и стремится к инновациям в области строительства. Наша миссия - предоставлять высококачественные пиломатериалы для всех видов строительных проектов.</p>
			<br>
			<p>“Строительная революция” начала свою работу более десяти лет назад с маленького склада в городе. С тех пор мы значительно улучшились и теперь обслуживаем клиентов с максимальным качеством. Мы гордимся тем, что предлагаем широкий ассортимент продукции, включая древесину различных пород, панели, доски и многое другое.</p>
			<br>
			<p>Мы уверены, что качество начинается с материалов. Поэтому мы тщательно отбираем поставщиков и проверяем каждую партию продукции. Наша цель - удовлетворить потребности самых требовательных клиентов.</p>
			<br>
			<p>Спасибо, что выбрали “Строительную революцию”. Мы рады быть частью ваших строительных проектов!</p>
		</div>


	</main>
	<!-- footer -->
	<?php include 'tpl/footer.php';
    ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>