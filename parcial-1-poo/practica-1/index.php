<?php
    include "Usuario.php";

    $usuario1 = new Usuario("Miguel Dominguez", "miguel@gmail.com");

    echo $usuario1->getNombre();
    echo $usuario1->getCorreo();
?>
