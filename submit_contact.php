<!-- filepath: /c:/xampp/htdocs/Praktikum/mango-cafe2/submit_contact.php -->
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

// Menangani penyimpanan data kontak
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contacts (name, email, address, message) VALUES ('$name', '$email', '$address', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Alihkan pengguna kembali ke halaman kontak dengan pesan sukses
    header("Location: contact.html?status=success");
    exit();
}

// Menutup koneksi
$conn->close();
?>