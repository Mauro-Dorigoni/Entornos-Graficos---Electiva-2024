Consulta a una base de datos: Para comenzar la comunicación con un servidor de base de datos MySQL, es necesario abrir una conexión a ese servidor. Para inicializar esta conexión, PHP ofrece la función **mysqli_connect**. Todos sus parámetros son opcionales, pero hay tres de ellos que generalmente son necesarios:
1. $hostname: especifica una direccion IP o nombre de usuario. 
2. $username: especifica el nombre de un usuario (autorizado) de MySQL
3. $password: especifica la contraseña asociada al nombre de usuario.

Una vez abierta la conexión, se debe seleccionar una base de datos para su uso, mediante la función **mysqli_select_db**, que debe pasar como parametro el nombre de la conexion (resuletante de la funcion mysqli_connect) y el nombre de la base de datos a usar.

La función mysqli_query () se utiliza para ejecutar una consulta SQL a una base de datos, y requiere como parametros el nombre de la conexion (resultante de la funcion mysqli_connect)y la consulta en forma de string.

La cláusula or die() se utiliza para capturar el ultimo error resultante de una llamada a funciones MySQL. 

La funcion mysqli_error () se puede usar para devolver el último mensaje de error para la llamada más reciente a una función de MySQLi que puede haberse ejecutado correctamente o haber fallado.

Si la función mysqli_query() es exitosa, el conjunto resultante retornado se almacena en una variable, por ejemplo
$vResult, y a continuación se puede ejecutar el siguiente código (explicarlo):

```php
<?php
while ($fila = mysqli_fetch_array($vResultado))
{
?>
<tr>
 <td><?php echo ($fila[0]); ?></td>
 <td><?php echo ($fila[1]); ?></td>
 <td><?php echo ($fila[2]); ?></td>
</tr>
<tr>
 <td colspan="5">
<?php
}
mysqli_free_result($vResultado);
mysqli_close($link);
```
El codigo anterior toma las filas recuperadas de una consulta SQL en $vResultado, y por cada una de ellas, las guarda en un array $fila. Luego, muestra las columnas 1, 2 y 3 de la tabla sql en una tabla HTML. Luego, se liberan de memoria los datos recuperados y se ciera la conexion a la Base de Datos.


