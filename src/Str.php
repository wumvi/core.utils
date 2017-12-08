<?php
declare(strict_types=1);

namespace Core\Utils;

/**
 * Класс для работы со строками.
 */
class Str
{
    /**
     * Конвертирует данные в JSON из Array.
     *
     * @param mixed $var Значение
     *
     * @return string Сконвертированный текст
     */
    public static function toJson($var): string
    {
        return json_encode(
            $var,
            JSON_HEX_TAG |
            JSON_HEX_AMP |
            JSON_HEX_APOS |
            JSON_HEX_QUOT |
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * Конвернурует данные из JSON в Array.
     *
     * @param string $var Значение (можно использовать массивы)
     *
     * @return array|mixed|string
     */
    public static function fromJson(string $var)
    {
        return json_decode($var, true);
    }

    /**
     * Производит транслитерацию русских слов.
     *
     * @param  string $str Строка
     *
     * @return string
     */
    public static function translitRu(string $str): string
    {
        $dic = array(
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',
            'Д' => 'D', 'Е' => 'E', 'Ж' => 'J', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'Ts', 'Ч' => 'Ch',
            'Ш' => 'Sh', 'Щ' => 'Sch', 'Ъ' => '', 'Ы' => 'Yi', 'Ь' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya', 'а' => 'a', 'б' => 'b',
            'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ж' => 'j',
            'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
            'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h',
            'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => 'y',
            'ы' => 'yi', 'ь' => '\'', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        );

        return strtr($str, $dic);
    }

    /**
     * Метод обрезает текст, если он больше заданной
     * длины и добавляет в конце троеточие.
     *
     * @param  string $text Исходный текст
     * @param  int $length Ограничение по длине
     *
     * @return string Обрезанный текст
     */
    public static function subDescription(string $text, int $length): string
    {
        return mb_strlen($text, 'utf-8') > $length ? substr($text, 0, $length - 3) . '...' : $text;
    }

    /**
     * Выводит стоимость в стандартизированном виде, применяя для этого некоторые изменения.
     *
     * @param int $rawPrice Неформатированная строка цены.
     *
     * @return string Форматированная строка цены.
     */
    public static function smartMoney(int $rawPrice): string
    {
        return $rawPrice < 10000
            ? number_format($rawPrice, 0, '.', '')
            : number_format($rawPrice, 0, '.', ' ');
    }

    /**
     * Преобразовывает цену в строковое представление.
     *
     * @param int $num цена в численном представлении
     * @param bool $isAddNameOfMoney
     *
     * @return string цена в строковом представлении
     *
     * @see http://habrahabr.ru/post/53210/
     */
    public static function pricetoText(int $num, bool $isAddNameOfMoney = true): string
    {
        $zero = 'ноль';
        $ten = [
            ['', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
            ['', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
        ];

        $a20 = [
            'десять',
            'одиннадцать',
            'двенадцать',
            'тринадцать',
            'четырнадцать',
            'пятнадцать',
            'шестнадцать',
            'семнадцать',
            'восемнадцать',
            'девятнадцать',
        ];

        $tensList = [
            2 => 'двадцать',
            3 => 'тридцать',
            4 => 'сорок',
            5 => 'пятьдесят',
            6 => 'шестьдесят',
            7 => 'семьдесят',
            8 => 'восемьдесят',
            9 => 'девяносто',
        ];

        $hundredsList = [
            '',
            'сто',
            'двести',
            'триста',
            'четыреста',
            'пятьсот',
            'шестьсот',
            'семьсот',
            'восемьсот',
            'девятьсот',
        ];

        $unit = [
            ['копейка', 'копейки', 'копеек', 1],
            ['рубль', 'рубля', 'рублей', 0],
            ['тысяча', 'тысячи', 'тысяч', 1],
            ['миллион', 'миллиона', 'миллионов', 0],
            ['миллиард', 'милиарда', 'миллиардов', 0],
        ];

        $numArr = explode(',', sprintf("%015.2f", $num));
        $rub = isset($numArr[0]) ? $numArr[0] : 0;
        $kop = isset($numArr[1]) ? $numArr[1] : 0;

        $out = [];
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v)) {
                    continue;
                }

                $uk = count($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));

                // mega-logic
                $out[] = $hundredsList[$i1]; # 1xx-9xx
                if ($i2 > 1) {
                    $out[] = $tensList[$i2] . ' ' . $ten[$gender][$i3];# 20-99
                } else {
                    $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3];# 10-19 | 1-9
                }

                // units without rub & kop
                if ($uk > 1) {
                    $out[] = self::plural(
                        $unit[$uk],
                        $v
                    );
                }
            }
        } else {
            $out[] = $zero;
        }

        if ($isAddNameOfMoney) {
            $out[] = self::plural($unit[1], intval($rub)); // rub

            $out[] = empty($kop)
                ? $zero . ' копеек'
                : $kop . ' ' . self::plural($unit[0], $kop); // kop
        }

        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }

    /**
     * Определение правильного окончания для слова в зависимости от численности.
     *
     * @param array $endings Массив существительных склоняемых к числу (1, 4, 5)
     * @param int $number Число для которого нужно выбрать правильную фразу.
     *
     * @return string Результат
     */
    public static function plural(array $endings, int $number): string
    {
        $numberForOperations = abs($number);
        $cases = [2, 0, 1, 1, 1, 2];

        $isTwo = ($numberForOperations % 100 > 4 && $numberForOperations % 100 < 20);
        $endNum = $isTwo ? 2 : $cases[min($numberForOperations % 10, 5)];
        $string = $endings[$endNum];

        return sprintf($string, $number);
    }

    /**
     * Форматирует размер файла
     *
     * @param string $bytes Размер в байтах
     *
     * @return string Строка в формате 34,56 Б|КБ|МБ|ГБ|ТБ
     */
    public static function convertSizeToText(string $bytes): string
    {
        $kb = 1 << 10;
        $mb = $kb << 10;
        $gb = $mb << 10;
        $tb = $gb << 10;

        if ($bytes < $kb) {
            return $bytes . ' Б';
        } elseif ($bytes < $mb) {
            return number_format($bytes / $kb, 2, ',', '') . ' КБ';
        } elseif ($bytes < $gb) {
            return number_format($bytes / $mb, 2, ',', '') . ' MБ';
        } elseif ($bytes < $tb) {
            return number_format($bytes / $gb, 2, ',', '') . ' ГБ';
        }

        return number_format($bytes / $tb, 2, ',', '') . ' ТБ';
    }
}
