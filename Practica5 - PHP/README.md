## Ejercicio 1

```php
<?php
function doble($i) {
 return $i*2;
}
$a = TRUE;
$b = "xyz";
$c = 'xyz';
$d = 12;
echo gettype($a);
echo gettype($b);
echo gettype($c);
echo gettype($d);
if (is_int($d)) {
 $d += 4;
}
if (is_string($a)) {
 echo "Cadena: $a";
}
$d = $a ? ++$d : $d*3;
$f = doble($d++);
$g = $f += 10;
echo $a, $b, $c, $d, $f , $g;
?>
```

Las variables en php son dinámicas por lo que el tipo en si no está definido. A pesar de esto se determina el tipo de la misma según el tipo de dato del valor que le asignemos. Para este ejemplo tenemos las siguientes 6 variables:

```php
$a = TRUE; // Esta variable es de tipo boolean
$b = "xyz"; // Esta variable es de tipo string
$c = 'xyz'; // Esta variable es de tipo string
$d = 12; // Esta variable es de tipo int
$f = doble($d++); // Esta variable es de tipo double
$g = $f += 10; // Esta variable es de tipo double
$i // Esta definida en la función doble, es de tipo double y solo vive dentro de la función
```

Los operadores son:

- "=" : asignación
- "+=" : suma la variable el valor especificado y luego lo asigna a la misma
- "condicion ? valor_si_verdadero : valor_si_falso" : operador ternario, se utiliza para la decisión posterior a comparar dos valores
- "++$d" : incrementa $d en uno, y luego retorna $d
- "\*" : operador de multiplicación
- "$d++" : retorna $d, y luego incrementa $d en uno

La funcion es:

```php
function doble($i) {
 return $i*2;
}
```

cuyo parametro es la variable $i
Las dos estructuras de control del código son dos "if":

```php
if (is_int($d)) {
 $d += 4;
}
if (is_string($a)) {
 echo "Cadena: $a";
}
```

La salida de este programa va a ser:

- string -> tipo de $b
- boolean -> tipo de $a
- string -> tipo de $c
- integer -> tipo de $d
- 1 -> valor de $a
- xyz -> valor de $b
- xyz -> valor de $c
- 18 -> valor de $d
- 44 -> valor de $f
- 44 -> valor de $g
