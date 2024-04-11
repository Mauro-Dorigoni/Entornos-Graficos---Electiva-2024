**EJERCICIO 1: Responder el cuestionario**

**1.1-**
CSS son las siglas de Cascade Style Sheet que traducido significa hojas de estilo en cascada. Las hojas de estilo es una tecnología que nos permite controlar la apariencia de una página web. CSS describe como los elementos dispuestos en la página son presentados al usuario. CSS es un gran avance que complementa el HTML y la Web en general. Está definido en la Especificaciones CSS1, CSS2 y CSS3 del World Wide Web Consortium (W3C), es un estándar aceptado por toda la industria relacionada con la Web, o por lo menos, gran parte de navegadores. Entonces las Hojas de Estilo en Cascada (Cascading Style Sheets), es un mecanismo simple que describe cómo se va a mostrar un documento en la pantalla, o cómo se va a imprimir, o incluso cómo va a ser pronunciada la información presente en ese documento a través de un dispositivo de lectura. Esta forma de descripción de estilos ofrece a los desarrolladores el control total sobre estilo y formato de sus documentos

**1.2-**
La regla tiene dos partes: un selector y la declaración. A su vez la declaración está compuesta por una propiedad y el valor que se le asigne. El selector funciona como enlace entre el documento y el estilo, especificando los elementos que se van a ver afectados por esa declaración. La declaración es la parte de la regla que establece cuál será el efecto. Genericamente:
selector {propiedad:valor;}

**1.3-**
Las tres formas más conocidas de dar estilo a un documento son las siguientes:

- Utilizando una hoja de estilo externa que estará vinculada a un documento a través del elemento `<link>`, el cual debe ir situado en la sección `<head>`
- Utilizando el elemento `<style>` en el interior del documento al que se le quiere dar estilo, y que generalmente se situaría en la sección `<head>`. De esta forma los estilos serán reconocidos antes de que la página se cargue por completo
- Utilizando estilos directamente sobre aquellos elementos que lo permiten a través del atributo `<style>` dentro de `<body>`. Pero este tipo de estilo al mezclarse el contenido con la presentación

**1.4-**
Los tipos de selectores mas comunes en CSS son:
1. Selector Universal: el asterisco (*) es el selector universal en CSS. De forma automática, el asterisco selecciona todos los elementos en un documento.
  Ejemplo:
    *{color:orange;} Todos los elementos de una pagina HTML se veran anaranjados.

2. Selector de Tipo: un selector de tipo permite seleccionar todos los elementos en HTML que tienen un nombre de nodo común.
  Ejemplo: 
    a {color: red;} Todos los enlaces en una pagina HTML se veran en rojo.

3. Selector de Clase: los selectores de clase son herramientas que, como su nombre lo indica, permiten seleccionar todos los elementos que tienen un mismo nombre de clase.
  Ejemplo:
    ```html 
    <h1 class="clase">Ejemplo</h1>
    ```
    .clase{color=blue;} Aplicara color azul a la clase "clase" de tipo h1

4. Selector de ID: un selector de ID está diseñado para seleccionar elementos con base en su atributo de ID.
  Ejemplo:
    ```html 
    <h1 id="iDejemplo">EjemploID</h1>
    ```
    #iDejemplo{color:black;} Aplicara color negro al elemento de id "iDejemolo"

5. Selector de Atributo: los selectores de atributo están hechos para seleccionar todos los elementos que correspondan a un atributo específico o a un valor de atributo definido.
  Ejemplo:
    a[href*="entornos"]{color:orange;} Pintara todos los enlaces que contengan "entornos" en su url de naranja

6. Selector de pseudo-clase: un selector de pseudo-clase permite aplicar CSS a una selección de elementos o a elementos que se encuentran en un estado específico.
  Ejemplo:
    a:visited{color:red;} Los enlaces que hayan sido visitados (estado visited) se veran en rojo.

