<?php
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $id_to_delete = intval($_GET['id']); // Melindungi terhadap SQL Injection dengan mengonversi nilai menjadi integer
    $stmt = $conn->prepare("DELETE FROM peminjaman WHERE id_pinjam = ?");
    $stmt->bind_param("i", $id_to_delete);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false]);
}
?>
