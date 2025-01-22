function removeItem(id) {
    Swal.fire({
        title: 'آیا مطمئنید؟',
        text: "این عمل قابل بازگشت نخواهد بود!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله، حذف کن!',
        cancelButtonText: 'انصراف',
        customClass: {
            confirmButton: 'btn btn-primary me-3',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {
            Swal.fire({
                icon: 'success',
                title: 'حذف شد!',
                text: 'فایل شما حذف شد.',
                customClass: {
                    confirmButton: 'btn btn-success'
                },
                confirmButtonText: 'باشه'
            });
        }
    });
}
