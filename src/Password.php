<?php
declare(strict_types=1);

namespace Core\Utils;

/**
 * Генератор паролей
 */
class Password
{
    private const COST = 12;

    /**
     * Возвращает солёный hash по строке
     *
     * @param string $str Строка
     * @param string $salt
     *
     * @return string Солёный hash
     */
    public function hash(string $pwd): string
    {
        $options = [
            'cost' => self::COST,
        ];

        return password_hash($pwd, PASSWORD_BCRYPT, $options);
    }

    public function verify(string $pwd, string $hash): bool
    {
        return password_verify($pwd, $hash);
    }

    /**
     * Возвращает пароль
     *
     * @param int $length Длинна пароля
     * @param string $specialChars
     *
     * @return string Пароль
     */
    public function generate(int $length, string $specialChars = '#@$%+'): string
    {
        $data = substr(bin2hex(random_bytes($length)), 0, $length);
        $count = mt_rand(1, $length);
        for ($i = 0; $i < $count; $i += 1) {
            $rnd = mt_rand(0, $length - 1);
            $data[$rnd] = strtoupper($data[$rnd]);
        }

        $rnd = mt_rand(0, $length - 1);
        $data[$rnd] = substr($specialChars, mt_rand(0, strlen($specialChars) - 1), 1);

        return $data;
    }
}
