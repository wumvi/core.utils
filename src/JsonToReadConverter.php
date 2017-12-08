<?php
declare(strict_types = 1);

namespace Core\Utils\Utils;

/**
 * Class JsonToReadConverter
 */
class JsonToReadConverter
{
    /** @var array */
    private $mapping = [];

    /**
     * JsonMapping constructor.
     * @param array $mapping
     */
    public function __construct(array $mapping)
    {
        $this->mapping = $mapping;
    }

    /**
     * @param array $list
     *
     * @return array
     */
    public function convert(array $list): array
    {
        $result = [];
        foreach ($this->mapping as $modelKeyName => $jsonKeyName) {
            $result[$modelKeyName] = $list[$jsonKeyName];
        }

        return $result;
    }
}
