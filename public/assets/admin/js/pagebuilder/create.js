import fa from '/assets/admin/js/grapesjs/fa.js';

const editor = grapesjs.init({
    storageManager:false,
    canvas: {
        styles: [
            '/assets/front/css/icons/bootstrap-icons/font/bootstrap-icons.min.css',
            '/assets/front/vendor/owl-carousel/owl.carousel.css',
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
    i18n: {
        locale: 'fa', // default locale
        // detectLocale: true, // by default, the editor will detect the language
        // localeFallback: 'en', // default fallback
        // messages: { it, tr },
    },
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
        id: 'save-db',
        className: 'fa fa-floppy-o',
        command: 'save-db',
        attributes: {title: 'Save DB'}
    }]
);
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
            const adminPrefix = $("meta[name='admin-prefix']").attr("content");
            axios.post(`/${adminPrefix}/pagebuilder`, {
                content: htmldata,
                pagebuilder_type: $('#pagebuilder_type').val(),
                pagebuilder_id: $('#pagebuilder_id').val(),
            })
                .then(res => success(res))
                .catch(err => failed(err))
            function success(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'موفق',
                    text: res.data.message,
                    confirmButtonText: 'باشه'
                })
                window.location.replace(res.data.redirect)
            }
            function failed(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'خطا',
                    text: err.data.message,
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

editor.BlockManager.add('rose-2-columns-1', {
    label: 'ردیف ۲ ستونه طرح ۱',
    content:`
        <div class="row">
        <div class="col-md-4">
        <p>ردیف اول</p>
</div>
        <div class="col-md-8">
        <p>
        ردیف دوم
</p>
</div>
        </div>`
});


editor.BlockManager.add('rose-2-image', {
    label: 'تصویر',
    content:`
    <img src="#">
        `
});

editor.BlockManager.add('rose-2-video', {
    label: 'ویدیو',
    content:`
    <video controls src="#">
        `
});

editor.BlockManager.add('rose-3-columns', {
    label: 'ردیف ۳ ستونه',
    content:`
        <div class="row">
        <div class="col-md-4">
        <p>ردیف اول</p>
</div>
        <div class="col-md-4">
        <p>
        ردیف دوم
</p>
</div>
<div class="col-md-4">
        <p>
        ردیف سوم
</p>
</div>
        </div>`
});

editor.BlockManager.add('rose-4-columns', {
    label: 'ردیف ۴ ستونه',
    content:`
        <div class="row">
        <div class="col-md-3">
        <p>ردیف اول</p>
</div>
        <div class="col-md-3">
        <p>
        ردیف دوم
</p>
</div>
<div class="col-md-3">
        <p>
        ردیف سوم
</p>
</div>
<div class="col-md-3">
        <p>
        ردیف چهارم
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

editor.BlockManager.add('rose-7-years-road', {
    label: 'مسیر ۷ ساله',
    content:`
   <div class="hex-container">
        <div class="hex-row">
            <a href="#daramad" id="daramad-item">
                <div class="hexagon">کسب درآمد بیشتر</div>
            </a>
            <a href="#barname" id="barname-item">
                <div class="hexagon">برنامه ریزی و اولویت بندی</div>
            </a>
        </div>
        <div class="hex-row">
            <a href="#varzesh" id="varzesh-item">
                <div class="hexagon">ورزش جسم و ذهن</div>
            </a>
            <a href="#amoozesh" id="amoozesh-item">
                <div class="hexagon hex-center">آموزش</div>
            </a>
            <a href="#moshavere" id="moshavere-item">
                <div class="hexagon">مشاوره و راهنما</div>
            </a>
        </div>
        <div class="hex-row">
            <a href="#ijad" id="ijad-item">
                <div class="hexagon">ایجاد درآمد غیرفعال</div>
            </a>
            <a href="#hazine" id="hazine-item">
                <div class="hexagon">کنترل هزینه و مخارج</div>
            </a>
        </div>
    </div>
        `
});

editor.BlockManager.add('rose-icon-box-1', {
    label: 'آیکون باکس ۱',
    content:`
    <div class="icon-box-about">
                    <img src="/uploads/teacher.svg" alt="">

                    <div class="content p-3 mt-3 br-default">
                        <p>
                            بیش از 15 هزار دانش پذیر در طول مسیر خدمت رسانی
                        </p>
                    </div>
                </div>
        `
});

editor.BlockManager.add('rose-faq', {
    label: 'سوالات متداول',
    content:`
            <div class="d-flex align-items-center justify-content-center">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item py-2 br-default">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                آیا دوره ها حضوری هستند؟
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                دوره ها به صورت مجازی و با فرمت ویدئو های ضبط شده در بستر اسپات پلیر هستند. این فایل ها
                                بعد از ثبت نام بدون محدودیت زمانی در دسترس شما قرار خواهد گرفت.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item py-2 br-default">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                شرایط عضویت در کانال جامع چیست؟
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                کانال جامع “بررسی و تحلیل سهام” مخصوص دانش پذیران دوره “FIS” و “افزایش سرمایه” می‌باشد.
                                چون سطح مطالب کانال بالا است و اگر آموزش ندیده باشید متوجه مطالب کانال نخواهید شد. جناب
                                دکتر خسروانی به صورت روزانه در کانال فعالیت می‌کنند و همه‌ی سهم ها رو تحلیل می‌کنند.
                                مشاوره مستقیم با خود جناب دکتر هست و شما می‌توانید طبق توصیه ها و راهنمایی های ایشون با
                                آرامش سهم خرید و فروش کنید و از سرمایه گذاری در بازار بورس لذت ببرید.
                            </div>
                        </div>
                    </div>

                </div>
        </div>

        `
});



editor.BlockManager.add('rose-full-page-single-product-free', {
    label: 'محصول رایگان فول',
    content:`
     <!--top nav product-->
        <div class="single-product-nav my-5">
            <ul class="p-0">
                <li>
                    <a href="#desc">توضیحات</a>
                </li>
                <li>
                    <a href="#preview">
                        ویدیو معرفی
                    </a>
                </li>
                <li>
                    <a href="#lessons">
                        سرفصل ها
                    </a>
                </li>
                <li>
                    <a href="#teacher">
                        مدرس
                    </a>
                </li>
                <li>
                    <a href="#faq">
                        سوالات متداول
                    </a>
                </li>
                <li>
                    <a href="#comments">
                        نظرات
                    </a>
                </li>

            </ul>
        </div>
        <!--top nav product wns-->

        <div class="row gx-5">
            <h1 class="mb-3">مدیریت زندگی مالی (FLM)</h1>
            <div class="col-md-4 ">
                <div class="bg-white br-default h-100">
                    <ul class=" rose-playlist-course ">
                        <li>
                            <a class="select-video" data-video-src="https://roseoj.com/product/%d8%af%d9%88%d8%b1%d9%87-%d9%85%d9%82%d8%af%d9%85%d8%a7%d8%aa%db%8c-%d8%a8%d9%88%d8%b1%d8%b3/">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                                     fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M12.764 10.5676L17.293 13.2463C17.8659 13.5846 17.8659 14.4141 17.293 14.7525L12.764 17.4311C12.1807 17.7765 11.4434 17.3553 11.4434 16.6775V11.3213C11.4434 10.6435 12.1807 10.2223 12.764 10.5676V10.5676Z"
                                          stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M21 24.5H7C5.06683 24.5 3.5 22.9332 3.5 21V7C3.5 5.06683 5.06683 3.5 7 3.5H21C22.9332 3.5 24.5 5.06683 24.5 7V21C24.5 22.9332 22.9332 24.5 21 24.5Z"
                                          stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                    <script xmlns=""/>
                                </svg>
                                شروع مسیر تحلیل بنیادی بورس ( مقدمه )
                            </a>
                        </li>
                        <li>
                            <a class="select-video" data-video-src="https://karawebs.com/farshad">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                                     fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M12.764 10.5676L17.293 13.2463C17.8659 13.5846 17.8659 14.4141 17.293 14.7525L12.764 17.4311C12.1807 17.7765 11.4434 17.3553 11.4434 16.6775V11.3213C11.4434 10.6435 12.1807 10.2223 12.764 10.5676V10.5676Z"
                                          stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M21 24.5H7C5.06683 24.5 3.5 22.9332 3.5 21V7C3.5 5.06683 5.06683 3.5 7 3.5H21C22.9332 3.5 24.5 5.06683 24.5 7V21C24.5 22.9332 22.9332 24.5 21 24.5Z"
                                          stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                    <script xmlns=""/>
                                </svg>
                                هدف از سرمایه گذاری در بورس
                            </a>
                        </li>
                        <li>
                            <a class="select-video" data-video-src="https://roseoj.com/product/%d8%af%d9%88%d8%b1%d9%87-%d9%85%d9%82%d8%af%d9%85%d8%a7%d8%aa%db%8c-%d8%a8%d9%88%d8%b1%d8%b3/">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                                     fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M12.764 10.5676L17.293 13.2463C17.8659 13.5846 17.8659 14.4141 17.293 14.7525L12.764 17.4311C12.1807 17.7765 11.4434 17.3553 11.4434 16.6775V11.3213C11.4434 10.6435 12.1807 10.2223 12.764 10.5676V10.5676Z"
                                          stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M21 24.5H7C5.06683 24.5 3.5 22.9332 3.5 21V7C3.5 5.06683 5.06683 3.5 7 3.5H21C22.9332 3.5 24.5 5.06683 24.5 7V21C24.5 22.9332 22.9332 24.5 21 24.5Z"
                                          stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                    <script xmlns=""/>
                                </svg>
                                چرا بورس و مقایسه با سایر بازارها
                            </a>
                        </li>
                        <li><a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                                 fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M12.764 10.5676L17.293 13.2463C17.8659 13.5846 17.8659 14.4141 17.293 14.7525L12.764 17.4311C12.1807 17.7765 11.4434 17.3553 11.4434 16.6775V11.3213C11.4434 10.6435 12.1807 10.2223 12.764 10.5676V10.5676Z"
                                      stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M21 24.5H7C5.06683 24.5 3.5 22.9332 3.5 21V7C3.5 5.06683 5.06683 3.5 7 3.5H21C22.9332 3.5 24.5 5.06683 24.5 7V21C24.5 22.9332 22.9332 24.5 21 24.5Z"
                                      stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <script xmlns=""/>
                            </svg>
                            چرا بازدهی بالاست</a>
                        </li>
                        <li><a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                                 fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M12.764 10.5676L17.293 13.2463C17.8659 13.5846 17.8659 14.4141 17.293 14.7525L12.764 17.4311C12.1807 17.7765 11.4434 17.3553 11.4434 16.6775V11.3213C11.4434 10.6435 12.1807 10.2223 12.764 10.5676V10.5676Z"
                                      stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M21 24.5H7C5.06683 24.5 3.5 22.9332 3.5 21V7C3.5 5.06683 5.06683 3.5 7 3.5H21C22.9332 3.5 24.5 5.06683 24.5 7V21C24.5 22.9332 22.9332 24.5 21 24.5Z"
                                      stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <script xmlns=""/>
                            </svg>
                            چرا بازدهی بالاست</a>
                        </li>
                        <li><a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                                 fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M12.764 10.5676L17.293 13.2463C17.8659 13.5846 17.8659 14.4141 17.293 14.7525L12.764 17.4311C12.1807 17.7765 11.4434 17.3553 11.4434 16.6775V11.3213C11.4434 10.6435 12.1807 10.2223 12.764 10.5676V10.5676Z"
                                      stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M21 24.5H7C5.06683 24.5 3.5 22.9332 3.5 21V7C3.5 5.06683 5.06683 3.5 7 3.5H21C22.9332 3.5 24.5 5.06683 24.5 7V21C24.5 22.9332 22.9332 24.5 21 24.5Z"
                                      stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <script xmlns=""/>
                            </svg>
                            چرا بازدهی بالاست</a>
                        </li>
                        <li><a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                                 fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M12.764 10.5676L17.293 13.2463C17.8659 13.5846 17.8659 14.4141 17.293 14.7525L12.764 17.4311C12.1807 17.7765 11.4434 17.3553 11.4434 16.6775V11.3213C11.4434 10.6435 12.1807 10.2223 12.764 10.5676V10.5676Z"
                                      stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M21 24.5H7C5.06683 24.5 3.5 22.9332 3.5 21V7C3.5 5.06683 5.06683 3.5 7 3.5H21C22.9332 3.5 24.5 5.06683 24.5 7V21C24.5 22.9332 22.9332 24.5 21 24.5Z"
                                      stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <script xmlns=""/>
                            </svg>
                            چرا بازدهی بالاست</a>
                        </li>
                        <li><a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                                 fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M12.764 10.5676L17.293 13.2463C17.8659 13.5846 17.8659 14.4141 17.293 14.7525L12.764 17.4311C12.1807 17.7765 11.4434 17.3553 11.4434 16.6775V11.3213C11.4434 10.6435 12.1807 10.2223 12.764 10.5676V10.5676Z"
                                      stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M21 24.5H7C5.06683 24.5 3.5 22.9332 3.5 21V7C3.5 5.06683 5.06683 3.5 7 3.5H21C22.9332 3.5 24.5 5.06683 24.5 7V21C24.5 22.9332 22.9332 24.5 21 24.5Z"
                                      stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <script xmlns=""/>
                            </svg>
                            چرا بازدهی بالاست</a>
                        </li>
                        <li><a href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                                 fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M12.764 10.5676L17.293 13.2463C17.8659 13.5846 17.8659 14.4141 17.293 14.7525L12.764 17.4311C12.1807 17.7765 11.4434 17.3553 11.4434 16.6775V11.3213C11.4434 10.6435 12.1807 10.2223 12.764 10.5676V10.5676Z"
                                      stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M21 24.5H7C5.06683 24.5 3.5 22.9332 3.5 21V7C3.5 5.06683 5.06683 3.5 7 3.5H21C22.9332 3.5 24.5 5.06683 24.5 7V21C24.5 22.9332 22.9332 24.5 21 24.5Z"
                                      stroke="#0FABB5" stroke-width="1.75" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <script xmlns=""/>
                            </svg>
                            چرا بازدهی بالاست</a>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="col-md-8">
                <video class="rose-video-player" width="100%" src="" controls></video>
            </div>
        </div>


        <div class="my-5">
            <div class="row">
                <div class="col-md-3">
                    <div class="icon-box-inline">
                        <div class="content">
                            <h3 class="title">روانشاسی مالی</h3>
                            <p class="desc">پــــوشش کامل مـــسائل</p>
                        </div>
                        <img src="assets/images/lamp-spark.svg" alt="">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="icon-box-inline">
                        <div class="content">
                            <h3 class="title">روانشاسی مالی</h3>
                            <p class="desc">پــــوشش کامل مـــسائل</p>
                        </div>
                        <img src="assets/images/lamp-spark.svg" alt="">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="icon-box-inline">
                        <div class="content">
                            <h3 class="title">روانشاسی مالی</h3>
                            <p class="desc">پــــوشش کامل مـــسائل</p>
                        </div>
                        <img src="assets/images/lamp-spark.svg" alt="">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="icon-box-inline">
                        <div class="content">
                            <h3 class="title">روانشاسی مالی</h3>
                            <p class="desc">پــــوشش کامل مـــسائل</p>
                        </div>
                        <img src="assets/images/lamp-spark.svg" alt="">

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="bg-white p-4 br-default">
                    <p>محتوا</p>
                </div>

            </div>
            <div class="col-md-4">
                <div class="bg-white p-4 br-default single-product-sidebar">
                    <img src="assets/images/fis.jpg" alt="" class="br-default">

                    <div class="product-sidebar-details mt-4">
                        <h3>دوره مستر FIS</h3>
                        <p class="text-justify">
                            سیستم معاملاتی FIS (Financial Investing System) یک سیستم منحصر به فرد، توسط دکتر بردیا
                            خسروانی،
                            مدرس برجسته بازارهای مالی با 15 سال سابقه ی درخشان، طراحی شده است تا راه را برای
                            سرمایه‌گذاران
                            در جهت کسب سود پایدار و کم‌ریسک، ایجاد درآمد غیرفعال و بازنشستگی زودهنگام در بورس ایران
                            هموار
                            کند.

                        </p>
                        <!--Add To Cart Button-->
                        <a href="#" class="btn btn-default w-100 mt-4">ثبت نام در دوره</a>
                        <!--Add To Cart Button End-->
                    </div>
                </div>
            </div>
        </div>
        `
});



