<?php 
    $hostBD = "localhost";
    $nameBD = "ejemplo";
    $userBD = "root";
    $password = "";

    $miPDO = new PDO("mysql:host=$hostBD;dbname=$nameBD",$userBD,$password);

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $codigo = isset($_REQUEST["codigo"])? $_REQUEST["codigo"] : null;
        if($codigo != null){
            $delete = $miPDO->prepare("DELETE FROM libros WHERE codigo = :codigo");
            $delete->bindValue(":codigo",$codigo);
            $delete->execute();

            header("Location: index.php");
            die();
        } 
    }
?>