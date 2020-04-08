<?php 

$connection = mysqli_connect("localhost","usuario","clave","arduino");

if(isset($_GET['q'])) {

  switch($_GET['q']) {

    case 'y':
    $sql = "SELECT id,valor, DATE_FORMAT(fecha,'%d/%m/%y-%H:%i') AS fecha FROM mq135 ORDER BY fecha DESC LIMIT 20";
    break;
/*
    case 'm':
    $sql = "SELECT Temperatura, Humedad, DATE_FORMAT(fecha,'   %m-%d   ') AS fecha FROM dht11 WHERE fecha BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() ORDER BY fecha DESC";
    break;

    case 'w':
    $sql = "SELECT Temperatura, Humedad, DATE_FORMAT(fecha,'%W') AS fecha FROM dht11 ORDER BY fecha DESC";
    break;

    case 'd':
    $sql = "SELECT Temperatura, Humedad, DATE_FORMAT(fecha,'   %H:%i   ') AS fecha FROM dht11 ORDER BY fecha DESC";
    break;

    case 'h':
    $sql = "SELECT Temperatura, Humedad, DATE_FORMAT(fecha,'   %H:%i   ') AS fecha FROM dht11 WHERE id MOD 6 = 0 ORDER BY id DESC LIMIT 300";
    break;
*/
    default:
     $sql = "SELECT id,valor, DATE_FORMAT(fecha,'%d/%m/%-%H:%i') AS fecha FROM mq135 ORDER BY fecha DESC";
  
  }

  $result = mysqli_query($connection, $sql);

  $emparray = array();
  while($row =mysqli_fetch_assoc($result)) {
    $emparray[] = $row;
  }

  echo json_encode($emparray);

}

mysqli_close($connection);

?>
