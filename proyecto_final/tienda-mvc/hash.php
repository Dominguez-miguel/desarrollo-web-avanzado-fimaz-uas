<!-- /* Este fragmento de código PHP genera una contraseña cifrada para 
la cadena 'admin123' utilizando la función `password_hash` con el algoritmo `PASSWORD_DEFAULT`. La 
contraseña cifrada se mostrará en pantalla. Esta es una práctica común para almacenar contraseñas de forma segura en una base de datos. */ -->
<?php

    echo password_hash('admin123',PASSWORD_DEFAULT);
?>