<script>
    document.addEventListener("DOMContentLoaded", function() {

        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();
            inputId = 'image'
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
        document.getElementById('button-image-1').addEventListener('click', (event) => {
            event.preventDefault();
            inputId = 'image2'
            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

    let inputId = ''

    // set file link
    function fmSetLink(url) {
        document.getElementById('image_label').value = url;
    }
</script>
