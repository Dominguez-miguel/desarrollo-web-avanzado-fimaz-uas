En esta practica estamos aprendiendo a usar la herencia en php, utilizando POO.
Utilizamos la misma clase Usuario que utilizamos anteriormente, pero esta vez, 
creamos un archivo llamado Admin.php donde extendemos la clase Usuario, para que, en el index,
se pueda utilizar el nuevo get que creamos (getRol) osea, Administrador.

La diferencia entre el archivo Usuario y Admin es realmente poca. En ambos se crean clases para luego,
ser utilizadas en el index, con la diferencia que en Admin se retorna el valor "Administrador" 
ahi mismo, mientras que el Usuario, se le da el valor en el index al instanciar la clase.
