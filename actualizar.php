<?php
    // CONSTANTE PARA LA CONEXION
    $hostBD = "localhost";
    $nameBD = "ejemplo";
    $userBD = "root";
    $password = "";

    //CONEXION
    $miPDO = new PDO("mysql:host=$hostBD;dbname=$nameBD",$userBD,$password);

    // CODIGO
    $codigo = isset($_REQUEST["codigo"])? $_REQUEST["codigo"] : null;

    //DATOS PARA MODIFICAR

    $titulo = isset($_REQUEST["txtTitulo"])? $_REQUEST["txtTitulo"] : null;
    $autor = isset($_REQUEST["txtAutor"]) ? $_REQUEST["txtAutor"]:null;
    $disponible = isset($_REQUEST["txtDisponible"])? $_REQUEST["txtDisponible"]:null;

    //FUNCIONALIDADA
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $miConsulta = $miPDO->prepare("SELECT * FROM libros WHERE codigo = :codigo");
        $miConsulta->bindValue(":codigo",$codigo);
        $miConsulta->execute();
    }else{
        if($titulo != null && $autor != null && $disponible != null){
            $miUpdate = $miPDO->prepare("UPDATE libros SET titulo = :titulo, autor = :autor, disponible = :disponible WHERE codigo = :codigo");
            $miUpdate->bindValue(":titulo",$titulo);
            $miUpdate->bindValue(":autor",$autor);
            $miUpdate->bindValue(":disponible",$disponible);
            $miUpdate->bindValue(":codigo",$codigo);
            $miUpdate->execute();
            header('Location: index.php');
            die();
        }
    }

    // EL LIBRO SELECCIONADO
    $libro = $miConsulta->fetch();


?>

<form method="POST">
        <div>
            <input 
                type="text" 
                name="txtTitulo" 
                placeholder="Ingresar Titulo" 
                value="<?= $libro["titulo"] ?>"
            >
        </div>
        <div>
            <input 
                type="text" 
                name="txtAutor" 
                placeholder="Ingresar Autor"
                value="<?= $libro["autor"] ?>"
            >
        </div>
        <div>
            <input 
                type="radio" 
                name="txtDisponible" 
                value="1"
                <?= $libro["disponible"] ? "checked":""?>
                >
            <label >Si</label>

            <input 
                type="radio" 
                name="txtDisponible" 
                value="0"
                <?= !$libro["disponible"] ? "checked":""?>
                >
            <label >No</label>
        </div>
        <div>
            <input type="submit" value="Guardar">
        </div>
    </form>