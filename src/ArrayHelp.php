<?php
declare(strict_types = 1);

namespace Core\Utils\Utils;

/**
 * Class ArrayHelp
 * @package Core\Utils\Utils
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
}