**1.5-**
Una pseudoclase CSS es una palabra clave que se añade a los selectores y que especifica un estado especial del elemento seleccionado. En el caso de los enlaces, las mas comunes son visited (indica si el usuario ya ha ingresado al enlace) y hover (si el usuario tiene el cursor sobre el vinculo)

**1.6-**
La herencia es el proceso por el cual algunas propiedades CSS aplicadas a una etiqueta se pasan a las etiquetas anidadas. Si un elemento no tiene un valor en cascada para una determinada propiedad, puede heredar uno de un elemento antecesor. Es común aplicar la propiedad font-family al elemento <body>. Todas las etiquetas descendientes de la etiqueta <body>, es decir, las que están dentro de la etiqueta <body> heredarán esta fuente y no es necesario aplicarla explícitamente a cada elemento de la página. Cualquier etiqueta dentro de otra etiqueta es descendiente de esa etiqueta. por ejemplo, una etiqueta <p> dentro de la etiqueta <body> es descendiente de <body>, mientras que la etiqueta <body> es un ancestro de la etiqueta <p>. Hay algunas propiedades en CSS que se heredan y otras que no.

**1.7-**
 La cascada es el algoritmo para resolver conflictos donde se aplican múltiples reglas CSS a un elemento HTML. El algoritmo en cascada se divide en 4 etapas distintas:
 1. Posición y orden de aparición: el orden en el que aparecen las reglas CSS. La cascada tiene en cuenta el orden en que aparecen las reglas CSS y cómo aparecen mientras calcula la resolución de conflictos. Si se tiene un <link> que incluye CSS en la parte superior de una página HTML y se tiene otro <link> que incluye un CSS en la parte inferior de la página, el <link> inferior tendrá la mayor especificidad. Lo mismo ocurre con los elementos de <style>. Se vuelven más específicos cuanto más abajo están en la página.
 2. Especifidad: la especificidad es un algoritmo que determina qué selector de CSS es el más específico, utilizando un sistema de ponderación o puntuación para realizar esos cálculos. Al hacer una regla más específica, puede hacer que se aplique incluso si algún otro CSS que coincida con el selector aparece más adelante en el CSS. El CSS dirigido a una clase en un elemento hará que la regla sea más específica y, por lo tanto, se considerará más importante de aplicar que el CSS dirigido solamente al elemento.
 3. Origen: el CSS escrito no es el único CSS que se aplica a una página. La cascada tiene en cuenta el origen del CSS. Este origen incluye la hoja de estilo interna del navegador, los estilos agregados por las extensiones del navegador o el sistema operativo y el CSS creado. El orden de especificidad de estos orígenes, desde el menos específico al más específico, son los siguientes:
    1. Estilos base de agente de usuario
    2. Estilos de usuarios locales
    3. CSS creado
    4. Los !important creados
    5. Estilos de usuarios locales !important
    6. Agente de usuario !important
 4. Importancia: no todas las reglas de CSS se calculan de la misma manera entre sí, ni se les da la misma especificidad entre sí. El orden de importancia, de menor a mayor importancia, es el siguiente:
    1. Tipo de regla normal, como font-size , background o color
    2. Tipo de regla de animation
    3. Tipo de regla de !important
    4. Tipo de regla de transition

**EJERCICIO 2**

p#normal {
font-family: arial, Helvetica;
font-size: 11px;
font-weight: bold;
}
\*#destacado {
border-style: solid;
border-color: blue;
border-width: 2px;
}
#distinto {
background-color: #9EC7EB;
color: red;
}

```html
<p id="normal">Este es un párrafo</p>
<p id="destacado">Este es otro párrafo</p>
<table id="destacado">
  <tr>
    <td>Esta es una tabla</td>
  </tr>
</table>
<p id="distinto">Este es el último párrafo</p>
```

