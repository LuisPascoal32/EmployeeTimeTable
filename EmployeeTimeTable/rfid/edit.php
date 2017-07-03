<?php

$conn = mysqli_connect("127.0.0.1", "root", "12345", "teste");
if (!$conn) {

    die("Error: " . mysqli_connect_error());
}

$nome = mysqli_real_escape_string($conn, $_POST['nome']);
$data = mysqli_real_escape_string($conn, $_POST['data']);
$entrada = mysqli_real_escape_string($conn, $_POST['entrada']);
$saida = mysqli_real_escape_string($conn, $_POST['saida']);
$r_id = mysqli_real_escape_string($conn, $_POST['id']);

//echo $nome, $data, $entrada, $saida, $r_id;
$resultado = mysqli_query($conn, 'select id from Funcionario where nome ='."'$nome'".";");
while ($row = mysqli_fetch_assoc($resultado)) {
    
    $f_id = $row['id'];
}

$sql='update registo set data='."'$data'".",entrada="."'$entrada'".",saida="."'$saida'".",Funcionario_id=".$f_id." where id=".$r_id.";";

mysqli_query($conn, $sql);

    ?>

<script language = "javascript">
    window.location.href = "index.php";
</script> 
