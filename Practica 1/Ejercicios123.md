**EJERCICIO 1: Responder el siguiente cuestionario**
**1.** ¿Qué es HTML, cuando fue creado, cuáles fueron las distintas versiones y cuál es la última?
HTML (HyperText Markup Language) es el lenguaje de marcado principal de la World Wide Web (WWW). Es un lenguaje de marcas de hipertextos, cuya función es el desarrollo de páginas web. Define una estructura básica y un código (denominado código HTML) para la definición de contenido de una página web, como texto, imágenes, videos, juegos, entre otros. Es actualmente el estándar que se impuso en la visualización de paginas web y es el que todos los navegadores actuales adoptaron.
El origen de HTML se remonta a 1980, cuando el físico Tim Berners-Lee, trabajador del CERN (Organización Europea para la Investigación Nuclear) propuso un nuevo sistema de "hipertexto" para compartir documentos.
Los sistemas de "hipertexto" habían sido desarrollados algunos años antes con la finalidad de permitir a los usuarios acceder a la información relacionada con los documentos electrónicos. Tim Berners-Lee presentó su sistema de “hipertexto”, una vez finalizado y depurado, a una convocatoria organizada para desarrollar un sistema de "hipertexto" para Internet. Después de trabajar junto al ingeniero de sistemas Robert Cailliau sobre su proyecto inicial, ambos, crearon una propuesta conocida como World Wide Web o W3.
El primer documento formal con la descripción de HTML se publicó en 1991 bajo el nombre "HTML Tags". Durante sus primeros cinco años, HTML pasó por una serie de revisiones y experimentó una serie de extensiones, alojadas en el CERN (Organización Europea para la Investigación Nuclear), y luego en el IETF (Internet Engineering Task Force). Con la creación del W3C, el desarrollo de HTML cambió de lugar de nuevo. Un primer intento frustrado de extender el HTML en 1995 conocido como HTML 3.0 dio paso a un enfoque más pragmático conocido como HTML 3.2, que se completó en 1997. HTML 4.01 siguió rápidamente más tarde ese mismo año.
Al año siguiente la W3C dejo de desarrollar HTML para concentrarse en su equivalente XHTML que se baso en XML. Con la reformulación del HTML 4.01, se creo el XHTML 1.0 en el 2000. Paralelamente trabajó con un lenguaje llamado XHTML 2.0 que no era compatible con los dos mencionados anteriormente. Mientras se detuvo el desarrollo de HTML, parte de la API para HTML desarrollada por los proveedores de navegadores se especificaron y publicaron bajo el nombre DOM Level 1 (en 1998) y DOM Level 2 Core y DOM Level 2 HTML (comenzando en 2000 y culminando en 2003). En 2003 se renovó el interés por el HTML con la publicación de XForms. Luego de algunos años donde fueron rechazadas propuestas debido a que entraban en conflicto con la dirección que el desarrollo web había tomado en ese entonces (continuar con el XML) y el intereses de empresas de renombre como Apple, Mozilla y Opera, en 2006, el W3C indicó su interés en participar en el desarrollo de HTML 5.0 después de todo, y en 2007 formó un grupo de trabajo autorizado para trabajar con WHATWG en el desarrollo de la especificación HTML. Apple, Mozilla y Opera permitieron al W3C publicar la especificación bajo los derechos de autor del W3C, manteniendo una versión con la licencia menos restrictiva en el sitio WHATWG. HTML 5.0 se siguió desarrollando durante años y es la versión que se usa actualmente en el desarrollo web.

