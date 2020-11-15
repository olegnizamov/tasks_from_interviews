<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Sale;
use Bitrix\Main\Loader;
?>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Oleg Nizamov">
    <title>Тестовое задание – WEB разработчик Тех поддержки</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="script.js"></script>
</head>
<body>

<div class="container">
    <table class="table" id="basket">
        <thead>
        <tr>
            <th scope="col">Название товара</th>
            <th scope="col">Цена за 1 товар</th>
            <th scope="col">Количество</th>
            <th scope="col">Общее цена</th>
        </tr>
        </thead>
        <tbody id="basket_body">
        <?
        if (Loader::includeModule("sale")) {
            $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
            foreach ($basket as $basketItem) {
                echo "<tr>";
                echo "<td>" . $basketItem->getField('NAME') . "</td>";
                echo "<td>" . $basketItem->getPrice() . "</td>";
                echo "<td>" . $basketItem->getQuantity() . "</td>";
                echo "<td>" . $basketItem->getFinalPrice() . "</td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <table class="table" id="products">
        <thead>
        <tr>
            <th scope="col">Товар</th>
            <th scope="col">Цена за 1 единицу товара</th>
            <th scope="col">Купить</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Футболка Мужская Чистота</td>
            <td>100 Р</td>
            <td><a href="javascript:void(0);" class="btn btn-primary btn-buy" data-id="18">Купить</a></td>
        </tr>
        <tr>
            <td>Футболка Женская Чистота</td>
            <td>200 Р</td>
            <td><a href="javascript:void(0);" class="btn btn-primary btn-buy" data-id="19">Купить</a></td>
        </tr>
        <tr>
            <td>Футболка Женская Ночь</td>
            <td>500 Р</td>
            <td><a href="javascript:void(0);" class="btn btn-primary btn-buy" data-id="20">Купить</a></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>