p#normal => este selector determina que el estilo dado dentro de la declaración será utilizado por las etiquetas `<p>` cuyo id es “normal”. Lo que hace este bloque es aplicar una fuente Arial o Helvetica, tamaño de fuente de 11px y negrita. Afecta solo a la primera etiqueta `<p>` del código HTML.
\*#destacado => esto determina que se afectan todas aquellas etiquetas cuyo id sea “destacado”. Aplica un borde sólido de color azul con un ancho de 2px. Afecta a la segunda etiqueta `<p>` y a la etiqueta `<table>` del código HTML.
#distinto => afecta a los elementos cuyo id sea “distinto”, aplicando un color de fondo #9EC7EB (azul claro, expresado en hexadecimal) y un color de texto rojo. Afecta solo a la última etiqueta `<p>` del código HTML.

**EJERCICIO 3**

```css
p.quitar {
  color: red;
}
\*.desarrollo {
  font-size: 8px;
}
.importante {
  font-size: 20px;
}
```

```html
<p class="desarrollo">
  En este primer párrafo trataremos lo siguiente:
  <br />xxxxxxxxxxxxxxxxxxxxxxxxx
</p>
<p class="quitar">
  Este párrafo debe ser quitado de la obra…
  <br />xxxxxxxxxxxxxxxxxxxxxxxxx
</p>
<p>
  En este otro párrafo trataremos otro tema:<br />
  xxxxxxxxxxxxxxxxxxxxxxxxx
</p>
<p class="importante">
  Y este es el párrafo más importante de la obra…
  <br />xxxxxxxxxxxxxxxxxxxxxxxxx
</p>
<h1 class="quitar">Este encabezado también debe ser quitado de la obra</h1>
<p class="quitar importante">Se pueden aplicar varias clases a la vez</p>
```

p.quitar => el estilo aplicado en este selector se verá reflejado en las etiquetas `<p>` que posean una clase denominada “quitar”, aplicando a las mismas el color de texto rojo. En este ejemplo se aplicará a la etiqueta que encierra el párrafo “Este párrafo debe ser quitado de la obra…”, la etiqueta `<br />` y el párrafo “xxxxxxxxxxxxxxxxxxxxxxxxx” y también a la última etiqueta `<p>` que tiene la clase quitar y la clase importante.
\*.desarrollo => esto determina que se afectan todas aquellas etiquetas que posean la clase “destacado”. Aplica un tamaño de fuente de 8px y afecta solo a la primer etiqueta `<p>` que encierra el párrafo “En este primer párrafo trataremos lo siguiente:”, la etiqueta `<br />` y el párrafo “xxxxxxxxxxxxxxxxxxxxxxxxx”
.importante => afecta a los elementos con la clase importante. Aplica un tamaño de fuente de 20px. En el ejemplo se aplica a la última etiqueta `<p>`.

**EJERCICIO 4 (continuar)**
La primera declaración se aplica a todo el documento HTML por lo que ambos fragmentos de código van a ser de color verde, si en las etiquetas que continúan no se especifica ningún otro color. En este ejemplo, lo único que se mantiene verde son las tablas de ambos códigos.
La primera diferencia que podemos encontrar es en el body, el segundo código tiene la clase “contenido” por lo que a todo el body se le aplicara un tamaño de fuente de 14px y estarán las letras en negrita.
A diferencia del segundo, el primero solo tiene esta clase en la primera etiqueta `<p>` por lo que se le aplicará al contenido de esta el tamaño de fuente de 14px, pero las letras estarán normales ya que tiene definido un estilo propio en el HTML. A esta etiqueta también se le dio un estilo, que por cascada se aplica luego del estilo aplicado a todo el documento por lo que la letra no será verde, sino que será negra y además la familia de la fuente será arial helvética.
La etiqueta `<p>` del segundo código tendrá la fuente en negrita debido a la clase “contenido” del body pero luego por la especificidad del selector `<p>` aplicará todos los estilos especificados en el selector p. Y por cascada, no toma el color verde que se le da al documento completo, si no que toma el negro del propio selector p.
