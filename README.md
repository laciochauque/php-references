# PHP References

A simplified PHP library for generating payment references for services using a combination of entity, reference, and value. This library generates the check digit using the algorithm of Mozambican banks. Thank you in advance for your consideration.

## Instalation
```shell 
    composer require laciochauque/php-references
```
```php
<?php

#Using The Library

require("./vendor/autoload.php");
use Laciochauque\PHPReferences\Reference;

#Generating a reference from an instance of the class
$reference = new Reference(
    entity:     "12345"  ,  //A string of numeric characters representing the entity code.
    amount:     3.141593  , //The amount that must be credited to the entity.
    id:         "1234567",  //A string of numeric characters(7) that uniquely identifies the invoice.
    deadline:   "01"        //A number corresponding to the month of the invoice deadline must have two digits.
);
echo $reference."\n";   
//OUTPUT: 12345670154
var_dump($reference);
/* OUTPUT:
  object(Laciochauque\PHPReferences\Reference)#3 (8) {          
  ["entity"]=>string(5) "12345"                                           
  ["amount"]=>string(5) "31400"                                           
  ["sum"]=>int(2469)
  ["mod97"]=>int(44)                                                     
  ["id"]=>string(7) "1234567"
  ["deadline"]=>string(2) "01"                                              
  ["checkdigit"]=>string(2) "54"                                              
  ["reference"]=>string(11) "12345670154"                                    
}                                                             
 */
#Generating a reference from a static method
$reference = \Laciochauque\PHPReferences\Reference::generate(
    entity:     "54321"  ,  //A string of numeric characters representing the entity code.
    amount:     100  ,      //The amount that must be credited to the entity    
    id:         "7654321",  //A string of numeric characters(7) that uniquely identifies the invoice.
    deadline:   "12"        //A number corresponding to the month of the invoice deadline must have two digits. 
);
echo $reference."\n"; 
//output: 76543211279
```

## Our It Works
Você instancia a classe Laciochauque\PHPReferences\Reference passando no constructor a entidade,  