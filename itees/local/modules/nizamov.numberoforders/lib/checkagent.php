<?php
namespace Nizamov\Numberoforders;

use \Bitrix\Main;
use \Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;


class CheckAgent
{

    /**
     * Агент,отрабатывается каждый час.
     *
     * Для системы мониторинга сайта нужно один раз в час формировать текстовый файл с
     * количеством заказов и суммой покупок по заказам, оформленным за час.
     *
     * Формируемый файл содержит строку со временем генерации, количеством заказов,
     * суммой заказов в формате: DD.MM.YYYY HH:MI:SS #КОЛИЧЕСТВО# #CУММА#, где
     * #КОЛИЧЕСТВО# и #CУММА# целые числа с округлением вниз.
     *
     * @return string
     * @throws Main\LoaderException
     */

    public static function getCurrentNumberOfOrders()
    {
        $currentTime = static::getCurrentDateAndTime();
        $arrCountAndPrice = static::getCountAndPrice();
        $logString = $currentTime . " " . implode(" ", $arrCountAndPrice);
        static::writeToFile($logString);
        return "\Nizamov\Numberoforders\CheckAgent::getCurrentNumberOfOrders();";
    }


    /**
     * Метод получения общего количества заказов и сумму заказов
     *
     * @return array - массив, который содержит общее количество заказов и сумму заказов
     * @throws Main\LoaderException
     */
    public static function getCountAndPrice()
    {
        $arResult['ALL_COUNT'] = 0;
        $arResult['SUM_PRICE'] = 0;
        if (Loader::includeModule("sale")) {
            $rsOrder = \CSaleOrder::GetList([], []);
            $arResult['ALL_COUNT'] = $rsOrder->SelectedRowsCount();
            while ($arOrder = $rsOrder->Fetch()) {
                $arResult['SUM_PRICE'] += $arOrder['PRICE'];
            }
            $arResult['SUM_PRICE'] = floor($arResult['SUM_PRICE']);
        }

        return $arResult;
    }

    /**
     * Метод записи строки в файл
     *
     * @param string $logInfo - строка для записи в файл
     * @return bool
     */
    public static function writeToFile($logInfo)
    {
        return RewriteFile($_SERVER["DOCUMENT_ROOT"] . "/orders.txt", $logInfo);
    }

    /**
     * Метод получения текущей даты и времени
     *
     * @return string
     */
    public static function getCurrentDateAndTime()
    {
        return date("d-m-Y H:i:s");
    }
}
