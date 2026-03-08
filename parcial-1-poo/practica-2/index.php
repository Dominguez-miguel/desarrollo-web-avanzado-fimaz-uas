<?php
    include "Admin.php";

    $admin1 = new Admin("Miguel Dominguez", "miguel@gmail.com");

    echo $admin1->getNombre();
    echo $admin1->getCorreo();
    echo $admin1->getRol();
?>