**2.** ¿Cuáles son los principios básicos que el W3C recomienda seguir para la creación de documentos con HTML?
El principal principio que recomienda seguir el W3C es el de Accesibilidad, la Iniciativa de Accesibilidad Web (WAI) del World Wide Web Consortium (W3C) define recomendaciones a propósito de la facilidad de acceso a las páginas web. Las directrices WCAG presentan cómo se puede diseñar la oferta en la web para que sea accesible a todos los usuarios, independientemente de sus capacidades físicas, mentales o motoras.
Las Pautas de accesibilidad al contenido web (WCAG) 2.1 cubren una amplia gama de recomendaciones para hacer que el contenido web sea más accesible. Seguir estas pautas hará que el contenido sea más accesible para una gama más amplia de personas con discapacidades, incluidas adaptaciones para ceguera y baja visión, sordera y pérdida auditiva, movimiento limitado, entre otras limitaciones que las personas puedan presentar. WCAG 2.1 amplía las Pautas de accesibilidad al contenido web 2.0 [WCAG20], que se publicaron como Recomendación del W3C en diciembre de 2008.
Algunos criterios son:
 Orientación: El contenido no restringe su visualización y funcionamiento a una única orientación de pantalla, como vertical u horizontal, a menos que una orientación de pantalla específica sea esencial.
 Distinguible: Facilite a los usuarios ver y escuchar contenido, incluida la separación del primer plano del fondo.
 Operable: Los componentes de la interfaz de usuario y la navegación deben estar operativos.
 Teclado accesible: Haga que todas las funciones estén disponibles desde un teclado

**3.** En las Especificaciones de HTML, ¿cuándo un elemento o atributo se considera desaprobado? ¿y obsoleto?
Un elemento o atributo desaprobado es aquel que ha quedado anticuado por la presencia de estructuras nuevas. Los elementos desaprobados se definen en el manual de referencia en los lugares apropiados, pero claramente marcados como desaprobados.
Un elemento o atributo obsoleto es aquél para el cual no hay garantía de soporte por parte de un agente de usuario. Los elementos obsoletos han dejado de estar definidos en la especificación, pero se enumeran por motivos históricos en la sección de cambios del manual de referencia.
Los elementos desaprobados pueden declararse obsoletos en versiones futuras de HTML.
Los agentes de usuario deberían seguir dando soporte a los elementos desaprobados por razones de compatibilidad con versiones anteriores.
Las definiciones de elementos y atributos indican claramente cuáles son desaprobados.

**4.** ¿Qué es el DTD y cuáles son los posibles DTDs contemplados en la especificación de HTML 4.01?
Document Type Definition (DTD) indica qué lenguaje de código se utiliza en la página o en el documento HTML. Esto se aplica, por ejemplo, a los archivos HTML, XHTML, SVG, MathML o XML. La tarea de DOCTYPE html es explicar a los programadores y navegadores, a primera vista, de qué Document Type Definition (DTD) se trata y cómo debe renderizarse la web. Como norma, no es obligatorio incluir la etiqueta de DOCTYPE html, por tanto, también puede omitirse en los documentos HTML. No obstante, el indicar del tipo de documento se considera una práctica estandarizada, aunque no oficial. Al revisar el documento HTML, si falta la etiqueta, se detectará automáticamente el error. Si el navegador no puede reconocer con certeza la gramática y la sintaxis utilizada, puede que se produzcan errores de visualización e incluso que la funcionalidad de la web se vea afectada.
Especialmente importante: DOCTYPE no solo debe aparecer al principio del código fuente de un proyecto web. Toda subpágina independiente en el documento HTML asociado debe tener su correspondiente etiqueta.
Según el rigor de HTML 4.01 utilizado podemos declararla como:
Declaración transitoria:

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">

Declaración estricta:

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">

**5.** ¿Qué son los metadatos y cómo se especifican en HTML?
Los metadatos son datos que proporcionan información sobre otros datos. En el contexto de la web, los metadatos en HTML se utilizan para describir la estructura, contenido y comportamiento del documento HTML, así como para proporcionar información sobre su autoría, codificación, palabras clave relevantes, y más.
Los metadatos en HTML se especifican dentro del elemento <head> del documento HTML. Algunos metadatos comunes son
-Título del documento:
El título del documento se define utilizando el elemento <title> dentro del <head>.
-Codificación de caracteres:
La codificación de caracteres se especifica utilizando el elemento <meta> con el atributo charset.
-Descripción del documento:
La descripción del documento se especifica utilizando el elemento <meta> con el atributo name establecido en "description" y el atributo content que contiene la descripción.
-Palabras clave (Keywords):
Las palabras clave se especifican utilizando el elemento <meta> con el atributo name establecido en "keywords" y el atributo content que contiene las palabras clave separadas por comas.
-Viewport:
La configuración de la ventana gráfica se especifica utilizando el elemento <meta> con el atributo name establecido en "viewport" y el atributo content que contiene las configuraciones de visualización.

