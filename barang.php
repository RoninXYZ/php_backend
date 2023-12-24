<?php
header("Content-Type: application/json");

include_once 'koneksi.php';

$request_method = $_SERVER["REQUEST_METHOD"];

function getBarang($id = 0)
{
    global $conn;
    $query = "SELECT * FROM barang";
    if ($id != 0) {
        $query .= " WHERE id=" . $id . " LIMIT 1";
    }
    $response = array();
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function insertBarang()
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"));
    $namabarang = $data->namabarang;
    $hargabarang = $data->hargabarang;
    $query = "INSERT INTO barang SET namabarang='$namabarang', hargabarang=$hargabarang";
    if ($conn->query($query) === true) {
        $response = array('status' => 'success', 'message' => 'Barang berhasil ditambahkan.');
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal menambahkan barang. ' . $conn->error);
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function updateBarang($id)
{
    global $conn;
    $data = json_decode(file_get_contents("php://input"));
    $namabarang = $data->namabarang;
    $hargabarang = $data->hargabarang;
    $query = "UPDATE barang SET namabarang='$namabarang', hargabarang=$hargabarang WHERE id=$id";
    if ($conn->query($query) === true) {
        $response = array('status' => 'success', 'message' => 'Barang berhasil diperbarui.');
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal memperbarui barang. ' . $conn->error);
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function deleteBarang($id)
{
    global $conn;
    $query = "DELETE FROM barang WHERE id=$id";
    if ($conn->query($query) === true) {
        $response = array('status' => 'success', 'message' => 'Barang berhasil dihapus.');
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal menghapus barang. ' . $conn->error);
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function getTotalBarang()
{
    global $conn;
    $query = "SELECT COUNT(*) as total FROM barang";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        $total = $row['total'];
        $response = array('total' => $total);
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal mendapatkan jumlah barang. ' . $conn->error);
    }

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}
function deleteAllBarang()
{
    global $conn;
    $query = "DELETE FROM barang";
    
    if ($conn->query($query) === true) {
        $response = array('status' => 'success', 'message' => 'Semua barang berhasil dihapus.');
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal menghapus semua barang. ' . $conn->error);
    }

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function getTotalHargaBarang()
{
    global $conn;
    $query = "SELECT SUM(hargabarang) as total FROM barang";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        $total = $row['total'];
        $response = array('total' => $total);
    } else {
        $response = array('status' => 'error', 'message' => 'Gagal mendapatkan jumlah total harga barang. ' . $conn->error);
    }

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

switch ($request_method) {
    case 'GET':
      if (!empty($_GET["id"])) {
        getBarang(intval($_GET["id"]));
    } else if (!empty($_GET["total"])) {
        getTotalBarang();
    }else if (!empty($_GET["totalharga"])) {
      getTotalHargaBarang();
    } 
    else {
        getBarang();
    }
        break;
    case 'POST':
        insertBarang();
        break;
    case 'PUT':
        if (!empty($_GET["id"])) {
            updateBarang(intval($_GET["id"]));
        }
        break;
    case 'DELETE':
          if (!empty($_GET["id"])) {
              deleteBarang(intval($_GET["id"]));
          } elseif (!empty($_GET["deleteall"])) {
              deleteAllBarang();
          }
          break;
      
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
?>
