<?php
include 'connectdb.php';
session_start();

// Проверяем, установлено ли подключение к базе данных
if ($mysqli) {
    $product_id = $_POST['id'];

    // Проверяем, есть ли уже этот товар в корзине
    if (isset($_SESSION['cart'][$product_id])) {

    } else {
        // Если нет, добавляем товар в корзину с количеством 1
        $_SESSION['cart'][$product_id] = 1;
    }

    // Возвращаем общее количество товаров в корзине
    echo array_sum($_SESSION['cart']);
} else {
    echo "Подключение к базе данных не установлено.";
}
?>
