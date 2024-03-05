<?php

namespace Laciochauque\PHPReferences;

/**
 *  The Millenium BIM reference generator class for PHP >= 8.0
 *  @author Lácio Chaúque <laciochauque7@gmail.com>
 *  @version 1.0.0
 */
class Reference
{
    
    private array $payload =  [
        30 => [
            "data" => 0,
            "weight" => 57,
            "wxdata" => 0
        ],
        29 => [
            "data" => 0,
            "weight" => 93,
            "wxdata" => 0
        ],
        28 => [
            "data" => 0,
            "weight" => 19,
            "wxdata" => 0
        ],
        27 => [
            "data" => 0,
            "weight" => 31,
            "wxdata" => 0
        ],
        26 => [
            "data" => 0,
            "weight" => 71,
            "wxdata" => 0
        ],
        25 => [
            "data" => 0,
            "weight" => 75,
            "wxdata" => 0
        ],
        24 => [
            "data" => 0,
            "weight" => 56,
            "wxdata" => 0
        ],
        23 => [
            "data" => 0,
            "weight" => 25,
            "wxdata" => 0
        ],
        22 => [
            "data" => 0,
            "weight" => 51,
            "wxdata" => 0
        ],
        21 => [
            "data" => 0,
            "weight" => 73,
            "wxdata" => 0
        ],
        20 => [
            "data" => 0,
            "weight" => 17,
            "wxdata" => 0
        ],
        19 => [
            "data" => 0,
            "weight" => 89,
            "wxdata" => 0
        ],
        18 => [
            "data" => 0,
            "weight" => 38,
            "wxdata" => 0
        ],
        17 => [
            "data" => 0,
            "weight" => 62,
            "wxdata" => 0
        ],
        16 => [
            "data" => 0,
            "weight" => 45,
            "wxdata" => 0
        ],
        15 => [
            "data" => 0,
            "weight" => 53,
            "wxdata" => 0
        ],
        14 => [
            "data" => 0,
            "weight" => 15,
            "wxdata" => 0
        ],
        13 => [
            "data" => 0,
            "weight" => 50,
            "wxdata" => 0
        ],
        12 => [
            "data" => 0,
            "weight" => 5,
            "wxdata" => 0
        ],
        11 => [
            "data" => 0,
            "weight" => 49,
            "wxdata" => 0
        ],
        10 => [
            "data" => 0,
            "weight" => 34,
            "wxdata" => 0
        ],
        9 => [
            "data" => 0,
            "weight" => 81,
            "wxdata" => 0
        ],
        8 => [
            "data" => 0,
            "weight" => 76,
            "wxdata" => 0
        ],
        7 => [
            "data" => 0,
            "weight" => 27,
            "wxdata" => 0
        ],
        6 => [
            "data" => 0,
            "weight" => 90,
            "wxdata" => 0
        ],
        5 => [
            "data" => 0,
            "weight" => 9,
            "wxdata" => 0
        ],
        4 => [
            "data" => 0,
            "weight" => 30,
            "wxdata" => 0
        ],
        3 => [
            "data" => 0,
            "weight" => 3,
            "wxdata" => 0
        ],
        2 => [
            "data" => 0,
            "weight" => 10,
            "wxdata" => 0
        ],
        1 => [
            "data" => 0,
            "weight" => 1,
            "wxdata" => 0
        ],
    ];

    private array $attributes = [
        "entity"    => "00000",
        "amount"    => "000",
        "sum"       => 0,
        "mod97"     => 0,
        "id"        => "0000000",
        "deadline"  => "00",
        "checkdigit" => "00",
        "reference" => "00000000000",
    ];
    private function calculate()
    {
        $data = strrev($this->entity.$this->id.$this->deadline.$this->amount);
        if(strlen($data) > 30){
            throw new \Exception("The money is too long to generate reference...", 500);
        }

        $data = str_split($data);
        $this->attributes["sum"] = 0;
        foreach ($data as $key => $value) {
            $this->payload[$key+1]["data"] = (int)$value;
            $this->payload[$key+1]["wxdata"] = $this->payload[$key+1]["data"] * $this->payload[$key+1]["weight"];
            $this->attributes["sum"] += $this->payload[$key+1]["wxdata"];
        }
        $this->attributes["mod97"]      = $this->attributes["sum"] % 97;
        $this->attributes["checkdigit"] = str_pad( (string) 98 - $this->attributes["mod97"],2,"0",STR_PAD_LEFT);
        $this->attributes["reference"]  = $this->id.$this->deadline.$this->checkdigit;
    }
    private function fillOrFail($attribute, $value)
    {
        switch (true) {
            case $attribute == 'entity' && preg_match("/^\d{5}$/", $value):
                $this->attributes["entity"] = $value;
                break;
            case $attribute == 'amount' && is_numeric($value):
                $this->attributes["amount"] = number_format((float)$value, 2, "", "")."00";
                break;
            case $attribute == 'id' && preg_match("/^\d{7}$/", $value):
                $this->attributes["id"] = $value;
                break;
            case $attribute == 'deadline' && preg_match("/^\d{2}$/", $value):
                $this->attributes["deadline"] = $value;
                break;
            case in_array(strtolower($attribute), ["amount", "deadline", "id"]):
                throw new \Exception("Your filled an invalid value for attribute {$attribute}: {$value}");
                break;
            default:
                throw new \Exception("The {$attribute} attribute isn't fillable.");
                break;
        }
    }
    private function uniqid(int $length = 7) : string
    {
        $digits = "0123456789";
        $hash   = "";
        for ($i=0; $i < $length; $i++) { 
            $hash .= substr(str_shuffle($digits),0,1); 
        }
        return $hash;
    }

    public function __construct(string $entity, float $amount, string $id = null, string $deadline = null)
    {
        $this->fillOrFail("entity",$entity);
        $this->fillOrFail("amount",$amount);
        $this->fillOrFail("id",$id===null ? $this->uniqid() : $id);
        $this->fillOrFail("deadline",$deadline===null ? (string)rand(13,99) : $deadline);
        $this->calculate();
    }

    public function __debugInfo()
    {
        return $this->attributes;
    }

    public function __set($name, $value)
    {
        $this->fillOrFail($name, $value);
    }

    public function __get($name)
    {
        $name = strtolower($name);
        if (!key_exists(key: $name, array: $this->attributes)) {
            throw new \Exception("The class " . self::class . " doesn't have an attribute called {$name}", 500);
        }
        return $this->attributes[$name];
    }
    public function __toString()
    {
        return $this->reference;
    }

    public static function generate(string $entity, float $amount, string $id = null, string $deadline = null)
    {
        return new static($entity, $amount, $id, $deadline);
    }
}