<!-- filepath: /c:/xampp/htdocs/Praktikum/mango-cafe2/add_to_cart.php -->
<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "mangocafe";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menangani penambahan item ke shopping bag
if (isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    // Periksa apakah item sudah ada di shopping bag
    $sql_check = "SELECT * FROM shopping_bag WHERE item_id = $item_id";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Jika item sudah ada, tambahkan quantity
        $sql_update = "UPDATE shopping_bag SET quantity = quantity + 1 WHERE item_id = $item_id";
        $conn->query($sql_update);
    } else {
        // Jika item belum ada, tambahkan item baru
        $sql_insert = "INSERT INTO shopping_bag (item_id, name, price, image, quantity) VALUES ($item_id, '$name', $price, '$image', 1)";
        $conn->query($sql_insert);
    }

    // Alihkan pengguna ke halaman shopping bag
    header("Location: shopping_bag.php");
    exit();
}

// Menutup koneksi
$conn->close();
?>