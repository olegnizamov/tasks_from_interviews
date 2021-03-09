<?php

declare(strict_types=1);

namespace Nizamov\ExtraOrderInfo\Helper;

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Config\Option;

/**
 * Класс Helper для работы с Ripe сервисом.
 * Class RipeHelper.
 */
class RipeHelper
{
    /**
     * Метод получает преобразованную информацию из ripe.
     *
     * @param string $ip
     * @return array|null
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public static function getInfo(string $ip): ?array
    {
        $result = self::request($ip);
        if (empty($result)
            || !is_array($result)
            || empty($result['objects'])
            || empty($result['objects']['object'])
        ) {
            return null;
        }

        return $result['objects']['object'];
    }

    /**
     * Метод получает информацию из ripe.
     *
     * @param string $ip
     * @return array|null
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    private static function request(string $ip): ?array
    {
        $url = self::getRipeUrl() . $ip;
        $curl = curl_init();
        if (empty($curl)) {
            return null;
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    }

    /**
     * Возвращает url ripe.
     *
     * @return string
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    private static function getRipeUrl(): string
    {
        return Option::get(
            'nizamov.extraorderinfo',
            'ip_extra_info',
            'https://rest.db.ripe.net/search.json?query-string='
        );
    }


}