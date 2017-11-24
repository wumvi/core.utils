<?php
declare(strict_types = 1);

namespace Wumvi\Classes;

/**
 * Класс для работы со строками.
 */
class Str
{
    /** @const Список дней недели. */
    const WEEK_DAYS = [
        1 => 'понедельник',
        2 => 'вторник',
        3 => 'среда',
        4 => 'четверг',
        5 => 'пятница',
        6 => 'суббота',
        0 => 'воскресенье',
    ];

    /** @const Список дней недели в коротком виде. */
    const WEEK_DAY_SHORT = [
        1 => 'пн',
        2 => 'вт',
        3 => 'ср',
        4 => 'чт',
        5 => 'пт',
        6 => 'сб',
        0 => 'вс',
    ];

    /** @const Список месяцев в именительном падеже. */
    const MONTHS_IN_NOMINATIVE = [
        1 => 'январь',
        2 => 'февраль',
        3 => 'март',
        4 => 'апрель',
        5 => 'май',
        6 => 'июнь',
        7 => 'июль',
        8 => 'август',
        9 => 'сентябрь',
        10 => 'октябрь',
        11 => 'ноябрь',
        12 => 'декабрь',
    ];

    /** @const Список месяцев в родительном падеже. */
    const MONTHS_IN_GEN = [
        1 => 'января',
        2 => 'февраля',
        3 => 'марта',
        4 => 'апреля',
        5 => 'мая',
        6 => 'июня',
        7 => 'июля',
        8 => 'августа',
        9 => 'сентября',
        10 => 'октября',
        11 => 'ноября',
        12 => 'декабря',
    ];

    /**
     * Возвращает название месяца в именительном падеже
     * по укзанному порядковому номеру месяца.
     *
     * @param int $month порядковый номер месяца.
     * @return string Название месяца в именительном падеже.
     */
    public static function getMonthNameInNominative(int $month): string
    {
        return self::MONTHS_IN_NOMINATIVE[$month] ?? '';
    }

    /**
     * Конвертирует данные в JSON из Array.
     *
     * @param mixed $var Значение (можно использовать массивы)
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
     * Определение правильного окончания для слова в зависимости от численности.
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
     * Метод обрезает текст, если он больше заданной
     * длины и добавляет в конце троеточие.
     *
     * @param  string $text Исходный текст
     * @param  int $length Ограничение по длине
     * @return string Обрезанный текст
     */
    public static function subDescription(string $text, int $length): string
    {
        return mb_strlen($text, 'utf-8') > $length ? mb_substr($text, 0, $length - 3, 'utf-8') . '...' : $text;
    }

    /**
     * Переводит первый символ строки в верхний регистр.
     * Аналог ucfirst для русских слов.
     *
     * @param string $str Строка для преобразования.
     * @return string Результирующая строка.
     */
    public static function firstCharToUpper(string $str): string
    {
        return mb_strtoupper(mb_substr($str, 0, 1, 'UTF-8'), 'UTF-8')
            . mb_substr($str, 1, mb_strlen($str, 'UTF-8'), 'UTF-8');
    }

    /**
     * Переводит первый символ строки в нижний регистр.
     * Аналог lcfirst для русских слов.
     *
     * @param string $str Строка для преобразования.
     * @return string Результирующая строка.
     */
    public static function firstCharToLower(string $str): string
    {
        return mb_strtolower(mb_substr($str, 0, 1, 'UTF-8'), 'UTF-8')
            . mb_substr($str, 1, mb_strlen($str, 'UTF-8') - 1, 'UTF-8');
    }

    /**
     * Переводит строку в нижний регистр
     *
     * @param string $str Строка для преобразования.
     * @return string Результирующая строка.
     */
    public static function strtolower(string $str): string
    {
        return mb_strtolower($str, 'UTF-8');
    }

    /**
     * Правильное форматирование даты на русский язык
     * @param string $format Шаблон результирующей строки (string) с датой.
     * @param int $timestamp Timestamp метки времени
     * @return string Отформатированная строка
     *
     * @link http://php.net/manual/ru/function.date.php
     */
    public static function date(string $format, int $timestamp = 0): string
    {
        $timestamp = $timestamp ?: time();

        $num = date('n', $timestamp);
        // Если день не указан, массив возвращается в именительном падеже.
        $isGenitive = strstr($format, 'd') || strstr($format, 'j');
        $month = $isGenitive ? self::MONTHS_IN_GEN[$num] : self::MONTHS_IN_NOMINATIVE[$num];

        $ruFormat = str_replace(
            ['F', 'M', 'l', 'D',],
            [
                $month,
                mb_substr($month, 0, 3, 'UTF-8'),
                self::WEEK_DAYS[date('w', $timestamp)],
                self::WEEK_DAY_SHORT[date('w', $timestamp)],
            ],
            $format
        );

        return date($ruFormat, $timestamp);
    }

    /**
     * Выводит дату с указанным форматом в более привлекательном виде, применяя для этого некоторые изменения.
     *
     * Применяет следующие изменения:
     * - если год указанной даты равен году текущей даты, код не отображается.
     *
     * @param int $timestamp Представляет собой integer
     * метку времени,
     * @param string $format Шаблон результирующей строки (string) с датой.
     * по умолчанию равную текущему локальному времени, если timestamp не указан.
     * Другими словами, значение по умолчанию равно результату функции time().
     *
     * @return string Форматированная строка.
     */
    public static function smartDate(int $timestamp = 0, string $format = 'j F Y'): string
    {
        $timestamp = $timestamp ?: time();

        if (date('Y') == date('Y', $timestamp)) {
            $format = trim(str_replace(['L', 'o', 'Y', 'y'], '', $format));
        }

        return self::date($format, $timestamp);
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
     * Обрезалка строки до первого встреченного спецсимвола
     *
     * @param string $string Строка, которую надо укоротить
     * @param array $symbols Массив дополнительных символов,на которые будет реагировать функция
     * @return string Укороченная строка
     *
     */
    public static function cutStringUntilFirstSpecialSign(string $string, array $symbols = [',', '(', '/', '[']): string
    {
        foreach ($symbols as $symbol) {
            $pos = mb_strpos($string, $symbol, 0, 'UTF-8');
            if ($pos !== false) {
                return mb_substr($string, 0, $pos, 'UTF-8');
            }
        }

        return $string;
    }

    /**
     * Форматирует размер файла
     *
     * @param string $bytes Размер в байтах
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

    /**
     * Сравнивание строки регистро-независимо
     *
     * @param string $str1 Первая строка
     * @param string $str2 Вторая строка
     * @return int < 0 if str1 is less than str2; > 0
     * if str1 is greater than str2, and 0 if they are equal.
     */
    public static function strCaseCmp(string $str1, string $str2): int
    {
        return strcmp(mb_strtoupper($str1, 'utf-8'), mb_strtoupper($str2, 'utf-8'));
    }
}
