<?php
require_once('connection.php');
$query = mysqli_query($connection, "SELECT * FROM movie");
$result = array();
while($row = mysqli_fetch_array($query)){
    array_push($result, array(
        'id' => $row['id'],
        'title' => $row['title'],
        'image' => $row['image']
    ));
}
echo json_encode(
    array('result' => $result)
)




?>