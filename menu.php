<!-- filepath: /c:/xampp/htdocs/Praktikum/mango-cafe2/menu.php -->
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
            <li><a href="index.html">Special</a></li>
            <li><a href="index.html">Chef</a></li>
            <li><a href="index.html">Clients</a></li>
            <li><a href="index.html">Contact Us</a></li>
            <li><a href="menu.php">Menu</a></li>
        </ul>
        <div class="nav__btn">
            <button class="btn"><i class="ri-shopping-bag-fill"></i></button>
        </div>
    </nav>

    <!-- Konten Halaman Menu -->
    <section class="section__container special__container" id="food">
        <h2 class="section__header">Our Food Menu</h2>
        <p class="section__description">Explore our delicious food options crafted with the finest ingredients.</p>
        <div class="special__grid" id="food-menu">
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

            // Mengambil data makanan
            $sql = "SELECT name, description, price FROM menu_items WHERE category_id = 1 AND available = 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='special__card'>";
                    echo "<img src='assets/special-1.png' alt='special' />"; // Ganti dengan path gambar yang sesuai
                    echo "<h4>" . $row["name"] . "</h4>";
                    echo "<p>" . $row["description"] . "</p>";
                    echo "<div class='special__ratings'>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "</div>";
                    echo "<div class='special__footer'>";
                    echo "<p class='price'>Rp" . $row["price"] . "</p>";
                    echo "<button class='btn'>Add to Cart</button>";
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
        <h2 class="section__header">Our Drink Menu</h2>
        <p class="section__description">Quench your thirst with our refreshing drink selections.</p>
        <div class="special__grid" id="drink-menu">
            <?php
            // Mengambil data minuman
            $sql = "SELECT name, description, price FROM menu_items WHERE category_id = 2 AND available = 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='special__card'>";
                    echo "<img src='assets/special-1.png' alt='special' />"; // Ganti dengan path gambar yang sesuai
                    echo "<h4>" . $row["name"] . "</h4>";
                    echo "<p>" . $row["description"] . "</p>";
                    echo "<div class='special__ratings'>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "<span><i class='ri-star-fill'></i></span>";
                    echo "</div>";
                    echo "<div class='special__footer'>";
                    echo "<p class='price'>Rp" . $row["price"] . "</p>";
                    echo "<button class='btn'>Add to Cart</button>";
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
              Embark on a gastronomic journey with FoodMan, where every bite tells
              a story and every dish is crafted to perfection.
            </p>
          </div>
          <div class="footer__col">
            <h4>Product</h4>
            <ul class="footer__links">
              <li><a href="#">Menu</a></li>
              <li><a href="#">Specials</a></li>
              <li><a href="#">Meal Deals</a></li>
              <li><a href="#">Catering Options</a></li>
              <li><a href="#">Seasonal Offerings</a></li>
            </ul>
          </div>
          <div class="footer__col">
            <h4>Information</h4>
            <ul class="footer__links">
              <li><a href="#">About Us</a></li>
              <li><a href="#">Contact Us</a></li>
              <li><a href="#">Nutrition Information</a></li>
              <li><a href="#">Allergen Information</a></li>
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
          Copyright © 2024 Web Design Mastery. All rights reserved.
        </div>
      </footer>

    <script src="main.js"></script>
</body>
</html>