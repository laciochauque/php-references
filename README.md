# PHP References

Uma biblioteca simplificada em php para gerar referências de pagamento de serviços. Essa biblioteca gera uma referência com um dígito verificador válido para algorítmos dos bancos Moçambicanos. Agradeço desde já apreciação e colaboração ou patrocínio.

## Instalação
```shell 
    composer require laciochauque/php-references
```
## Utilização

Para utilizar essa biblioteca você deve utilizar a classe **Laciochauque\PHPReferences\Reference** e criar uma nova instância da classe passando a entidade, o valor, a identificação única da referência (7 digitos) e o último mês (dois algarísmos do mês) no qual a referência ainda será tida como válida como ilustrado no exemplo:

```php
    use Laciochauque\PHPReferences\Reference;
    $reference = new Reference("12345",3.141593,"1234567","01");
    // O valor da referência é gerado no método constructor e armazenado no atributo reference
    echo $reference->reference; //SAIDA:12345670154 
    // O objecto da desta classe é stringable e retorna a referência gerada, contudo recomendo a instrução acima.
    echo $reference;//SAIDA: 12345670154             
```
Pode também gerar uma referência utilizando o método estático __::generate()__ da mesma classe que  retornará um novo objecto da classe Reference como ilustrado no exemplo:

```php
    $reference = \Laciochauque\PHPReferences\Reference::generate("54321",100,"7654321","12");
    echo $reference->reference; //SAIDA:76543211279 
```
Não é obrigatório informar o identificador o terceiro(código da referência) nem o quarto argumento(último mês da validade da referência) e se não informar esses valores, será gerada uma referência válida para todos os meses e com um código de identificação aleatório como no exemplo:

```php
        $reference = \Laciochauque\PHPReferences\Reference::generate("54321",100);
        echo $reference->reference; //SAIDA:22764527060 
``` 
## Requisitos
- *Versão PHP*: 8.0 ou superior        