<script src="https://cdn.tiny.cloud/1/t6gsuwemfyzbh6oifmteyfsxczlig5oxso5lmfq8llnk58dy/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
{{--<script src="/assets/admin/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>--}}
<script>
    tinymce.init({
        selector: '#adminEditor', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'preview importcss searchreplace autolink autosave save directionality  visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons lists',
        toolbar: 'undo redo | bold italic underline strikethrough | fontsizeselect formatselect | alignleft aligncenter alignright alignjustify numlist bullist | outdent indent | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl',
        language: 'fa',
        directionality: 'rtl',
        license_key: 'gpl',
        file_picker_types: "file image media",
        file_picker_callback(callback, value, meta) {
            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight

            tinymce.activeEditor.windowManager.openUrl({
                url: '/file-manager/tinymce5',
                title: '',
                width: x * 0.8,
                height: y * 0.8,
                onMessage: (api, message) => {
                    callback(message.content, {text: message.text})
                }
            })
        }
    });
</script>

