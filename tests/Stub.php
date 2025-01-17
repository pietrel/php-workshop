<?php

namespace Tests;

class Stub
{
    protected $params;
    
    public function __construct(array $params)
    {
        $this->params = array_merge([
            'overwrite' => false,
        ], $params);

        $this->params['overwrite'] = filter_var($this->params['overwrite'], FILTER_VALIDATE_BOOLEAN);
    }


    public static function load($name, $override = [])
    {
        $file = dirname(__DIR__, 1) . '/tests/stubs/' . $name;

        return array_replace_recursive(
            json_decode(file_get_contents($file), true),
            $override
        );
    }
}
