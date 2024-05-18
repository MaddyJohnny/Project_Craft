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
	<title>Личный кабинет. Заказы</title>
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
				<a href="user_panel.php"><div class="mod_button bt_1">Пользователь</div></a>
				<div class="mod_button bt_2 active_bt">Заказы</div>
			</div>
			<div class="mod">
				<table class="table">
			        <tr>
			            <th class="th_user">Номер</th>
			            <th class="th_user">Пользователь</th>
			            <th class="th_user">Статус</th>
			            <th class="th_user">Дата заказа</th>
			        </tr>
			    	<?php
						if ($mysqli) {
    						$result = $mysqli->query("SELECT ID FROM User WHERE Phone = '".$_SESSION['phone']."'");
    							if ($result) {
				        $row = $result->fetch_assoc();
				        $user_id = $row['ID'];
				         $result2 = $mysqli->query("SELECT Application.ID, User.SurName, Application_Status.Status, Application.Date 
            				FROM Application 
            				INNER JOIN User ON User.ID = Application.User_ID 
            				INNER JOIN Application_Status ON Application_Status.ID = Application.Status_ID
        					WHERE User.ID = '$user_id'");
				        if ($result2) {
				            while($row2 = $result2->fetch_assoc()) {
				            	echo "<tr class='td_user'><td class='td_user'>" 
			                        . $row2["ID"]. 
			                    "</td><td class='td_user'>" 
			                        . $row2["SurName"]. 
			                    "</td><td class='td_user'>" 
			                        . $row2["Status"]. 
			                    "</td><td class='td_user'>" 
			                        . $row2["Date"]. 
			                    "</td>";
				            }
				        }
				        else {
				            echo "Ошибка выполнения запроса: " . $mysqli->error;
						        }
						    }
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