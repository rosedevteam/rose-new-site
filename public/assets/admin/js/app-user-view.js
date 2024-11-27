/**
 * App User View - Suspend User Script
 */
'use strict';

(function () {
  const suspendUser = document.querySelector('.suspend-user');

  // Suspend User javascript
  if (suspendUser) {
    suspendUser.onclick = function () {
      Swal.fire({
        title: 'آیا اطمینان دارید؟',
        text: "قادر به بازگردانی کاربر نخواهید بود!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله، معلق کن!',
        cancelButtonText: 'انصراف',
        customClass: {
          confirmButton: 'btn btn-primary me-2',
          cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
          Swal.fire({
            icon: 'success',
            title: 'معلق شد!',
            text: 'کاربر معلق شد.',
            confirmButtonText: 'باشه',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: 'لغو شد',
            text: 'معلق سازی کاربر لغو شد :)',
            confirmButtonText: 'باشه',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    };
  }
})();
