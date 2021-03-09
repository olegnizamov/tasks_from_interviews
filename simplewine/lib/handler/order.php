<?php

declare(strict_types=1);

namespace Nizamov\ExtraOrderInfo\Handler;

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Nizamov\ExtraOrderInfo\Helper\RipeHelper;
use Nizamov\ExtraOrderInfo\Orm\ExtraOrderInfoTable;

/**
 * Обработчик события добавления нового заказа.
 * Class Order.
 */
class Order
{
    /**
     * Событие добавления заказа.
     *
     * @param int $orderId
     * @param array $arFields
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public static function OnOrderAddHandler(int $orderId, array $arFields)
    {
        if (empty($orderId)) {
            return;
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $ipInfo = RipeHelper::getInfo($ip);

        if (!empty($ipInfo)) {
            $ipInfo = json_encode($ipInfo);
        }

        $result = ExtraOrderInfoTable::add(
            [
                'ORDER_ID' => $orderId,
                'IP'       => $ip,
                'IP_INFO'  => $ipInfo,
            ]
        );

        if (!$result->isSuccess()) {
            $errors = $result->getErrors();
            foreach ($errors as $error) {
                AddMessage2Log($error->getMessage(), "nizamov.extraorderinfo");
            }
        }

        return true;
    }

}