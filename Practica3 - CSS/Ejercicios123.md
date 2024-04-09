**EJERCICIO 1: Responder el cuestionario**
**1.**
CSS son las siglas de Cascade Style Sheet que traducido significa hojas de estilo en cascada. Las hojas de estilo es una tecnología que nos permite controlar la apariencia de una página web. CSS describe como los elementos dispuestos en la página son presentados al usuario. CSS es un gran avance que complementa el HTML y la Web en general. Está definido en la Especificaciones CSS1, CSS2 y CSS3 del World Wide Web Consortium (W3C), es un estándar aceptado por toda la industria relacionada con la Web, o por lo menos, gran parte de navegadores. Entonces las Hojas de Estilo en Cascada (Cascading Style Sheets), es un mecanismo simple que describe cómo se va a mostrar un documento en la pantalla, o cómo se va a imprimir, o incluso cómo va a ser pronunciada la información presente en ese documento a través de un dispositivo de lectura. Esta forma de descripción de estilos ofrece a los desarrolladores el control total sobre estilo y formato de sus documentos
**2.**
**3.**
Las tres formas más conocidas de dar estilo a un documento son las siguientes:

- Utilizando una hoja de estilo externa que estará vinculada a un documento a través del elemento `<link>`, el cual debe ir situado en la sección `<head>`
- Utilizando el elemento `<style>` en el interior del documento al que se le quiere dar estilo, y que generalmente se situaría en la sección `<head>`. De esta forma los estilos serán reconocidos antes de que la página se cargue por completo
- Utilizando estilos directamente sobre aquellos elementos que lo permiten a través del atributo `<style>` dentro de `<body>`. Pero este tipo de estilo al mezclarse el contenido con la presentación

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
