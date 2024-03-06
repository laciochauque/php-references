<?php

#Using The Library

require("./vendor/autoload.php");
use Laciochauque\PHPReferences\Reference;

#Generating a reference from an instance of the class
$reference = new Reference(
    entity:     "12345"  ,  //A string of numeric characters representing the entity code, where the amount should be credited, must have exactly 5 digits.
    amount:     3.141593  , //The amount that must be credited to the entity is usually the price of the invoice must be float or integer greater than 0    
    id:         "1234567",  //A string of numeric characters that uniquely identifies the invoice and must have exactly 7 digits, keep it null to randomize 
    deadline:   "01"        //A number corresponding to the month of the invoice deadline must have two digits, i.e., 01 for January and 12 for December. 
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
    entity:     "54321"  ,  //A string of numeric characters representing the entity code, where the amount should be credited, must have exactly 5 digits.
    amount:     100  ,      //The amount that must be credited to the entity is usually the price of the invoice must be float or integer greater than 0    
    id:         "7654321",  //A string of numeric characters that uniquely identifies the invoice and must have exactly 7 digits, keep it null to randomize 
    deadline:   "12"        //A number corresponding to the month of the invoice deadline must have two digits, i.e., 01 for January and 12 for December. 
);
echo $reference."\n"; 
//output: 76543211279

$reference = \Laciochauque\PHPReferences\Reference::generate("54321",100);
echo $reference->reference; //SAIDA:76543211279 