**BIBLIOGRAFÍA:**

- Material de la cátedra
- http://www.aeemt.com/contenidos_socios/Informatica/Informac_Informat_Tecnolog/AMV_AGI_AEEMT_HTML_Historia.pdf
- https://www.ionos.es/digitalguide/paginas-web/desarrollo-web/directrices-para-la-accesibilidad-web/
- https://www.w3.org/TR/WCAG21/#new-features-in-wcag-2-1

**EJERCICIO 2: Analizar los siguientes segmentos de código indicando en qué sección del documento HTML se colocan, cuál es el efecto que producen y señalar cada uno de los elementos, etiquetas, y atributos (nombre y valor), aclarando si es obligatorio.**

**2.a)**

```html
<!-- Código controlado el día 12/08/2009 -->
```

Este es un comentario. Este elemento no requiere etiquetas de apertura y cierre, y su sintaxis es <!-- comentario -->. Los comentarios pueden ir en cualquier parte del código, para realizar aclaraciones pertinentes a la hora de desarrollar una página web. No tiene efecto en la visualización de la misma.

**2.b)**

```html
<div id="”bloque1”">Contenido del bloque1</div>
```

Se utiliza para definir una división, y es un contenedor utilizado para agrupar contenido de modo que se pueda dar estilo fácilmente usando los atributos class o id. El atributo id="bloque1" permite identificar de forma única este elemento en el documento, y es obligatorio si se necesita acceder a este elemento mediante JavaScript o CSS. El contenido de este ejemplo es "Contenido del bloque1" pero dentro de una etiqueta <div> se pueden anidar todo tipo de etiquetas. Estas etiquetas pueden ir en cualquier parte del <body> del documento html.

**2.c)**

```html
<img
  src=""
  alt="lugar imagen"
  id="im1"
  name="im1"
  width="32"
  height="32"
  longdesc="detalles.htm"
/>
```

El elemento `<img>` que se utiliza para insertar una imagen en la página. El atributo src especifica la ubicación de la imagen, el atributo alt proporciona un texto descriptivo para la imagen, siendo esto esencial para la accesibilidad. Los atributos id, name, width, height y longdesc son opcionales y se utilizan para proporcionar identificación y características adicionales a la imagen. Los atributos width y height pueden ponerse fuera del archivo html en una hoja de estilos css junto a otros estilos. Generalmente están ubicadas dentro de un contenedor, aunque también es común ver una imagen dentro de una etiqueta <a> utilizada como “botón” como por ejemplo, los logos de las páginas (normalmente ubicados en la parte superior izquierda) redirigen al usuario a la parte del inicio.

**2.d)**

```html
<meta name="keywords" lang="es" content="casa, compra, venta, alquiler " /><meta
  http-equiv="expires"
  content="16-Sep-2019 7:49 PM"
/>
```

Estos son elementos `<meta>` se utilizan para proporcionar metadatos sobre el documento HTML. No son visibles para el usuario, pero si para el motor del navegador. El atributo name proporciona contexto importante para la página (para este caso, lang es el idioma, content con valores asociados con name (en este caso, las palabras clave). La etiqueta `<meta>` debe usarse siempre dentro del elemento `<head>`

**2.e)**

```html
<a
  href="http://www.e-style.com.ar/resumen.html"
  type="text/html"
  hreflang="es"
  charset="utf-8"
  rel="help"
  >Resumen HTML
</a>
```

