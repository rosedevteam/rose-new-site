<script>
    document.addEventListener("DOMContentLoaded", function() {

        document.getElementById('button-image-1').addEventListener('click', (event) => {
            event.preventDefault();

            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

    // set file link
    function fmSetLink(url) {
        document.getElementById('image_label_1').value = url;
    }
</script>
