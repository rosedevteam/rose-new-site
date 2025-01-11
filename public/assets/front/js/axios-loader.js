axios.interceptors.request.use(function (config) {
    $.blockUI({
        message: `<div class="spinner-border text-white" role="status">
                    <span class="visually-hidden">در حال بارگذاری ...</span>
                  </div>`,
        css: {
            backgroundColor: 'transparent',
            color: '#fff',
            border: '0',
            width: '80%'
        },
        overlayCSS: {
            opacity: 0.5
        }
    });
    return config;
}, function (error) {
    $.unblockUI();
    return Promise.reject(error);
});

axios.interceptors.response.use(function (response) {
    $.unblockUI();
    return response;
}, function (error) {
    $.unblockUI();
    return Promise.reject(error);
});
