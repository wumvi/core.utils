<?php
declare(strict_types=1);

namespace Core\Utils;

/**
 * Генератор паролей
 */
class PasswordGenerator
{
    /**
     * Возвращает солёный hash по строке
     *
     * @param string $str Строка
     * @param string $salt
     *
     * @return string Солёный hash
     */
    public static function hashWithSalt(string $str, string $salt): string
    {
        return hash('sha256', $str . $salt);
    }
}
