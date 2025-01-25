axios.interceptors.request.use(function (config) {
    $.blockUI({
        message:
            '<div class="d-flex justify-content-center"><p class="mb-0">لطفا صبر کنید ...</p> <div class="sk-wave m-0 ms-2"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div> </div>',
        timeout: 1000,
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

    return config
});
axios.get('carts/all')
    .then(function (response) {
        Highcharts.dateFormats = {
            'a': function (ts) {
                return new persianDate(ts).format('dddd')
            },
            'A': function (ts) {
                return new persianDate(ts).format('dddd')
            },
            'd': function (ts) {
                return new persianDate(ts).format('DD')
            },
            'e': function (ts) {
                return new persianDate(ts).format('D')
            },
            'b': function (ts) {
                return new persianDate(ts).format('MMMM')
            },
            'B': function (ts) {
                return new persianDate(ts).format('MMMM')
            },
            'm': function (ts) {
                return new persianDate(ts).format('MM')
            },
            'y': function (ts) {
                return new persianDate(ts).format('YY')
            },
            'Y': function (ts) {
                return new persianDate(ts).format('YYYY')
            },
            'W': function (ts) {
                return new persianDate(ts).format('ww')
            }
        };
        var chart = new Highcharts.Chart({

            chart: {
                renderTo: 'orderSummaryChart',
                zoomType: 'x',
                panning: true,
                panKey: 'shift'
            },
            title: {
                text: 'سبد خرید ها',
            },
            xAxis: {
                type: 'datetime',
            },
            lang: {
                loading: 'در حال بارگذاری...',
                exportButtonTitle: "خروجی گرفتن",
                printButtonTitle: "پرینت گرفتن",
                rangeSelectorFrom: "از",
                rangeSelectorTo: "تا",
                downloadPNG: 'دانلود PNG',
                downloadJPEG: 'دانلود JPEG',
                downloadPDF: 'دانلود PDF',
                downloadSVG: 'دانلود SVG',
                downloadCSV: 'دانلود CSV',
                downloadXLS: 'دانلود اکسل',
            },

            rangeSelector: {
                inputDateFormat: ' %Y/%m/%e',
                enabled: true,
                buttons: [{
                    type: 'month',
                    count: 1,
                    text: 'ماهانه',
                    title: 'نمایش به صورت ماهانه'
                }, {
                    type: 'month',
                    count: 3,
                    text: '3 ماهه',
                    title: 'View 3 months'
                }, {
                    type: 'month',
                    count: 6,
                    text: '6 ماهه',
                    title: 'نمایش به صورت 6 ماهه'
                }, {
                    type: 'year',
                    count: 1,
                    text: 'سالانه',
                    title: 'نمایش به صورت سالانه'
                }, {
                    type: 'all',
                    text: ' همه',
                    title: 'نمایش همه'
                }]
            },

            plotOptions: {
                series: {
                    showInNavigator: true,
                    marker: {
                        symbol: 'circle',
                        fillColor: '#FFFFFF',
                        enabled: true,
                        radius: 2.5,
                        lineWidth: 1,
                        lineColor: null
                    }
                },
            },
            tooltip: {
                useHTML: true,
                outside: true,
                fontFamily: "primary-font",
                formatter: function () {
                    return this.points.reduce(function (s, point) {
                        return s + "<br/>" + point.series.name + " : " + point.y;
                    }, "<b class='testme'>" + Highcharts.dateFormat("%Y/%m/%e", new Date(this.x)) + "</b>");
                },
                shared: true
            },
            series: [
                {
                    name: '<span class="">مجموع سبد خرید ها</span>',
                    data: response.data.data,
                    pointStart: Date.UTC(parseInt(response.data.start_date.year), parseInt(response.data.start_date.month), parseInt(response.data.start_date.day))
                },
                {
                    name: '<span class="">تعداد سبد خرید ها</span>',
                    data: response.data.carts_count,
                    pointStart: Date.UTC(parseInt(response.data.start_date.year), parseInt(response.data.start_date.month), parseInt(response.data.start_date.day))
                }
            ]
        });
    })