Un elemento `<a>` se usa para insertar un hipervínculo a otra página web. Estos generalmente aparecen en azul (cuando el usuario todavía no lo visita), violeta (si el usuario ya lo ha visitado) o en rojo (si está activo). En este caso se trata de un enlace a un resumen html que el usuario podrá visitar al hacer click sobre el texto “Resumen HTML”. El atributo href especifica la url de la página, type especifica que tipo de media es (texto html en este caso), hreflang el lenguaje del documento enlazado, charset el juego de caracteres usado, rel especifica la relación entre la página actual y la página enlazada. El texto dentro de `<a>` será el texto donde se encontrará el hipervínculo. Los hipervínculos pueden usarse dentro de una lista o un bloque, y pueden conducir a una ubicación externa o interna dentro de la misma página.

**2.f)**

```html
<table width="200" summary="Datos correspondientes al ejercicio vencido">
  <caption align="top">
    Título
  </caption>
  <tr>
    <th scope="col">&nbsp;</th>
    <th scope="col">A</th>
    <th scope="col">B</th>
    <th scope="col">C</th>
  </tr>
  <tr>
    <th scope="row">1º</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th scope="row">2º</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
```

El elemento `<table>` se utiliza para crear una tabla en la página. Cada celda de la tabla será definida por etiquetas `<td>` y `</td>` (td abreviatura para dato de tabla) y todo entre ellas será el contenido de la tabla. Cada fila comienza con `<tr>` y finaliza con `</tr>`. Si se quiere que una celda sea título de la tabla, se usa `<th>` en vez de `<td>`.
El atributo width especifica el ancho de la tabla en píxeles o porcentaje, y el atributo summary proporciona una descripción de la tabla para usuarios con discapacidad visual. Dentro de la tabla, hay elementos `<caption>` que se utilizan para proporcionar un título a la tabla. El atributo scope especifica si el título es usado para la fila o la columna, y no tiene incidencia visual en la página, solo contexto de accesibilidad.

**EJERCICIO 3: En cada caso, explicar las diferencias entre los segmentos de código y sus visualizaciones:**

**3.a)**

```html
<a href="http://www.google.com.ar">Click aquí para ir a Google</a>
<a href="http://www.google.com.ar" target="_blank"
  >Click aquí para ir a Google</a
>
<a
  href="http://www. google.com.ar"
  type="text/html"
  hreflang="es"
  charset="utf-8"
  rel="help"
>
  <a href="#">Click aquí para ir a Google</a>
  <a href="#arriba">Click aquí para volver arriba</a>
  <a name="arriba" id="arriba"></a
></a>
```

La función de la primera etiqueta es redireccionar al usuario a la página de google en la misma ventana.
La segunda tiene la misma función con la diferencia que el atributo target="\_blank" hace que la redirección sea en una nueva ventana permitiendo que al usuario no se le cierre la página actual por la que navega.
En el tercero, la etiqueta type especifica el tipo de recurso enlazado, en este caso un documento de texto html, hreflang="es" indica que una página debe ser mostrada a los usuarios de un país o idioma específico, el atributo charset especifica la codificación de caracteres utilizada, y el atributo rel define la relación entre la página actual y la enlazada, indicando que ofrece ayuda con la palabra “help”.
La cuarta etiqueta no está referenciada a ningún url ni sección de la página por lo que solo redireccionará a la parte de la página que se haya elegido por defecto cuando no se especifica un “end point”.
La quinta permitiría volver hacía arriba cuando uno scrollea hacia abajo, mientras que la última solo es una etiqueta que especifica los atributos name e id sin redirección.

**3.b)**

```html
<p>
  <img src="im1.jpg" alt="imagen1" /><a href="http://www.google.com.ar"
    >Click aquí</a
  >
</p>
<p>
  <a href="http://www.google.com.ar"><img src="im1.jpg" alt="imagen1" /></a>
  Click aquí
</p>
<p>
  <a href="http://www.google.com.ar"
    ><img
      src="im1.jpg"
      alt="ima
gen1"
    />Click aquí</a
  >
</p>
<p>
  <a href="http://www.google.com.ar"><img src="im1.jpg" alt="imagen1" /></a>
  <a href="http://www.google.com.ar">Click aquí</a>
</p>
```

