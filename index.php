<?php 
    $hostBD = "localhost";
    $nameBD = "ejemplo";
    $userBD = "root";
    $password = "";

    $miPDO = new PDO("mysql:host=$hostBD;dbname=$nameBD",$userBD,$password);
    $miConsulta = $miPDO->prepare("SELECT * FROM libros");
    $miConsulta->execute();


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $titulo = isset($_REQUEST["txtTitulo"])?$_REQUEST["txtTitulo"]:null;
        $autor = isset($_REQUEST["txtAutor"])?$_REQUEST["txtAutor"]:null;
        $disponible = isset($_REQUEST["txtDisponible"])?$_REQUEST["txtDisponible"]:null;

        if($titulo != null && $autor != null && $disponible != null){
            $insert = $miPDO->prepare("INSERT INTO libros(titulo,autor,disponible) VALUES (:titulo,:autor,:disponible)");

            $insert->bindValue(":titulo",$titulo);
            $insert->bindValue(":autor",$autor);
            $insert->bindValue(":disponible",$disponible);
            $insert->execute();
            header('Location: index.php');
            die();
        }else{
            echo "<p>Ingrese correctamente los datos</p>";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
</head>
<body>
    <!-- CREATE -->
    <h1>AGREGAR LIBRO</h1>
    <form method="POST">
        <div>
            <input type="text" name="txtTitulo" placeholder="Ingresar Titulo">
        </div>
        <div>
            <input type="text" name="txtAutor" placeholder="Ingresar Autor">
        </div>
        <div>
            <input type="radio" name="txtDisponible" value="1">
            <label >Si</label>

            <input type="radio" name="txtDisponible" value="0">
            <label >No</label>
        </div>
        <div>
            <input type="submit" value="Guardar">
        </div>
    </form>
    <br>

    <!-- READ  -->
    <table border="2">
        <thead>
            <tr>
                <th>Titulo</th>
                <th>Autor</th>
                <th>Disponibilidad</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($miConsulta as $clave => $valor): ?>
            <tr>
                <td><?= $valor["titulo"]?></td>
                <td><?= $valor["autor"] ?></td>
                <td><?= ($valor["disponible"])? "SI":"NO"?></td>
                <td>
                    <a href="actualizar.php?codigo=<?= $valor["codigo"]?>">Modificar</a>
                    <a href="eliminar.php?codigo=<?= $valor["codigo"]?>">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>