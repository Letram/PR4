<?php
include_once('lib.php');
View::start("Atender llamada");
if(isset($_GET['searchByName']) || isset($_GET['searchByNumber'])){
    $dbConn=DB::get();
    if(isset($_GET['searchByName'])){
        $clientName=$_GET['clientName'];
        $query = $dbConn -> prepare("select * from clientes where nombre=?;");
        $query->execute(array($clientName));
        if($query){
            $query->setFetchMode(PDO::FETCH_NAMED);
            $headerRow = true;
            echo '<table>';
            foreach($query as $table_row){
                if($headerRow == true){
                    echo '<tr>';
                    foreach($table_row as $table_row_index => $table_row_data){
                        if($table_row_index == 'id')continue;
                        echo '<th>'.$table_row_index.'</th>';
                    }
                    echo '</tr>';
                    $headerRow = false;
                }
                echo '<tr>';
                foreach($table_row as $table_row_index => $table_row_data){
                    if($table_row_index == 'id')continue;
                    echo '<td>'.$table_row_data.'</td>';
                }
                echo '<td><a href="clientCallDetails.php?id='.$table_row['id'].'">Detalles de la llamada</a></td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    }
    else if(isset($_GET['searchByNumber'])){
        $clientNumber=$_GET['clientNumber'];
        $query = $dbConn -> prepare("select * from clientes where telefono=?;");
        $query->execute(array($clientNumber));
        if($query){
            $query->setFetchMode(PDO::FETCH_NAMED);
            $headerRow = true;
            echo '<table>';
            foreach($query as $table_row){
                if($headerRow == true){
                    echo '<tr>';
                    foreach($table_row as $table_row_index => $table_row_data){
                        if($table_row_index == 'id')continue;
                        echo '<th>'.$table_row_index.'</th>';
                    }
                    echo '</tr>';
                    $headerRow = false;
                }
                echo '<tr>';
                foreach($table_row as $table_row_index => $table_row_data){
                    if($table_row_index == 'id')continue;
                    echo '<td>'.$table_row_data.'</td>';
                }
                echo '<td><a href="clientCallDetails.php?id='.$table_row['id'].'">Detalles de la llamada</a></td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    }
}else{
    View::lookForClient();
    View::showClientList();
}
echo '<a href="addClient.php">Añadir cliente</a>';
echo '<br>';
echo '<a href="index.php">Volver.</a>';
View::end();
?>