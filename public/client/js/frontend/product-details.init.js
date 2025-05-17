/*
Template Name: Toner eCommerce + Admin HTML Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: product Details init js
*/
isData();
function isData() {
  var plus = document.getElementsByClassName('plus');
  var minus = document.getElementsByClassName('minus');
  var product = document.getElementsByClassName("product");

  if (plus) {
    Array.from(plus).forEach(function (e) {
  e.addEventListener('click', function (event) {
    const input = event.currentTarget.previousElementSibling;
    const max = parseInt(input.getAttribute('max'));

    if (parseInt(input.value) < max) {
      input.value = parseInt(input.value) + 1;
      if (product) {
        Array.from(product).forEach(function (x) {
          updateQuantity(event.currentTarget);
        });
      }
    }
  });
});

  }

  if (minus) {
    Array.from(minus).forEach(function (e) {
  e.addEventListener('click', function (event) {
    const input = event.currentTarget.nextElementSibling;
    const min = parseInt(input.getAttribute('min'));

    if (parseInt(input.value) > min) {
      input.value = parseInt(input.value) - 1;
      if (product) {
        Array.from(product).forEach(function (x) {
          updateQuantity(event.currentTarget);
        });
      }
    }
  });
});

  }
}
function showToast(message, type = 'success') {
  const toast = document.getElementById('toast-message');
  toast.textContent = message;
  toast.className = `show ${type} fixed top-5 right-5 z-50 px-4 py-2 rounded text-white shadow-lg`;

  setTimeout(() => {
    toast.classList.remove('show');
  }, 3000); // 3 giây ẩn đi
}

document.querySelector('#add-to-cart-form').addEventListener('submit', function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch('/cart/add', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: formData
  })
    .then(res => res.json()) // Đảm bảo bạn gọi res.json() trước khi làm việc với dữ liệu
    .then(data => {
      if (data && data.success) {
        showToast(data.message, 'success');

      } else {
        showToast(data?.message || 'Có lỗi xảy ra!', 'error');
      }
    })
    .catch(err => {
      console.error('Lỗi:', err);
      showToast('Lỗi không xác định!', 'error');
    });

});


document.addEventListener('DOMContentLoaded', function () {
  const sizeRadioButtons = document.getElementsByName('size');  // Lấy tất cả radio button cho size
  const colorRadioButtons = document.getElementsByName('color'); // Lấy tất cả radio button cho color
  const addToCartButton = document.getElementById('add-to-cart'); // Nút Add to Cart

  // Function to enable/disable "Add to Cart" button
  function toggleAddToCartButton() {
    // Kiểm tra xem người dùng đã chọn size và color chưa
    const sizeSelected = Array.from(sizeRadioButtons).some(radio => radio.checked);
    const colorSelected = Array.from(colorRadioButtons).some(radio => radio.checked);

    // Nếu cả size và color đều được chọn thì mới bật nút Add to Cart
    if (sizeSelected && colorSelected) {
      addToCartButton.disabled = false; // Enable the button
    } else {
      addToCartButton.disabled = true; // Disable the button
    }
  }

  // Thêm sự kiện lắng nghe thay đổi cho các radio button
  sizeRadioButtons.forEach(radio => {
    radio.addEventListener('change', toggleAddToCartButton);
  });

  colorRadioButtons.forEach(radio => {
    radio.addEventListener('change', toggleAddToCartButton);
  });

  // Kiểm tra khi trang được tải lần đầu
  toggleAddToCartButton();
});

var swiper = new Swiper(".productSwiper", {

  spaceBetween: 10,
  slidesPerView: 4,
  mousewheel: true,
  freeMode: true,
  watchSlidesProgress: true,
  breakpoints: {
    992: {
      slidesPerView: 4,
      spaceBetween: 10,
      direction: "vertical",
    },
  },
});
var swiper2 = new Swiper(".productSwiper2", {
  loop: true,
  spaceBetween: 10,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  thumbs: {
    swiper: swiper,
  },
});