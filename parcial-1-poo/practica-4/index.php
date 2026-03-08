<?php

    require_once "Admin.php";
    require_once "Alumno.php";
    require_once "Invitado.php";

    $usuarios = [];

    try{

        $usuarios[] = new Admin("Guelmi","guelmi@gmail.com");
        $usuarios[] = new Alumno("Miguel","miguel@gmail.com","M1234");
        $usuarios[] = new Invitado("Gumiel","gumiel@email.com","Riot");

    // registro inválido
    $usuarios[] = new Alumno("Mielgu","mielgu@smail.com","A4321");

    } catch(Exception $e) {

        echo "<p>Error controlado: ".$e->getMessage()."</p>";
    }

    echo "<table border='1'>";
    echo "<tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Matrícula</th>
            <th>Empresa</th>
        </tr>";

    foreach($usuarios as $u) {

        $matricula = method_exists($u,"getMatricula") ? $u->getMatricula() : "—";
        $empresa = method_exists($u,"getEmpresa") ? $u->getEmpresa() : "—";

        echo "<tr>";
        echo "<td>".$u->getNombre()."</td>";
        echo "<td>".$u->getCorreo()."</td>";
        echo "<td>".$u->getRol()."</td>";
        echo "<td>".$matricula."</td>";
        echo "<td>".$empresa."</td>";
        echo "</tr>";

    }

    echo "</table>";

?>