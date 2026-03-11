<?php

    require_once "Admin.php";
    require_once "Alumno.php";

    $usuarios = [];

    try {

        $usuarios[] = new Admin("Guelmi","guelmi@email.com");
        $usuarios[] = new Alumno("Miguel","miguel@email.com","M1234");

    $usuarios[] = new Alumno("Migue","Correo invalido","M4321");

    } catch(Exception $e) {

        echo "<p>Error controlado: ".$e->getMessage()."</p>";
    }

    echo "<table border='1'>";
    echo "<tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Matrícula</th>
        </tr>";

    foreach($usuarios as $u) {

        $matricula = method_exists($u,"getMatricula") ? $u->getMatricula() : "—";

        echo "<tr>";
        echo "<td>".$u->getNombre()."</td>";
        echo "<td>".$u->getCorreo()."</td>";
        echo "<td>".$u->getRol()."</td>";
        echo "<td>".$matricula."</td>";
        echo "</tr>";

    }

    echo "</table>";

?>