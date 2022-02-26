<?php

namespace Model\Repository;

use Model\Entity;

class IdentityMap
{
    protected static $identityMap = [];

    public static function add(Entity\IDomainObject $obj)
    {
        $key = self::getGlobalKey(get_class($obj), $obj->getId());

        self::$identityMap[$key] = $obj;
    }

    public static function get(string $classname, int $id)
    {
        $key = self::getGlobalKey($classname, $id);

        if (isset(self::$identityMap[$key])) {
            return self::$identityMap[$key];
        } else return false;
    }

    private function getGlobalKey(string $classname, int $id)
    {
        return sprintf('%s.%d', $classname, $id);
    }
}
