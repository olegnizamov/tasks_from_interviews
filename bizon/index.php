<?php
/**
 *Имеется массив целых чисел. Априорно известно, что массив отсортирован в порядке возрастания значений его элементов.
 * Необходимо написать функцию которая вернет индекс элемента массива с заданным значением или -1 в случае
 * отсутствия данного значения в массиве. Поиск реализовать методом бисекции (половинного деления)
 *
 * @param array $array - массив данных
 * @param int $value - искомое значение
 * @return int
 */
function binarySearch(array $array, int $value): int
{
    $start = 0;
    $end = count($array) - 1;

    while ($start <= $end) {
        $middle = floor(($start + $end) / 2);

        if ($array[$middle] == $value) {
            return $middle;
        }

        if ($array[$middle] > $value) {
            $end = $middle - 1;
        } else {
            $start = $middle + 1;
        }
    }

    return -1;
}

//echo binarySearch([0, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 12, 13, 14, 15], 8);


/**
 * Необходимо написать функцию которая считает количество выходных дней (суббота и воскресенье) в заданном диапазоне дат.
 * Следует учесть, что диапазон может быть сколь угодно большим.
 *
 *
 * @param string $dateFrom
 * @param string $dateTo
 * @return int
 * @throws Exception
 */
function weekendDays(string $dateFrom, string $dateTo): int
{
    $start = new DateTime($dateFrom);
    $diff = date_diff(new DateTime($dateFrom), new DateTime($dateTo))->days;
    $saturdays = intval($diff / 6) + ($start->format('N') + $diff % 6 >= 6);
    $sundays = intval($diff / 7) + ($start->format('N') + $diff % 7 >= 7);

    return $sundays+$saturdays;
}

echo weekendDays("14-06-2020", "19-06-2020");

/**
 * Входом является массив целых чисел. Необходимо написать функцию которая возвращает
 * количество элементов входного массива кратных 3-м и 5-ти.
 *
 * @param array $array
 * @param int $value
 * @return int
 */
function getCountElementDivByValue(array $array, int $value): int
{
    $count = 0;
    foreach ($array as $element) {
        if ($element % $value == 0 && $element != 0) {
            $count++;
        }
    }

    return $count;
}

/**
 *
 * @param array $array
 * @param array $arrValue
 * @return int
 */
function getCountElementDivByArray(array $array, array $arrValue): int
{
    $sum = 0;
    foreach ($arrValue as $value) {
        $sum += getCountElementDivByValue($array, $value);
    }

    return $sum;
}

//echo getCountElementDivByArray([0, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 12, 13, 14, 15], [3, 5]);


/**
 *Необходимо написать функцию которая будет выводить элементы последовательности Фибоначчи до переданного на вход значения.
 * Например: при входном значении 10 будут выведены 0 1 1 2 3 5 8
 *
 * @param int $length
 * @return array
 */
function getFibonacci(int $length): string
{
    $firstElement = 0;
    $secondElement = 1;
    $arrFib = [$firstElement, $secondElement];

    if ($length == 0) {
        return "";
    } else if ($length == 1) {
        return $firstElement;
    } else if ($length == 2) {
        return implode(" ", $arrFib);
    } else {
        for ($i = 1; $i < $length - 1; $i++) {
            $arrFib[] = $arrFib[$i] + $arrFib[$i - 1];
        }

        return implode(" ", $arrFib);
    }
}

//echo getFibonacci(10);
