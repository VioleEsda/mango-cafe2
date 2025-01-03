<!-- filepath: /c:/xampp/htdocs/Praktikum/mango-cafe2/menu.php -->
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <title>Menu - MangoCafe</title>
</head>
<body>
    <!-- Header -->
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
            <button class="btn" onclick="window.location.href='shopping_bag.php'"><i class="ri-shopping-bag-fill"></i></button>
        </div>
    </nav>

    <!-- Konten Halaman Menu -->
    <section class="section__container special__container" id="food">
        <h2 class="section__header">Menu Makanan</h2>
        <p class="section__description">Jelajahi pilihan makanan lezat yang disiapkan dengan bahan terbaik.</p>
        <div class="special__grid" id="food-menu">
            <?php
            // Mengambil data makanan
            $sql = "SELECT item_id, name, description, price, image FROM menu_items WHERE category_id = 1 AND available = 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='special__card'>";
                    echo "<img src='" . $row["image"] . "' alt='special' />";
                    echo "<h4>" . $row["name"] . "</h4>";
                    echo "<p>" . $row["description"] . "</p>";
                    echo "<div class='special__ratings'>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "</div>";
                    echo "<div class='special__footer'>";
                    echo "<p class='price'>Rp" . $row["price"] . "</p>";
                    echo "<form method='POST' action=''>";
                    echo "<input type='hidden' name='item_id' value='" . $row["item_id"] . "'>";
                    echo "<input type='hidden' name='name' value='" . $row["name"] . "'>";
                    echo "<input type='hidden' name='price' value='" . $row["price"] . "'>";
                    echo "<input type='hidden' name='image' value='" . $row["image"] . "'>";
                    echo "<button type='submit' name='add_to_cart' class='btn'>Add to Cart</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No food items available.";
            }
            ?>
        </div>
    </section>

    <section class="section__container special__container" id="drinks">
        <h2 class="section__header">Menu Minuman</h2>
        <p class="section__description">Puaskan dahaga Anda dengan pilihan minuman yang menyegarkan.</p>
        <div class="special__grid" id="drink-menu">
            <?php
            // Mengambil data minuman
            $sql = "SELECT item_id, name, description, price, image FROM menu_items WHERE category_id = 2 AND available = 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='special__card'>";
                    echo "<img src='" . $row["image"] . "' alt='special' />";
                    echo "<h4>" . $row["name"] . "</h4>";
                    echo "<p>" . $row["description"] . "</p>";
                    echo "<div class='special__ratings'>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "</div>";
                    echo "<div class='special__footer'>";
                    echo "<p class='price'>Rp" . $row["price"] . "</p>";
                    echo "<form method='POST' action=''>";
                    echo "<input type='hidden' name='item_id' value='" . $row["item_id"] . "'>";
                    echo "<input type='hidden' name='name' value='" . $row["name"] . "'>";
                    echo "<input type='hidden' name='price' value='" . $row["price"] . "'>";
                    echo "<input type='hidden' name='image' value='" . $row["image"] . "'>";
                    echo "<button type='submit' name='add_to_cart' class='btn'>Add to Cart</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No drink items available.";
            }

            // Menutup koneksi
            $conn->close();
            ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
      <div class="section__container footer__container">
        <div class="footer__col">
          <div class="logo footer__logo">
            <a href="#">Mango<span>Cafe</span></a>
          </div>
          <p class="section__description">
            Mulailah perjalanan gastronomi bersama MangoCafe, 
            di mana setiap gigitan menceritakan sebuah kisah dan 
            setiap hidangan dibuat dengan sempurna.
          </p>
        </div>
        <div class="footer__col">
          <h4>Product</h4>
          <ul class="footer__links">
            <li><a href="menu.php">Menu</a></li>
            <li><a href="#special">Specials</a></li>
            <li><a href="#">Meal Deals</a></li>
            <li><a href="#">Opsi Catering</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>Information</h4>
          <ul class="footer__links">
            <li><a href="#">About Us</a></li>
            <li><a href="contact.html">Contact Us</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>Company</h4>
          <ul class="footer__links">
            <li><a href="#">Our Story</a></li>
            <li><a href="#">Careers</a></li>
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
      </div>
      <div class="footer__bar">
        Copyright © 2024 MangoCafe. All rights reserved.
      </div>
    </footer>

    <script src="main.js"></script>
</body>
</html>