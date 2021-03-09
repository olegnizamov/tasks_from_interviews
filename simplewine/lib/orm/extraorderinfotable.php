<?php

declare(strict_types=1);

namespace Nizamov\ExtraOrderInfo\Orm;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\TextField,
    Bitrix\Main\ORM\Fields\StringField,
    Bitrix\Main\SystemException,
    Bitrix\Main\ORM\Fields\Validators\LengthValidator;

/**
 * Class ExtraOrderInfoTable
 *
 * Fields:
 * <ul>
 * <li> id int mandatory
 * <li> order_id int mandatory
 * <li> ip string mandatory
 * <li> ip_info text optional
 * </ul>
 * @package Nizamov\ExtraOrderInfo\Orm
 **/
class ExtraOrderInfoTable extends DataManager
{
    /**
     * Возвращает название таблицы.
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'extra_order_ip_info';
    }

    /**
     * Возвращает карту сущности.
     *
     * @return array
     * @throws SystemException
     */
    public static function getMap(): array
    {
        return [
            new IntegerField(
                'ID',
                [
                    'primary'      => true,
                    'autocomplete' => true,
                ]
            ),
            new IntegerField(
                'ORDER_ID',
                [
                    'required' => true,
                ]
            ),
            new StringField(
                'IP',
                [
                    'validation' => [__CLASS__, 'validateIp'],
                    'required'   => true,
                ]
            ),
            new TextField(
                'IP_INFO'
            ),
        ];
    }

    /**
     * Валидатор для поля IP.
     *
     * @return array
     */
    public static function validateIp()
    {
        return [
            new LengthValidator(null, 100),
        ];
    }

    /**
     * Метод получения записи по Id заказа
     * @param int $orderId
     *
     * @return string
     *
     * @throws SystemException
     * @throws ArgumentException
     */
    public static function getInfoByOrderId(int $orderId): string
    {
        $res = self::getList(
            [
                'filter' => ['ORDER_ID' => $orderId],
                'select' => ['ID', 'IP_INFO'],
                'limit'  => 1,
            ]
        )->fetch();

        return ($res) ? $res['IP_INFO'] : '';
    }
}
