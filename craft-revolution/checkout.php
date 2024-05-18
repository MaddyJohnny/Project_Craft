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
	<title>Оформление интернет-заказа</title>
</head>
	<?php
        session_start();
        echo "<script>console.log('Session started!');</script>";
    ?>
    <?php include 'php/connectdb.php';
    ?>
    <?php 
		include('tpl/header.php')
	?>
	
	<body class="body body_main">
		<?php
		if ($mysqli) {
		    // Check if the cart is empty
		    if (empty($_SESSION['cart'])) {
		    	echo "<div class='order'>";
		        echo "<p class = 'order_suc'>Заказ успешно сформирован! Номер вашего заказа - " . $application_id . ".</p>";
		        echo "<a href='index.php' class = 'order_suc_a'>На главную</a>";
		        echo "</div>";
		         echo "<script>document.body.offsetHeight</script>";
		    } else {
		        $result = $mysqli->query("SELECT * FROM User WHERE Phone = '".$_SESSION['phone']."'");
		        if ($result) {
		            $row = $result->fetch_assoc();
		            if ($_SERVER["REQUEST_METHOD"] == "POST") {
		                $cart = $_SESSION['cart'];
		                $query = "INSERT INTO Application (User_ID, Status_ID, Date) VALUES (?, ?, ?)";
		                $stmt = $mysqli->prepare($query);
		                $status_id = 1;
		                $stmt->bind_param("iis", $row['ID'], $status_id, date("Y-m-d"));
		                $stmt->execute();
		                
		                $application_id = $stmt->insert_id;
		                
		                foreach ($cart as $product_id => $count) {
		                    $query = "INSERT INTO Application_Product (Application_ID, Product_ID, Count) VALUES (?, ?, ?)";
		                    $stmt = $mysqli->prepare($query);
		                    $stmt->bind_param("iii", $application_id, $product_id, $count);
		                    $stmt->execute();
		                }
		                $stmt->close();
		                unset($_SESSION['cart']);
		                echo "<p class = 'order_suc'>Заказ успешно сформирован! Номер вашего заказа - " . $application_id . ".</p>";
		        		echo "<a href='index.php' class = 'order_suc_a'>На главную</a>";
		        		echo "<script>document.body.offsetHeight</script>";
		            } else {
		            	echo "<div class='f_form'>";
		                echo "<form action='' method='POST' class='form_checkout'>";
		                echo "<p class='head_cheakout'>Оформление заказа</p>";
		                echo "<p>Имя покупателя: " . $row['FirName'] . "</p>";
		                echo "<p>Фамилия покупателя: " . $row['SurName'] . "</p>";
		                echo "<p>Контактный телефон: " . $row['Phone'] . "</p>";
		                echo "<p>Адрес самовывоза: <select name='store_adr' size='1'> </p>";
		                echo "<option selected value='raduzhnoe'>г. Коломна, Песковское шоссе, 47Б</option>";
		                echo "<option value='ubileynoe' disabled>г. Коломна, ул. Юбилейная, 11</option>";
		                echo "<option value='skorole' disabled>г. Коломна, ул. Ленина, д. 65</option>";
		                echo "</select>";
		                echo "</br>";
		                echo "<input type='submit' name='submit' value='Оформить' class= 'cart_but'>";
		                echo "</form>";
		                echo "</div>";
		            }
		        } else {
		            echo "Ошибка выполнения запроса: " . $mysqli->error;
		        }
		    }
		} else {
		    echo "Подключение к базе данных не установлено.";
		}
		?>

	<?php 
		include('tpl/footer.php')
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>