<?php
include_once('lib.php');
$opt=false;
if(isset($_POST['opt'])){
    $opt=!$opt;
}
View::start("Received Messages");
echo '<div>';
    View::showReceivedMessages($opt);
echo '</div>';
echo '<a href="index.php">Volver</a>';
echo '<form action="" method="post" class="Order">
<input type="submit" value="Ordenar" name="opt">
</form>';
View::end();
?>