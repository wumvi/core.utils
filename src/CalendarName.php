<?php
declare(strict_types = 1);

namespace Core\Utils;

class CalendarName
{
    /** @const Список дней недели. */
    private const WEEK_DAYS = [
        1 => 'понедельник',
        2 => 'вторник',
        3 => 'среда',
        4 => 'четверг',
        5 => 'пятница',
        6 => 'суббота',
        0 => 'воскресенье',
    ];

    /** @const Список дней недели в коротком виде. */
    private const WEEK_DAY_SHORT = [
        1 => 'пн',
        2 => 'вт',
        3 => 'ср',
        4 => 'чт',
        5 => 'пт',
        6 => 'сб',
        0 => 'вс',
    ];

    /** @const Список месяцев в именительном падеже. */
    private const MONTHS_IN_NOMINATIVE = [
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
    private const MONTHS_IN_GEN = [
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
     * Правильное форматирование даты на русский язык
     *
     * @param string $format Шаблон результирующей строки (string) с датой.
     * @param int $timestamp Timestamp метки времени
     *
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
     * Возвращает название месяца в именительном падеже
     * по укзанному порядковому номеру месяца.
     *
     * @param int $month порядковый номер месяца.
     *
     * @return string Название месяца в именительном падеже.
     */
    public static function getMonthNameInNominative(int $month): string
    {
        return self::MONTHS_IN_NOMINATIVE[$month] ?? '';
    }

    /**
     * Выводит дату с указанным форматом в более удобном виде
     *
     * @param int $timestamp Timestamp
     * @param string $format Шаблон результирующей строки (string) с датой
     *
     * @return string Форматированная строка
     */
    public static function smartDate(int $timestamp = 0, string $format = 'j F Y'): string
    {
        $timestamp = $timestamp ?: time();

        if (date('Y') === date('Y', $timestamp)) {
            $format = trim(str_replace(['L', 'o', 'Y', 'y'], '', $format));
        }

        return self::date($format, $timestamp);
    }
}
