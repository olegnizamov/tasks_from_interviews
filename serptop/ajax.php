<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Catalog\Product\Basket;
use Bitrix\Sale;
use Bitrix\Main\Context;

$arRequest = Application::getInstance()->getContext()->getRequest()->toArray();
$arRequest = $arRequest['PARAMS'];
if ($arRequest["action"] == "add2Basket" && intval($arRequest["id"])) {

    if (Loader::includeModule("catalog") && Loader::includeModule("sale") && Loader::includeModule("iblock")) {

        $productId = intval($arRequest["id"]);
        $quantity = intval($arRequest["quantity"]) ? intval($arRequest["quantity"]) : 1;

        $product = [
            'PRODUCT_ID' => $productId,
            'QUANTITY'   => $quantity,
        ];

        //Вариант 1, он deprecated, но работащий вариант
        //$result = Add2BasketByProductID($productId, $quantity);

        //Вариант 2, работает корректно D7
        $result = Basket::addProduct($product);

        if ($result->isSuccess()) {
            $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Context::getCurrent()->getSite());

            $arrBasketItems = [];

            foreach ($basket as $basketItem) {
                $currentBasketItem['NAME'] = $basketItem->getField('NAME');
                $currentBasketItem['PRICE_BY_ONE'] = $basketItem->getPrice();
                $currentBasketItem['QUANTITY'] = $basketItem->getQuantity();
                $currentBasketItem['ALL_PRICE'] = $basketItem->getFinalPrice();
                $arrBasketItems[] = $currentBasketItem;
            }

            echo json_encode(["SUCCESS" => true, 'BASKET' => $arrBasketItems]);

        } else {
            echo json_encode(["SUCCESS" => false, 'TEXT' => 'Ошибка добавления товара']);
        }
    }
}
