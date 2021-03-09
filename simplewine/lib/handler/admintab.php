<?php

declare(strict_types=1);

namespace Nizamov\ExtraOrderInfo\Handler;

use Bitrix\Main\Application;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\SystemException;
use Nizamov\ExtraOrderInfo\Orm\ExtraOrderInfoTable;

/**
 * Обработчик событий вывода tab в админке заказа
 * Class AdminTab.
 */
class AdminTab
{
    /**
     * Событие вывода пользовательской вкладки
     *
     * @return array
     */
    public static function OnAdminSaleOrderViewHandler(): array
    {
        $tabSet = new AdminTab();
        return [
            "TABSET"  => "MyTabs",
            "GetTabs" => [$tabSet, "getTab"],
            "ShowTab" => [$tabSet, "showTab"],
        ];
    }

    /**
     * Данные вкладки.
     *
     * @param array $arArgs
     * @return array[]
     */
    public static function getTab(array $arArgs): array
    {
        return [
            [
                "DIV"   => "IpInfo",
                "TAB"   => "Информация об Ip пользователя",
                "ICON"  => "sale",
                "TITLE" => "Информация об Ip пользователя",
                "SORT"  => 1,
            ],
        ];
    }

    /**
     * Содержимое вкладки.
     *
     * @param string $divName
     * @param array $arArgs
     * @param bool $bVarsFromForm
     *
     * @return void
     * @throws ArgumentException
     * @throws SystemException
     */
    public static function showTab(string $divName, array $arArgs, bool $bVarsFromForm): void
    {
        if ($divName == "IpInfo") {
            $request = Application::getInstance()->getContext()->getRequest()->toArray();

            if (empty($request['ID'])) {
                return;
            }
            $orderId = (int)$request['ID'];
            $ipInfo = ExtraOrderInfoTable::getInfoByOrderId($orderId);

            if (empty($ipInfo)) {
                return;
            }

            $ipInfo = json_decode($ipInfo, true);
            echo '<pre>';
            echo print_r($ipInfo, true);
            echo '</pre>';
        }
    }
}