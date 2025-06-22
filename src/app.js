document.addEventListener("alpine:init", () => {
  // Data produk
  Alpine.data("products", () => ({
    items: [
      { id: 1, name: "Espresso", img: "6.jpg", price: 35000 },
      { id: 2, name: "Peruvian", img: "2.jpg", price: 55000 },
      { id: 3, name: "Arabica", img: "3.jpg", price: 45000 },
      { id: 4, name: "Toraja", img: "4.jpg", price: 55000 },
    ],
  }));

  // Store keranjang
  Alpine.store("cart", {
    items: [],
    total: 0,
    quantity: 0,

    add(newItem) {
      const cartItem = this.items.find((item) => item.id === newItem.id);
      if (!cartItem) {
        this.items.push({ ...newItem, quantity: 1, total: newItem.price });
        this.quantity++;
        this.total += newItem.price;
      } else {
        this.items = this.items.map((item) => {
          if (item.id !== newItem.id) {
            return item;
          } else {
            item.quantity++;
            item.total = item.price * item.quantity;
            this.quantity++;
            this.total += item.price;
            return item;
          }
        });
      }
    },

    remove(id) {
      const cartItem = this.items.find((item) => item.id === id);

      if (cartItem.quantity > 1) {
        this.items = this.items.map((item) => {
          if (item.id !== id) {
            return item;
          } else {
            item.quantity--;
            item.total = item.price * item.quantity;
            this.quantity--;
            this.total -= item.price;
            return item;
          }
        });
      } else if (cartItem.quantity === 1) {
        this.items = this.items.filter((item) => item.id !== id);
        this.quantity--;
        this.total -= cartItem.price;
      }
    },
  });
});

// === FORM VALIDASI ===
const checkoutButton = document.querySelector(".checkout-button");
checkoutButton.disabled = true;

const form = document.querySelector("#checkoutForm");

form.addEventListener("keyup", function () {
  for (let i = 0; i < form.elements.length; i++) {
    if (form.elements[i].value.length !== 0) {
      checkoutButton.classList.remove("disabled");
      checkoutButton.classList.add("disabled");
    } else {
      return false;
    }
  }
  checkoutButton.disabled = false;
  checkoutButton.classList.remove("disabled");
});

// === KIRIM DATA SAAT CHECKOUT ===
checkoutButton.addEventListener("click", async function (e) {
  e.preventDefault();

  const formData = new FormData(form);

  // tambahkan data keranjang ke formData
  const cart = Alpine.store("cart");
  formData.append("items", JSON.stringify(cart.items));
  formData.append("total", cart.total);

  const data = new URLSearchParams(formData);
  const objData = Object.fromEntries(data);
  const message = formatMessage(objData);
  // console.log(message);

  try {
    const response = await fetch("php/1.php", {
      method: "POST",
      body: data,
    });

    const token = await response.text();
    // Panggil Snap dengan notifikasi
    window.snap.pay(token, {
      onSuccess: function (result) {
        alert("✅ Pembayaran berhasil!");
        console.log(result);
        // Reset form & keranjang
        form.reset();
        checkoutButton.disabled = true;
        checkoutButton.classList.add("disabled");
        cart.items = [];
        cart.total = 0;
        cart.quantity = 0;
      },
      onPending: function (result) {
        alert("⌛ Pembayaran sedang diproses.");
        console.log(result);
      },
      onError: function (result) {
        alert("❌ Terjadi kesalahan saat pembayaran.");
        console.log(result);
      },
      onClose: function () {
        alert("🚫 Anda menutup popup sebelum menyelesaikan pembayaran.");
      },
    });
  } catch (err) {
    console.log("ERROR:", err.message);
  }
});

// === FORMAT PESAN ===
const formatMessage = (obj) => {
  return `📦 *Data Customer*\n
Nama: ${obj.name}
Email: ${obj.email}
No Telp: ${obj.phone}
Alamat: ${obj.addres}

🧾 *Data Pesanan*\n
${JSON.parse(obj.items)
  .map((item) => `${item.name} (${item.quantity} x ${rupiah(item.total)})`)
  .join("\n")}

💰 TOTAL: ${rupiah(obj.total)}

🙏 Terima kasih telah berbelanja di Cuysstore Coffee. Kami akan segera memproses pesanan Anda.`;
};

// === FORMAT RUPIAH ===
const rupiah = (number) => {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(number);
};
