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

Los cuatro codigo realizan la misma tarea. Todos imprimen `12345678910`. Sin embargo utilizan logicas distintas para iterar. En el codigo 1, la variable `$i` solo existe dentro de la estructura `for`, y en ella se realiza la comparación. Dentro de las instrucciones que ejecuta en cada iteración el `for` se encuentra la que imprime. El codigo 2, tiene de diferencia que en la exp3 del for ademas de sumar un valor en la variable, imprime. El 3 deja vacio la exp2 del bucle, dando su valor por defecto en TRUE; sin la expreción de break no terminaría jamas. El 4 difiere principalmente en el skope de la variable i. Esta existe fuera del bucle, y se incrementa en su interior. Al igual que con el 3 necesita una sentencia de break. No define una variable sobre la cual itera, no define condicion, y tampoco incremento, dejando vacias las tres expreciones. 

### c.

//Codigo 1
```php
<?php
if ($i == 0) {
 print "i equals 0";
} elseif ($i == 1) {
 print "i equals 1";
} elseif ($i == 2) {
 print "i equals 2";
}
?>
```
//Codigo 2
```php
<?php
switch ($i) {
 case 0:
 print "i equals 0";
 break;
 case 1:
 print "i equals 1";
 break;
 case 2:
 print "i equals 2";
 break;
}
?>
```
Las dos realizan lo mismo. Solamente difieren en la estructura de control utilizada. Una utiliza `switch`y la otra `if` anidados. 

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
    } 
    echo "</tr>\n";
    }
echo "</table>\n";
?>
</body>
</html>
```

Este fragmento de código genera una tabla html mediante el uso de variables de php y mediante dos bucles for. El primero genera las filas y el segundo que se encuentra anidado, genera las columnas. La tabla tiene un ancho del 90% y un borde de 1.

### b.

```php
<html>
<head><title>Documento 2</title></head>
<body>
<?php
if (!isset($_POST['submit'])) {
?>
 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
 Edad: <input name="age" size="2">
 <input type="submit" name="submit" value="Ir">
 </form>
<?php
 }
else {
 $age = $_POST['age'];
 if ($age >= 21) {
 echo 'Mayor de edad';
 }
 else {
 echo 'Menor de edad';
 }
}
?>
</body></html>
```

Este código realiza una validación de la edad ingresada. La condición `if (!isset($_POST['submit']))` verifica si el formulario ha sido enviado. La función `isset()` comprueba si la variable `$_POST['submit']` está definida, lo que indicaría que el formulario ha sido enviado. Si el formulario no fue enviado, entra al if y muestra el formulario en si permitiendo el ingreso de una edad. La etiqueta `<form>` especifica que el formulario enviará los datos mediante el método post a la misma página mediante la siguiente sentencia `<?php echo $_SERVER['PHP_SELF']; ?>`. Cuando el formulario fue enviado, entra en el else donde realiza una verificación de a edad, si es mayor o menor a 21 y muestra en la página el texto según corresponda.

## Ejercicio 4

```php
<?php
echo "El $flor $color \n";
include 'datos.php';
echo " El $flor $color";
?>
```

Inicialmente el codigo devolvera un error de variable indefinida (tanto para flor como para color) en el primer echo, luego del string "El". Esto es debido a que la llamada al archivo con los datos se realiza despues de este, y php no tiene hoisting, es decir, no "sabe" todavia que se usa el archivo datos.php. En cambio el segundo print funcionara correctamente, ya que se puede realizar el acceso al archivo y comprobar el valor de las variables, retornando "El clavel blanco" en consola.

## Ejercicio 5

//contador.php
```php 
<?
// Archivo para acumular el numero de visitas
$archivo = "contador.dat";
// Abrir el archivo para lectura
$abrir = fopen($archivo, "r");
// Leer el contenido del archivo
$cont = fread($abrir, filesize($archivo));
// Cerrar el archivo
fclose($abrir);
// Abrir nuevamente el archivo para escritura
$abrir = fopen($archivo, "w");
// Agregar 1 visita
$cont = $cont + 1;
// Guardar la modificación
$guardar = fwrite($abrir, $cont);
// Cerrar el archivo
fclose($abrir);
// Mostrar el total de visitas
echo "<font face='arial' size='3'>Cantidad de visitas:".$cont."</font>";
?>
```
///vistas.php 
```php
<!-- Página que va a contener al contador de visitas -->
<html>
<head></head>
<body>
<?php include("contador.php") ?>
</body>
</html>
``` 
Cada vez que se ejecuta el código html (que cuenta como una visita individual) se realiza una llamada al código contador.php. Este código abre el archivo contador.dat en modo lectura, lee el contenido y lo cierra para posteriormente abrirlo en modo escritura. Agrega una visita, es decir, suma uno al contador de visitas, guarda la modificación y cierra el archivo para luego mostrar en la página el total de visitas.

# PHP: arrays, funciones 
## Ejercicio 1

```php
//Cogigo 1

