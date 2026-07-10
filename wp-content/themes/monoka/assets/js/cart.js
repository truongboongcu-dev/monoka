
document.addEventListener('DOMContentLoaded', function () {
  // Tránh submit liên tục
  let submitting = false;

  // Tìm form cart chính
  const cartForm = document.querySelector('.woocommerce-cart-form');

  if (!cartForm) return;

  // Helper: click update button if exists, otherwise add hidden input then submit
  function submitCartForm() {
    if (submitting) return;
    submitting = true;

    // Try to click the update button (preferred — preserves WC behavior)
    const updateBtn = cartForm.querySelector('button[name="update_cart"], input[name="update_cart"]');
    if (updateBtn) {
      // Trigger click programmatically (some themes may rely on click event)
      updateBtn.click();
      // Fallback: ensure we reset submitting after short time in case click triggers navigation
      setTimeout(() => submitting = false, 2000);
      return;
    }

    // If no button, add hidden input named update_cart and submit
    let hidden = cartForm.querySelector('input[name="update_cart_hidden_for_js"]');
    if (!hidden) {
      hidden = document.createElement('input');
      hidden.type = 'hidden';
      hidden.name = 'update_cart';
      hidden.value = 'Update cart';
      hidden.setAttribute('data-temp', '1');
      cartForm.appendChild(hidden);
    }
    cartForm.submit();
    // safety unlock in 2s
    setTimeout(() => submitting = false, 2000);
  }

  // Click handler (event delegation) for +/- buttons
  cartForm.addEventListener('click', function (e) {
    // find minus
    const minus = e.target.closest('.cart-minus');
    const plus  = e.target.closest('.cart-add');

    if (!minus && !plus) return;

    // find related qty input (search upwards to cart item)
    const itemL = (minus || plus).closest('.cart-item-l');
    if (!itemL) return;
    // try common selectors: .qty or input[type="number"] within the cart item
    let qtyInput = itemL.querySelector('input.qty, input[type="number"][name^="cart["]');

    if (!qtyInput) return;

    // parse current
    let current = parseInt(qtyInput.value) || 0;

    // Determine min/max from attributes, fallback values
    const minAttr = qtyInput.getAttribute('min');
    const maxAttr = qtyInput.getAttribute('max');
    const stepAttr = qtyInput.getAttribute('step') || '1';

    const min = (minAttr !== null && minAttr !== '') ? parseInt(minAttr) : 1;
    const max = (maxAttr !== null && maxAttr !== '') ? parseInt(maxAttr) : 999999;
    const step = parseInt(stepAttr) || 1;

    if (minus) {
      if (current - step >= min) {
        qtyInput.value = current - step;
      } else {
        qtyInput.value = min;
      }
    } else if (plus) {
      if (current + step <= max) {
        qtyInput.value = current + step;
      } else {
        qtyInput.value = max;
      }
    }

    // Trigger input/change events so any listener notices the change
    qtyInput.dispatchEvent(new Event('input', { bubbles: true }));
    qtyInput.dispatchEvent(new Event('change', { bubbles: true }));

    // Submit the cart form to update quantities (this will include nonce already present)
    // Use a tiny debounce to allow consecutive clicks without spamming submits
    if (window._wcUpdateTimeout) clearTimeout(window._wcUpdateTimeout);
    window._wcUpdateTimeout = setTimeout(function () {
      submitCartForm();
    }, 250);

    // Prevent default click side-effects
    e.preventDefault();
  });
});



    let current = new Date();
    let selectedDateStr = ""; 

    function renderCalendar() {
        const daysElement = document.getElementById("days");
        const monthYear = document.getElementById("monthYear");

        const year = current.getFullYear();
        const month = current.getMonth();

        const firstDay = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();

        // 1. Mốc hôm nay
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        // 2. Mốc bị khóa (Hôm nay + 3 ngày)
        const blockedThreshold = new Date(today);
        blockedThreshold.setDate(today.getDate() + 3);

        monthYear.textContent = `Tháng ${month + 1} - ${year}`;
        daysElement.innerHTML = "";

        // Ô trống
        for (let i = 0; i < firstDay; i++) {
            daysElement.innerHTML += `<div class="blank"></div>`;
        }

        // Vòng lặp ngày
        for (let d = 1; d <= totalDays; d++) {
            let dayDiv = document.createElement("div");
            dayDiv.innerText = d;
            
            let checkDate = new Date(year, month, d);
            let currentDayStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;

            // --- A. LUÔN KIỂM TRA HÔM NAY ---
            // Dù có bị khóa hay không, nếu là hôm nay thì thêm class today
            if (checkDate.getTime() === today.getTime()) {
                dayDiv.classList.add("today");
            }

            // --- B. KIỂM TRA KHÓA ---
            if (checkDate <= blockedThreshold) {
                // Nếu nằm trong khoảng bị khóa (Quá khứ hoặc < 3 ngày tới)
                dayDiv.classList.add("disabled");
            } 
            else {
                // Nếu được phép chọn
                if (currentDayStr === document.getElementById('delivery_date').value) {
                    dayDiv.classList.add("selected");
                }

                dayDiv.onclick = function() {
                    document.querySelectorAll('.days div').forEach(el => el.classList.remove('selected'));
                    this.classList.add('selected');
                    document.getElementById('delivery_date').value = currentDayStr;
                    saveDateToSession(currentDayStr);
                };
            }

            daysElement.appendChild(dayDiv);
        }
    }

    function saveDateToSession(dateVal) {
        if (typeof jQuery !== 'undefined') {
            jQuery.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                data: { action: 'save_cart_delivery_date', delivery_date: dateVal },
                success: function(response) { console.log('Đã lưu ngày: ' + dateVal); }
            });
        }
    }

    document.getElementById("prev").onclick = () => { current.setMonth(current.getMonth() - 1); renderCalendar(); };
    document.getElementById("next").onclick = () => { current.setMonth(current.getMonth() + 1); renderCalendar(); };

    renderCalendar();

(function() {
    let clickTimer = null;

    document.addEventListener('click', function(event) {
        if (event.target.closest('.cart-button-d')) {
            if (clickTimer) clearTimeout(clickTimer);

            clickTimer = setTimeout(function() {
                location.reload();
            }, 2000);
        }
    });
})();

document.querySelectorAll('.Volume').forEach(volumeBox => {
    volumeBox.addEventListener('mouseleave', function() {
        // Kiểm tra nếu có ô input .qty-d bên trong thì mới thực thi
        const qtyInput = this.querySelector('.qty-d');
        
        if (qtyInput) {
            // Đợi 1 giây (1000ms) rồi tải lại trang
            setTimeout(() => {
                location.reload();
            }, 1000);
        }
    });
});

// 1. Chọn tất cả các phần tử có class progress-bar
const progressBars = document.querySelectorAll('.progress-bar');
const checkoutBtn = document.querySelector('.check-out-btn');
const checkValue = document.querySelector('.check-value');

// Biến cờ để kiểm tra xem có thanh nào chưa đạt 100% không
let isAnyIncomplete = false;

progressBars.forEach(bar => {
    // Lấy giá trị width từ style (ví dụ: "80%")
    const widthString = bar.style.width; 
    // Chuyển thành số để so sánh (ví dụ: 80)
    const widthValue = parseFloat(widthString);

    if (widthValue < 100) {
        isAnyIncomplete = true;
    }
});

// 2. Nếu có ít nhất 1 bar < 100%, thực hiện thêm class
if (isAnyIncomplete) {
    if (checkoutBtn) {
        checkoutBtn.classList.add('not-active');
    }
    if (checkValue) {
        checkValue.classList.add('not-active-note');
    }
}