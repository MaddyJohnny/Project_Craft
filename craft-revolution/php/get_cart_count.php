<?php
include 'connectdb.php';
session_start();

// Возвращаем общее количество товаров в корзине
if (isset($_SESSION['cart'])) {
    echo array_sum($_SESSION['cart']);
} else {
    echo 0;
}
?>
