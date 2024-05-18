<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/styledub.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
	<title>Изменить пользователя</title>
</head>
<body class="body edit_user_body">
    <?php include 'php/connectdb.php' ?>
    <?php
    $id = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM User WHERE ID = '$id'");
    $row = mysqli_fetch_assoc($result);
    ?>
    
    <form class="edit_form" action="" method="post">
        <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
        <input type="text" name="surname" value="<?php echo $row['SurName']; ?>" placeholder="Фамилия" required>
        <input type="text" name="firstname" value="<?php echo $row['FirName']; ?>" placeholder="Имя" required>
        <input type="text" name="midname" value="<?php echo $row['MidName']; ?>" placeholder="Отчество" required>
        <input type="text" name="phone" value="<?php echo $row['Phone']; ?>" placeholder="Телефон" required>
        <input type="email" name="email" value="<?php echo $row['Email']; ?>" placeholder="Email" required>
        <input type="password" name="password" value="<?php echo $row['Password']; ?>" placeholder="Пароль" required>
        <input type="text" name="type" value="<?php echo $row['Type']; ?>" placeholder="Тип пользователя" required>
        <button type="submit">Обновить</button>
    </form>
    <a href="admin_panel_users.php"><button>Назад</button></a>
    <?php
    // Обработка отправки формы
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $surname = $_POST['surname'];
        $firstname = $_POST['firstname'];
        $midname = $_POST['midname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $type = $_POST['type'];

        // Здесь вы можете добавить код для отправки этих данных в вашу базу данных

        $sql = "UPDATE User SET SurName = '$surname', FirName = '$firstname', MidName = '$midname', Phone = '$phone', Email = '$email', Password = '$password', Type = '$type' WHERE ID = '$id'";
        if (mysqli_query($mysqli, $sql)) {
            echo "Данные пользователя обновлены";
        } else {
            echo "Ошибка: " . $sql . "<br>" . mysqli_error($mysqli);
        }
    }
    exit();
    ?>
</body>
</html>
