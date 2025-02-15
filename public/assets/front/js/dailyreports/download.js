function downloadReport(url) {
    axios.get(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
        .then(function (res) {
            if (res.data.message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "موفق",
                    text: res.data.message
                });
            }
            let link = document.createElement("a");
            link.setAttribute('download', name);
            link.href = res.data.url;
            document.body.appendChild(link);
            link.click();
            link.remove();
            $.unblockUI();
        })
        .catch(error => {
            console.error('Error:', error.response?.data?.error ?? 'Download failed');
        });
}
