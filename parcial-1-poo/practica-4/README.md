En esta practica 4, usamos todos los conocimientos aprendidos en las 3 practicas pasadas.
Aqui, se arma un pequeño sistema donde se utilizan conceptos como encapsulamiento, herencia, polimorfismo,
validacion y manejo de excepciones. 
El sistema maneja 3 tipos de usuarios que comparten informacion basica (correo, nombre) a excepcion
del invitado, que tambien se agrega la empresa.
En el index, se registran los datos de los 3 tipos de usuarios, y si son correctos, se van a una tabla.
Asi es como quedo la tabla con los 3 usuarios validos que puso el sistema:

| Nombre | Correo                                      | Rol           | Matrícula | Empresa   |
| ------ | ------------------------------------------- | ------------- | --------- | --------- |
| Guelmi | guelmi@gmail.com                            | Administrador | —         | —         |
| Miguel | miguel@gmail.com                            | Alumno        | M1234     | —         |
| Gumiel | gumiel@email                                | Invitado      | —         | Riot      |

De lo contrario, si el correo es invalido, el sistema manda un mensaje controlado, diciendo el
problema exacto.
