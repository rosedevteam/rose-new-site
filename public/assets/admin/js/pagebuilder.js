
import fa from '/assets/admin/js/grapesjs/fa.js';

const editor = grapesjs.init({
    storageManager:false,
    canvas: {
        styles: [
            '/assets/front/css/icons/bootstrap-icons/font/bootstrap-icons.min.css',
            '/assets/front/vendor/owl-carousel/owl.carousel.css',
            '/assets/admin/grapesjs/css/grapes.min.css',
            '/assets/front/css/app.css',
        ],
        scripts : [
            '/assets/front/vendor/owl-carousel/owl.carousel.js',
            '/assets/front/js/bootstrap/bootstrap.min.js',
            '/assets/front/js/bootstrap/popper.min.js',
            '/assets/front/js/jquery-ui.min.js',
            '/assets/front/js/jquery.js',
            '/assets/front/js/app.js',
        ]
    },
    container : '#gjs',
    fromElement: true,

    plugins: [
        'grapesjs-parser-postcss',
        'gjs-plugin-ckeditor' ,
    ],

    pluginsOpts: {
        'gjs-plugin-ckeditor': {
            position: 'right',
            options: {
                startupFocus: true,
                language: 'fa',
                extraAllowedContent: '*(*);*{*}', // Allows any class and any inline style
                allowedContent: true, // Disable auto-formatting, class removing, etc.
                enterMode: CKEDITOR.ENTER_BR,
                extraPlugins: 'sharedspace,justify,colorbutton,panelbutton,font,format,list,tabletools,table,tableselection',
                toolbar: [
                    { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                    { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                    { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                    '/',
                    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                    { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                    { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                    '/',
                    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                ],
                i18n: {
                    // locale: 'fa', // default locale
                    // detectLocale: false, // by default, the editor will detect the language
                    // localeFallback: 'fa', // default fallback
                    messages: {fa},
                }
            }
        }
    },
    assetManager: {
        storageType  	: 'local',
        storeOnChange  : true,
        storeAfterUpload  : true,
        upload: 'uploads',        //for temporary storage
        assets    	: [ ],
        uploadFile: function(e) {
            var files = e.dataTransfer ? e.dataTransfer.files : e.target.files;
            var formData = new FormData();
            for(var i in files){
                formData.append('file-'+i, files[i]) //containing all the selected images from local
            }
            $.ajax({
                url: '/uploader',
                type: 'POST',
                data: formData,
                contentType:false,
                crossDomain: true,
                dataType: 'json',
                mimeType: "multipart/form-data",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData:false,
                success: function(result){
                    var myJSON = [];
                    $.each( result['data'], function( key, value ) {
                        myJSON[key] = value;
                    });
                    var images = myJSON;
                    editor.AssetManager.add(images); //adding images to asset manager of GrapesJS
                }
            });
        },
    },
});

editor.getWrapper().addClass("gjs-wrapper");

editor.Css.setRule('.gjs-wrapper', {
    direction: "rtl"
});

editor.Panels.addButton
('options',
    [{
        id: 'back',
        className: 'fa fa-arrow-left',
        command: 'back',
        attributes: {title: 'بازگشت'}
    }]
);

// Add the command
editor.Commands.add
('save-db',
    {
        run: function(editor, sender)
        {
            sender && sender.set('active', 0); // turn off the button
            editor.store();

            var htmldata = editor.getHtml();
            var cssdata = editor.getCss();
            var page_id = document.getElementById('page-id');
            axios.post(`/kara-lux/pages/${page_id.value}/update` , {
                body: htmldata
            })
                .then(res => success())
            function success() {
                Swal.fire({
                    icon: 'success',
                    title: 'به روز رسانی موفق',
                    text: 'به روز رسانی با موفقیت انجام شد',
                    confirmButtonText: 'باشه'
                })
            }
        }
    });
// Add the command
editor.Commands.add
('back',
    {
        run: function(editor, sender)
        {
            var page_id = document.getElementById('page-id');
            sender && sender.set('active', 0); // turn off the button
            window.location.replace(`/kara-lux/pages/${page_id.value}/edit`);
        }
    });
editor.BlockManager.add('rose-call-to-action', {
    label: 'کال تو اکشن',
    content:`
        <div class="call-to-action-single-product br-default d-flex flex-column align-items-center justify-content-center g-4">
            <img src="/uploads/Headphones-Customer-support.svg" alt="">
            <h3 class="title text-white">تماس با کارشناسان</h3>
            <p class="desc text-white">ارتباط با کارشناسان ما از طریق تماس تلفنی</p>
            <a href="tel:02191691548" class="btn btn-light">021-91691548</a>
        </div>
    `
});

editor.BlockManager.add('rose-container', {
    label: 'کانتینر',
    content:`
        <div class="container">
        <div class="row">
        کانتینر
</div>
</div>
    `
});

editor.BlockManager.add('rose-2-columns', {
    label: 'ردیف ۲ ستونه',
    content:`
        <div class="row">
        <div class="col-md-6">
        <p>ردیف اول</p>
</div>
        <div class="col-md-6">
        <p>
        ردیف دوم
</p>
</div>
        </div>`
});

editor.BlockManager.add('rose-space', {
    label: 'فاصله',
    activate: true,
    content:`
        <div class="row my-4">

</div>
        </div>`
});

editor.BlockManager.add('rose-text', {
    label: 'متن ساده',
    content:`
    <div>
    <p>
    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
</p>
</div>
        `
});
editor.BlockManager.add('rose-title', {
    label: 'عنوان با تصویر',
    content:`
   <div class="title-box no-line">
            <div class="title-wrapper">
                    <img src="/uploads/comment-woo.svg" alt="">

                <h3 class="title title-line">
                    عنوان
                </h3>
            </div>
        </div>
        `
});

