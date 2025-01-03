<!-- filepath: /c:/xampp/htdocs/Praktikum/mango-cafe2/shopping_bag.php -->
<?php
// Mengatur header untuk mengontrol cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Tanggal di masa lalu

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

// Menangani penghapusan item dari shopping bag
if (isset($_POST['remove'])) {
    $item_id = $_POST['item_id'];
    $sql = "DELETE FROM shopping_bag WHERE item_id = $item_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Item removed successfully');</script>";
    } else {
        echo "<script>console.log('Error removing item: " . $conn->error . "');</script>";
    }
}

// Menangani penambahan jumlah item
if (isset($_POST['increase'])) {
    $item_id = $_POST['item_id'];
    $sql = "UPDATE shopping_bag SET quantity = quantity + 1 WHERE item_id = $item_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Item quantity increased successfully');</script>";
    } else {
        echo "<script>console.log('Error increasing quantity: " . $conn->error . "');</script>";
    }
}

// Menangani pengurangan jumlah item
if (isset($_POST['decrease'])) {
    $item_id = $_POST['item_id'];
    $sql = "UPDATE shopping_bag SET quantity = quantity - 1 WHERE item_id = $item_id AND quantity > 1";
    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Item quantity decreased successfully');</script>";
    } else {
        echo "<script>console.log('Error decreasing quantity: " . $conn->error . "');</script>";
    }
}

// Menangani checkout
if (isset($_POST['checkout'])) {
    // Buat order baru di tabel orders
    $sql_order = "INSERT INTO orders (customer_id, total_amount, status) VALUES (1, 0, 'Pending')";
    if ($conn->query($sql_order) === TRUE) {
        $order_id = $conn->insert_id;
        echo "<script>console.log('Order created successfully');</script>";

        // Ambil item dari shopping bag dan masukkan ke order_details
        $sql = "SELECT * FROM shopping_bag";
        $result = $conn->query($sql);

        $total_amount = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $item_id = $row['item_id'];
                $price = $row['price'];
                $quantity = $row['quantity'];
                $total_amount += $price * $quantity;

                $sql_insert = "INSERT INTO order_details (order_id, item_id, quantity, price) VALUES ($order_id, $item_id, $quantity, $price)";
                if ($conn->query($sql_insert) === TRUE) {
                    echo "<script>console.log('Order detail added successfully');</script>";
                } else {
                    echo "<script>console.log('Error adding order detail: " . $conn->error . "');</script>";
                }
            }
            // Update total_amount di tabel orders
            $sql_update_order = "UPDATE orders SET total_amount = $total_amount WHERE order_id = $order_id";
            if ($conn->query($sql_update_order) === TRUE) {
                echo "<script>console.log('Order total amount updated successfully');</script>";
            } else {
                echo "<script>console.log('Error updating order total amount: " . $conn->error . "');</script>";
            }

            // Tambahkan pembayaran ke tabel payments
            $payment_method = 'Credit Card'; // Contoh metode pembayaran
            $sql_payment = "INSERT INTO payments (order_id, amount, payment_method) VALUES ($order_id, $total_amount, '$payment_method')";
            if ($conn->query($sql_payment) === TRUE) {
                echo "<script>console.log('Payment added successfully');</script>";
            } else {
                echo "<script>console.log('Error adding payment: " . $conn->error . "');</script>";
            }

            // Kosongkan shopping bag setelah checkout
            $sql = "DELETE FROM shopping_bag";
            if ($conn->query($sql) === TRUE) {
                echo "<script>console.log('Shopping bag cleared successfully');</script>";
            } else {
                echo "<script>console.log('Error clearing shopping bag: " . $conn->error . "');</script>";
            }
        }
    } else {
        echo "<script>console.log('Error creating order: " . $conn->error . "');</script>";
    }
}

// Mengambil data dari shopping bag
$sql = "SELECT * FROM shopping_bag";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <title>Shopping Bag - MangoCafe</title>
</head>
<body>
    <nav>
        <div class="nav__header">
            <div class="logo nav__logo">
                <a href="#">Mango<span>Cafe</span></a>
            </div>
            <div class="nav__menu__btn" id="menu-btn">
                <span><i class="ri-menu-line"></i></span>
            </div>
        </div>
        <ul class="nav__links" id="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="index.html#special">Special</a></li>
            <li><a href="index.html#chef">Chef</a></li>
            <li><a href="index.html#client">Clients</a></li>
            <li><a href="contact.html">Contact Us</a></li>
        </ul>
        <div class="nav__btn">
            <button class="btn" onclick="window.location.href='index.html'"><i class="ri-home-line"></i></button>
        </div>
    </nav>

    <section class="section__container shopping__container">
        <h2 class="section__header">Shopping Bag</h2>
        <div class="shopping__list">
            <?php
            $total_price = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $total_price += $row["price"] * $row["quantity"];
                    echo "<div class='shopping__card'>";
                    echo "<img src='" . $row["image"] . "' alt='item' />";
                    echo "<div class='shopping__details'>";
                    echo "<h4>" . $row["name"] . "</h4>";
                    echo "<p class='price'>Rp" . $row["price"] . "</p>";
                    echo "<div class='quantity-controls'>";
                    echo "<form method='POST' action=''>";
                    echo "<input type='hidden' name='item_id' value='" . $row["item_id"] . "'>";
                    echo "<button type='submit' name='decrease' class='btn'>-</button>";
                    echo "<span class='quantity'>" . $row["quantity"] . "</span>";
                    echo "<button type='submit' name='increase' class='btn'>+</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "<form method='POST' action=''>";
                    echo "<input type='hidden' name='item_id' value='" . $row["item_id"] . "'>";
                    echo "<button type='submit' name='remove' class='btn'>Remove</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No items in the shopping bag.</p>";
            }
            ?>
        </div>
        <div class="total-price">
            <h3>Total: Rp<?php echo $total_price; ?></h3>
        </div>
        <form method="POST" action="">
            <button type="submit" name="checkout" class="btn">Checkout</button>
        </form>
    </section>

    <script>
        const menuBtn = document.getElementById("menu-btn");
        const navLinks = document.getElementById("nav-links");
        const menuBtnIcon = menuBtn.querySelector("i");

        menuBtn.addEventListener("click", () => {
            navLinks.classList.toggle("open");

            const isOpen = navLinks.classList.contains("open");
            menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line");
        });

        navLinks.addEventListener("click", () => {
            navLinks.classList.remove("open");
            menuBtnIcon.setAttribute("class", "ri-menu-line");
        });
    </script>
</body>
</html>