const menuBtn = document.getElementById("menu-btn");
const navLinks = document.getElementById("nav-links");
const menuBtnIcon = menuBtn.querySelector("i");

menuBtn.addEventListener("click", (e) => {
  navLinks.classList.toggle("open");

  const isOpen = navLinks.classList.contains("open");
  menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line");
});

navLinks.addEventListener("click", (e) => {
  navLinks.classList.remove("open");
  menuBtnIcon.setAttribute("class", "ri-menu-line");
});

const scrollRevealOption = {
  distance: "50px",
  origin: "bottom",
  duration: 1000,
};

if (typeof ScrollReveal !== 'undefined') {
  ScrollReveal().reveal(".header__image img", {
    ...scrollRevealOption,
    origin: "right",
  });
  ScrollReveal().reveal(".header__content h1", {
    ...scrollRevealOption,
    delay: 500,
  });
  ScrollReveal().reveal(".header__content .section__description", {
    ...scrollRevealOption,
    delay: 1000,
  });
} else {
  console.error('ScrollReveal is not defined');
}

// Pastikan Swiper diimpor sebelum digunakan
if (typeof Swiper !== 'undefined') {
  const swiper = new Swiper('.swiper-container', {
    // Swiper options
    loop: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
} else {
  console.error('Swiper is not defined');
}

document.addEventListener('DOMContentLoaded', function() {
  // Inisialisasi Swiper
  var swiper = new Swiper('.swiper', {
    loop: true,
    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });

  // Event listener untuk tombol "Get Started"
  var getStartedBtn = document.getElementById('get-started-btn');
  if (getStartedBtn) {
    getStartedBtn.addEventListener('click', function() {
      document.getElementById('special').scrollIntoView({ behavior: 'smooth' });
    });
  }

  // Event listener untuk tombol "Add to Cart"
  var addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
  addToCartButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
      event.preventDefault();
      console.log('Add to Cart button clicked'); // Debugging
      var form = button.closest('form');
      var formData = new FormData(form);

      // Simulate adding to cart
      fetch('menu.php', {
        method: 'POST',
        body: formData
      }).then(function(response) {
        return response.text();
      }).then(function(data) {
        console.log('Item added to cart'); // Debugging
      });
    });
  });
});