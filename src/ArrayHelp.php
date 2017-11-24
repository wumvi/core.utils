<?php
declare(strict_types = 1);

namespace Wumvi\Classes\Utils;

/**
 * Class ArrayHelp
 * @package Wumvi\Classes\Utils
 */
class ArrayHelp
{
    /**
     * @param array $list
     * @return array
     */
    public function shuffleAssoc(array $list): array
    {
        if (!is_array($list)) {
            return $list;
        }

        $keys = array_keys($list);
        shuffle($keys);
        $random = [];
        foreach ($keys as $key) {
            $random[$key] = $list[$key];
        }

        return $random;
    }

    /**
     * @param array $array
     * @param string $delimiter
     * @return string
     */
    public function arrayKeyValueJoin(array $array, string $delimiter = ''): string
    {
        return implode($delimiter, array_map(function ($value, $key) {
            return $key . '=' . $value;
        }, $array, array_keys($array)));
    }
}