En el primer caso, se trata de una imagen seguida de un hipervínculo. El enlace solo se ve sobre el texto “Click aquí” (que se verá en azul)
En el segundo caso, es un hipervínculo dentro de la propia imagen, con el texto “Click aquí”. Solo se podrá ingresar al enlace haciendo click sobre la imagen.
En el tercer caso se trata de un hipervínculo dentro de una imagen y del texto “Click aquí. El usuario será redireccionado al mismo sitio tanto si hace click sobre la imagen o sobre el texto.
En el cuarto caso se trata de un hipervínculo dentro de la imagen y seguido de un hipervínculo con el texto “Click aquí”. Son 2 etiquetas `<a>` distintas, con el mismo enlace en ambas. El usuario será redireccionado al mismo sitio tanto si hace click sobre la imagen o sobre el texto.

**3.c)**
El primer ejemplo es una lista desordenada ( `<ul>` ) con sus list items ( `<li>` ), a diferencia del segundo que es una lista ordenada ( `<ol>` ) con sus items. La tercera son tres listas ordenadas cada una con un ítem, y el atributo value da el valor del ítem, si agregamos más ítems abajo continúa la lista a partir de ese valor. Blockquote permite insertar citas en forma de bloques de contenido, a diferencia de las otras no es interpretada por el navegador como una lista a pesar de que parezca visualmente, la etiqueta p encierra un parrafo.

**3.d)**

```html
<table border="1" width="300">
  <tr>
    <th>Columna 1</th>
    <th>Columna 2</th>
  </tr>
  <tr>
    <td>Celda 1</td>
    <td>Celda 2</td>
  </tr>
  <tr>
    <td>Celda 3</td>
    <td>Celda 4</td>
  </tr>
</table>

<table border="1" width="300">
  <tr>
    <td>
      <div align="center"><strong>Columna1</strong></div>
    </td>
    <td>
      <div align="center"><strong>Columna 2</strong></div>
    </td>
  </tr>
  <tr>
    <td>Celda 1</td>
    <td>Celda 2</td>
  </tr>
  <tr>
    <td>Celda 3</td>
    <td>Celda 4</td>
  </tr>
</table>
```

Estos 2 segmentos de códigos se visualizan iguales para el usuario. El primero utiliza las etiquetas `<th>` para los títulos (headers) Columna 1 y Columna 2 de las columnas. Por naturaleza de la etiqueta, el texto se verá en negrita. Por otra parte, el segundo trozo de código pone los títulos a las columnas utilizando las etiquetas `<td>` de celdas normales, y dentro usa bloques `<div>` donde se especifica la alineación y el texto en negrita.

**3.e)**

```html
<table width="200">
  <caption>
    Título
  </caption>
  <tr>
    <td bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
  </tr>
</table>
--------------------------------
<table width="200">
  <tr>
    <td colspan="3"><div align="center">Título</div></td>
  </tr>
  <tr>
    <td bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
  </tr>
</table>
```

La diferencia en estos dos códigos es la forma en la que está puesto el título. El primer ejemplo está puesto con la etiqueta `<caption>` que se utiliza para agregar un título o una descripción a una tabla. En el segundo ejemplo, crea el título con una fila y una celda con atributo de colspan de 3 que permite agrupar celdas consecutivas en una fila y adentro tiene un `<div>` contenedor que alinea el texto en el centro.

**3.f)**

```html
<table width="200">
  <tr>
    <td colspan="3"><div align="center">Título</div></td>
  </tr>
  <tr>
    <td rowspan="2" bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
  </tr>
</table>

<table width="200">
  <tr>
    <td colspan="3"><div align="center">Título</div></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
    <td bgcolor="#dddddd">&nbsp;</td>
  </tr>
</table>
```

