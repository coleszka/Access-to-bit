<?php

class AccessInt implements ArrayAccess
{
    private $decimal;
    private $binary = array();



    public function __construct(int $decimal)
    {
        $this->decimal = $decimal;

        if ($this->decimal >= 0 && $this->decimal <= 2147483647)
        {
            for ($i = 1; $i <= 32-strlen(decbin($this->decimal)); $i++)
                {
                    $this->binary[] = 0;
                }

            $decimal2 = str_split(decbin($this->decimal));

            foreach ($decimal2 as $value)
                {
                    $this->binary[] = intval ($value);
                }
        }
        elseif ($this->decimal < 0 && $this->decimal >= -2147483647)
        {
            $this->binary[] = 1;

            for ($i = 1; $i <= 31-strlen(decbin($this->decimal*(-1))); $i++)
            {
                $this->binary[] = 0;
            }

            $decimal2 = str_split(decbin($this->decimal*(-1)));

            foreach ($decimal2 as $value)
            {
                $this->binary[] = intval ($value);
            }
        }
    }

    public function readBit(int $bit):int
    {
        return $this->binary[$bit];
    }

    public function writeBit(int $bit, bool $value)
    {
        $this->binary[$bit] = $value;
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->decimal[] = $value;
        } else {
            $this->decimal[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->decimal[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->decimal[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->decimal[$offset]) ? $this->decimal[$offset] : null;
    }
}




//$przyklad = new AccessInt(22);
//echo $przyklad->readBit(1);
//var_dump($przyklad);
