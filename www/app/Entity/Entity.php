<?php

namespace App\Entity;

use stdClass;

class Entity extends stdClass
{
    /**
     * @param stdClass|null $parameters
     */
    public function __construct(stdClass $parameters = null)
    {
        if ($parameters) {
            $this->fillSelf($parameters);
        }
    }

    /**
     * @param stdClass $parameters
     * @return void
     */
    private function fillSelf(stdClass $parameters) : void
    {
        foreach ($parameters as $parameterKey => $parameterValue) {
            foreach (get_object_vars($parameters) as $key => $value) {
                if (str_contains($parameterKey, $key) && (strlen($parameterKey) - strlen($key)) <= 3 ) {
                    $key = ucwords($key, '_');
                    $key = str_replace('_', '', $key);
                    $method = "set{$key}";

                    $this->{$method}($parameterValue);
                }
            }
        }
    }
}