<?php
$a = array( 'color' => 'rojo',
 'sabor' => 'dulce',
 'forma' => 'redonda',
 'nombre' => 'manzana',
 4
 );
?> 

//Codigo 2

<?php
$a['color'] = 'rojo';
$a['sabor'] = 'dulce';
$a['forma'] = 'redonda';
$a['nombre'] = 'manzana';
$a[] = 4;
?> 
```

Los dos codigo realizan lo mismo. Con la ferencia que el Codigo 1 define el array mediante la forma clave=>valor, y la forma dos asignandolos individualmente los valores a un indice. 

## Ejercicio 2
```php
//Codigo 1
<?php
$matriz = array("x" => "bar", 12 => true);
echo $matriz["x"]; //bar
echo $matriz[12]; //1
?>

//Codigo 2
<?php
$matriz = array("unamatriz" => array(6 => 5, 13 => 9, "a" => 42));
echo $matriz["unamatriz"][6]; //5
echo $matriz["unamatriz"][13]; //9
echo $matriz["unamatriz"]["a"]; //42
?>

//Codigo 3
<?php
$matriz = array(5 => 1, 12 => 2);
$matriz[] = 56;
$matriz["x"] = 42; 
unset($matriz[5]); //5 quedaria indefinido. Imprimiría ""
unset($matriz); //El array deja de existir. 
?>
//No imprime nada. 
```

## Ejercicio 3
```php
//Codigo 1
<?php
$fun = getdate();
echo "Has entrado en esta pagina a las $fun[hours] horas, con $fun[minutes] minutos y $fun[seconds]
segundos, del $fun[mday]/$fun[mon]/$fun[year]";
?>

//Codigo 2
<?php
function sumar($sumando1,$sumando2){
 $suma=$sumando1+$sumando2;
 echo $sumando1."+".$sumando2."=".$suma;
}
sumar(5,6);
?>
```
El codigo 1 imprimiría: `Has entrado en esta pagina a las 21 horas, con 25 minutos y 10 segundos, del 21/5/2024 `

El codigo 2: `5+6=11`

## Ejercicio 4
```php
function comprobar_nombre_usuario($nombre_usuario){
 //compruebo que el tamaño del string sea válido.
    if (strlen($nombre_usuario)<3 || strlen($nombre_usuario)>20){
        echo $nombre_usuario . " no es válido<br>";
        return false;
    }
 //compruebo que los caracteres sean los permitidos
    $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
    for ($i=0; $i<strlen($nombre_usuario); $i++){
        if (strpos($permitidos, substr($nombre_usuario,$i,1))===false){
        echo $nombre_usuario . " no es válido<br>";
        return false;
        }
    }
    echo $nombre_usuario . " es válido<br>";
    return true;
} 
```

Esta función primero verifica que el largo del nombre este entre 3 y 20. Luego define los caracteres permitidos en una variable e itera cada caracter del nombre. 
La función strpos() se utiliza para encontrar la posición de la primera aparición de una cadena dentro de otra cadena. 
Con substr() se extrae una parte de una cadena desde un caracter de inicio y una longitud de fin. 
En cada iteracion busca que un caracter puntual del nombre del usuario pertenezca a la cadena de los permitidos. En caso que todos los caracteres pertenezcan, es decir,que se itere en toda la cadena nombre_usuario y esta tenga todos sus caracteres falsos (nunca entra al if) se devuelte que la cadena es valida. En caso que en alguna posicion de la cadena nombre_usuario se encuentre un caracter que no pertenezca a los permitidos, retorna nombre no valido. 