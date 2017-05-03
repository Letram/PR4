<?php
include_once('lib.php');
if(isset($_POST['addClient'])){
    $clientName=$_POST['clientName'];
    $clientNumber=$_POST['clientNumber'];
    
    $dbConn=DB::get();
    $query=$dbConn->prepare("INSERT INTO clientes (telefono, nombre) VALUES(?, ?);");
    $query->execute(array($clientNumber, $clientName));
    if($query){
        header('Location:atencion.php');
        die;
    }else{
        echo "Error al añadir un usuario";
    }
}
View::start("Añadir cliente");
echo '<form action="" method=post>
Nombre del cliente: <input type="text" name=clientName required><br>
Número de teléfono del cliente: <input type="number" name="clientNumber" required>
<input type="submit" value="Añadir" name="addClient">
</form><br>
<a href=atencion.php>Volver</a>';
View::end();
?>