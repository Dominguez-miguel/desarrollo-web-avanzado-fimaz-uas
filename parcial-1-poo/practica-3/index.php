<?php

    include "Admin.php";
    include "Alumno.php";

    try {
        $admin = new Admin("Guelmi","guelmi@email.com");
        echo $admin->getNombre()." - ".$admin->getCorreo()." - ".$admin->getRol()."<br>";

        $alumno = new Alumno("Miguel","miguel@gmail.com","M1234");
        echo $alumno->getNombre()." - ".$alumno->getCorreo()." - ".$alumno->getMatricula()." - ".$alumno->getRol()."<br>";

        $error = new Admin("Guelmi","guemi@gmail.com");

    } catch(Exception $e) {
        echo "Error: ".$e->getMessage();
    }

?>