El atributo colspan de una celda refiere a cuantas columnas abarca la celda referenciada, y el rowspan refiere a cuántas filas abarca. Podría pensarse como el “combinar celdas” de toda la vida. Por lo tanto, las únicas diferencias tangibles entre el primer segmento de código y el segundo es que en el primero se visualiza una tabla de 3 columnas y 2 filas donde la primera celda abarca 2 filas (es decir, es una combinación de filas 1 y 2 de la columna 1), mientras que en el segundo trozo de código se visualiza una tabla de 3 columnas y 2 filas donde la primera celda abarca 2 columnas (es decir, una combinación de columnas 1 y 2 sobre la fila 1).

**3.g)**

```html
<table width="200" border="1">
  <tr>
    <td colspan="3"><div align="center">Título</div></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
  </tr>
</table>
------------------------------
<table width="200" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><div align="center">Título</div></td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
  </tr>
</table>
```

La primera tabla no tiene ni cellpadding, ni cellspacing en la tabla, mientras que en el segundo si. El cellpadding determina el espacio entre los bordes de la celda y el contenido de la misma y el cellspacing especifica el espacio entre las diferentes celdas.

**3.h)**

```html
<form id="form1" name="form1" action="procesar.php" method="post" target="_blank">

<fieldset>
<legend>LOGIN</legend>
Usuario: <input type="text" id="usu1" name="usu1" value="xxx" /><br />
Clave: <input type="password" id="clave1" name="clave1" value="xxx" />
</fieldset>
<input type="submit" id="boton1" name="boton1" value="Enviar" />
</form>

<form id="form2" name="form2" action="" method="get" target="_blank">
LOGIN<br />
<label>Usuario: <input type="text" id="usu2" name="usu2" /></label><br />
<label>Clave: <input type="text" id="clave2" name="clave2" /></label><br />
<input type="submit" id="boton2" name="boton2" value="Enviar" />
</form>

<form id="form3" name="form3" action="mailto:xx@xx.com” enctype=text/plain method="post" target="_blank">
<fieldset>
<legend>LOGIN</legend>
Usuario: <input type="text" id="usu3" name="usu3" /><br />
Clave: <input type="password" id="clave3" name="clave3" />
</fieldset>
<input type="reset" id="boton3" name="boton3" value="Enviar" />
</form>
```

Visualmente, los 3 formularios son muy parecidos para el usuario. La única diferencia es que en el primero el usuario y contraseña ya se encuentran llenados. En cuanto a código, el primer formulario usa en el atributo action enviar los datos completados a un documento .php con el method post (envía los datos como una transacción HTTP)
El segundo formulario no realiza ninguna acción con los datos completados, pero los envia con el método get (en forma de URL)
El tercer formulario realiza la acción de enviar los datos obtenidos por mail a la dirección xx@xx.com.

**3.i)**

```html
<label
  >Botón 1
  <button type="button" name="boton1" id="boton1">
    <img src="logo.jpg" alt="Botón con imagen " width="30" height="20" /><br />
    <b>CLICK AQUÍ</b>
  </button></label
>

<label
  >Botón 2
  <input type="button" name="boton2" id="boton2" value="CLICK AQUÍ" />
</label>
```

El primer segmento de código muestra un botón con una imagen y el texto “click aquí” debajo de ella dentro del mismo, mientras que el segundo trozo representa solamente un botón con el valor “Click aqui”

**3.k)**

```html
<select name="lista">
  <optgroup label="Caso 1">
    <option>Mayo</option>
    <option>Junio</option>
  </optgroup>
  <optgroup label="Caso 2">
    <option>Mayo</option>
    <option>Junio</option>
  </optgroup>
</select>

<select name="lista[]" multiple="multiple">
  <optgroup label=" Caso 1">
    <option>Mayo</option>
    <option>Junio</option>
  </optgroup>
  <optgroup label=" Caso 2">
    <option>Mayo</option>
    <option>Junio</option>
  </optgroup>
</select>
```

La etiqueta `<select>` indica un menú de selección. Visualmente, el primer segmento de código muestra un dropdown menu donde solamente se puede seleccionar una opción. El segundo segmento de código muestra una lista donde se puede seleccionar más de una opción a la vez. La etiqueta `<optgroup>` se usa dentro del `<select>` para agrupar opciones relacionadas.
