// Toggle class active
const navbarNav = document.querySelector(".navbar-nav");
//ketika hamburger diklik
document.querySelector("#hamburger-menu").onclick = () => {
  navbarNav.classList.toggle("active");
};

// Toggle class active untuk search form
const searchForm = document.querySelector(".search-form");
const searchBox = document.querySelector("#search-box");

document.querySelector("#search-button").onclick = (e) => {
  searchForm.classList.toggle("active");
  searchBox.focus();
  e.preventDefault();
};

// Toggle class active untuk search form
const shoppingCart = document.querySelector(".shopping-cart");
document.querySelector("#shopping-cart-button").onclick = (e) => {
  shoppingCart.classList.toggle("active");
  e.preventDefault();
};
// Klik diluar sidebar untuk menghilangkan nav
const hamburger = document.querySelector("#hamburger-menu");
const sb = document.querySelector("#search-button");
const sc = document.querySelector("#shopping-cart-button");

document.addEventListener("click", function (e) {
  if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
  }
  if (!sb.contains(e.target) && !searchForm.contains(e.target)) {
    searchForm.classList.remove("active");
  }
  if (!sc.contains(e.target) && !shoppingCart.contains(e.target)) {
    shoppingCart.classList.remove("active");
  }
});
// ===== Form Kontak Validasi =====
const contactForm = document.querySelector(".contact form");

if (contactForm) {
  contactForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const inputs = contactForm.querySelectorAll("input");
    let valid = true;

    inputs.forEach((input) => {
      if (input.value.trim() === "") {
        input.style.borderBottom = "1px solid red";
        valid = false;
      } else {
        input.style.borderBottom = "1px solid var(--primary)";
      }
    });

    if (valid) {
      alert("Pesan berhasil dikirim!");
      contactForm.reset();
    } else {
      alert("Mohon lengkapi semua data terlebih dahulu.");
    }
  });
}
const waButton = document.querySelector(".wa-float");
let lastScrollTop = 0;

window.addEventListener("scroll", () => {
  let scrollTop = window.scrollY || document.documentElement.scrollTop;
  if (scrollTop > lastScrollTop) {
    // Scroll ke bawah, sembunyikan
    waButton.style.opacity = "0";
  } else {
    // Scroll ke atas, tampilkan
    waButton.style.opacity = "1";
  }
  lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
});

// Modal Box
const itemDetailButtons = document.querySelectorAll(".item-detail-button");
const itemDetailModal = document.querySelector("#item-detail-modal");

itemDetailButtons.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    itemDetailModal.style.display = "flex";
  });
});

// Klik tombol close
document.querySelector(".modal .close-icon").onclick = (e) => {
  itemDetailModal.style.display = "none";
  e.preventDefault();
};
// Klik diluar modal
window.onclick = (e) => {
  if (e.target === itemDetailModal) {
    itemDetailModal.style.display = "none";
  }
};
