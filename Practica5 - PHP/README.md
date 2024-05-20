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

## Ejercicio 2

### a.

```php
<?php
$i = 1;
while ($i <= 10) {
 echo $i++;
}
?>

<?php
$i = 1;
while ($i <= 10):
 print $i;
 $i++;
endwhile;
?>

<?php
$i = 0;
do {
 print ++$i;
} while ($i<10);
?>
```

En este caso, los codigos son efectivamete equivalentes, es decir, producen la misma salida. La unica diferencia entre el primer y el segundo codigo es la sintaxis del while, que PHP reconoce tanto por si solo como terminando con el "endwhile". El tercer codigo implementa un "do while", con la variable comenzando en 0 y dentro del loop sumandole 1 antes de printearla (a diferencia de los otros 2, que primero printean y luego suman), y terminando el loop cuando la variable llegue a 10.

### b.

```php
//Codigo 1
<?php
for ($i = 1; $i <= 10; $i++) {
 print $i;
}
?>

//Codigo 2
<?php
for ($i = 1; $i <= 10; print $i, $i++) ;
?>

//Codigo 3
<?php
for ($i = 1; ;$i++) {
 if ($i > 10) {
 break;
 }
 print $i;
}
?>
//Codigo 4
<?php
$i = 1;
for (;;) {
 if ($i > 10) {
 break;
 }
 print $i;
 $i++;
}
?>
```

## Ejercicio 3

### a.

```php
<html>
<head><title>Documento 1</title></head>
<body>
<?php
 echo "<table width = 90% border = '1' >";
 $row = 5;
 $col = 2;
 for ($r = 1; $r <= $row; $r++) {
 echo "<tr>";
 for ($c = 1; $c <= $col;$c++) {
 echo "<td>&nbsp;</td>\n";
 } echo "</tr>\n";
 }
 echo "</table>\n";
?>
</body>
</html>
```
