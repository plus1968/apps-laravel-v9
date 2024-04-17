@include('playground.templates.header')
@php
    $Urlmyhouse = 'https://route.plustrap.com/public/fileall/myhouse/';
@endphp
<style>
    @import url('https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&family=Noto+Sans+Thai:wght@100;200;300;400;500;600;700;800;900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");

    body {
        background: #f5f5f5;
        font-family: 'Noto Sans Thai', sans-serif;
        color: #333;
    }

    div .main-des {
        padding: 5px;
    }

    .card {
        background: none;
        border:0;
    }

    .card:hover {
        background: #FFFFFF;
        cursor: pointer;
    }
    .km-card{
        padding: 10px;
        background: #D7E5CA;
        border-radius: 13px; 
        font-size: larger; 
        color: #333;
        text-align: left;
    }
    .km-card-main{
        padding: 10px;
        background: #8EACCD;
        border-radius: 13px; 
        font-size: x-large; 
        color: #333;
    }

    #map {
        padding: 0;
        margin: 0;
        height: 100%;
    }

    #map #map_layers #map_gc #map_graphics_layer {
        display: none !important;
    }

    #div-block-setStyle-customCallout {
        right: 20px;
        top: 20px;
        background-color: #FFFFFF;
        border: 1px solid #2D2F37;
        border-radius: 3px;
        padding: 15px;
        position: fixed;
        width: 315px;
        vertical-align: middle;
        font-size: 14px;
        z-index: 1000;
    }

    #div-block-setStyle-customCallout-Panel {
        border: solid 1px #FFD300;
        padding: 5px;
    }


    .slick-slider .slick-prev,
    .slick-slider .slick-next {
        z-index: 100;
        font-size: 2.5em;
        height: 40px;
        width: 40px;
        margin-top: -20px;
        color: #b7b7b7;
        position: absolute;
        top: 50%;
        text-align: center;
        color: #000;
        opacity: 0.3;
        transition: opacity 0.25s;
        cursor: pointer;
    }

    .slick-slider .slick-prev:hover,
    .slick-slider .slick-next:hover {
        opacity: 0.65;
    }

    .slick-slider .slick-prev {
        left: 0;
    }

    .slick-slider .slick-next {
        right: 0;
    }

    #detail .product-images {
        width: 100%;
        margin: 0 auto;
        border: 1px solid #eee;
    }

    #detail .product-images li,
    #detail .product-images figure,
    #detail .product-images a,
    #detail .product-images img {
        display: block;
        outline: none;
        border: none;
    }

    #detail .product-images .main-img-slider figure {
        margin: 0 auto;
        padding: 0 2em;
    }

    #detail .product-images .main-img-slider figure a {
        cursor: pointer;
        cursor: -webkit-zoom-in;
        cursor: -moz-zoom-in;
        cursor: zoom-in;
    }

    #detail .product-images .main-img-slider figure a img {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }

    #detail .product-images .thumb-nav {
        margin: 0 auto;
        padding: 20px 10px;
        max-width: 600px;
    }

    #detail .product-images .thumb-nav.slick-slider .slick-prev,
    #detail .product-images .thumb-nav.slick-slider .slick-next {
        font-size: 1.2em;
        height: 20px;
        width: 26px;
        margin-top: -10px;
    }

    #detail .product-images .thumb-nav.slick-slider .slick-prev {
        margin-left: -30px;
    }

    #detail .product-images .thumb-nav.slick-slider .slick-next {
        margin-right: -30px;
    }

    #detail .product-images .thumb-nav li {
        display: block;
        margin: 0 auto;
        cursor: pointer;
    }

    #detail .product-images .thumb-nav li img {
        display: block;
        width: 100%;
        max-width: 75px;
        margin: 0 auto;
        border: 2px solid transparent;
        -webkit-transition: border-color 0.25s;
        -ms-transition: border-color 0.25s;
        -moz-transition: border-color 0.25s;
        transition: border-color 0.25s;
    }

    #detail .product-images .thumb-nav li:hover,
    #detail .product-images .thumb-nav li:focus {
        border-color: #999;
    }

    #detail .product-images .thumb-nav li.slick-current img {
        border-color: #d12f81;
    }
</style>
<div class='row'>
    <div class="col-md-12">
        <div class="card p-4 mt-3 mb-3" 
        style="background: #3468C0;
        border-radius: 13px;
        color: #fff;
        border-bottom: 4px solid #333;">

            <h2 class="mt-3 mb-3">ขายบ้าน ทาวน์เฮาส์ 2 ชั้น</h2>
            <h3 class="mt-3 mb-3 text-right">฿ 2,100,000</h3>
        </div>
    </div>
</div>
<div class='row'>
    <div class="col-md-12">
        <div class="card p-2 mt-3 mb-3">
            <div class="card-body">
                <div class="row mt-3 mb-3 main-des">
                    <div class="col-lg-3 col-md-3 col-sm-6 text-center" style="border-right: 2px solid #333;">
                        <img src="{{ $Urlmyhouse }}area.png" alt="PNG Image" width="40">
                        <p class="mt-1">119 ตาราวา<br>(120 ตารางเมตร)</p>

                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 text-center" style="border-right: 2px solid #333;">
                        <img src="{{ $Urlmyhouse }}bed.png" alt="PNG Image" width="40">
                        <p class="mt-1">2-3 ห้องนอน</p>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 text-center" style="border-right: 2px solid #333;">
                        <img src="{{ $Urlmyhouse }}shower.png" alt="PNG Image" width="40">
                        <p class="mt-1">2 ห้องน้ำ</p>

                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                        <img src="{{ $Urlmyhouse }}car.png" alt="PNG Image" width="40">
                        <p class="mt-1">1 ที่จอด</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class="col-md-12">
        <div class="card p-2">
            <section id="detail">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <!-- Product Images & Alternates -->
                            <div class="product-images demo-gallery">
                                <!-- Begin Product Images Slider -->
                                <div class="main-img-slider">
                                    <a data-fancybox="gallery" href="http://via.placeholder.com/1920x1280"><img
                                            src="http://via.placeholder.com/840x480" class="img-fluid"></a>
                                    <a data-fancybox="gallery" href="http://via.placeholder.com/1920x1280"><img
                                            src="http://via.placeholder.com/840x480" class="img-fluid"></a>
                                    <a data-fancybox="gallery" href="http://via.placeholder.com/1920x1280"><img
                                            src="http://via.placeholder.com/840x480" class="img-fluid"></a>
                                    <a data-fancybox="gallery" href="http://via.placeholder.com/1920x1280"><img
                                            src="http://via.placeholder.com/840x480" class="img-fluid"></a>
                                    <a data-fancybox="gallery" href="http://via.placeholder.com/1920x1280"><img
                                            src="http://via.placeholder.com/840x480" class="img-fluid"></a>
                                    <a data-fancybox="gallery" href="http://via.placeholder.com/1920x1280"><img
                                            src="http://via.placeholder.com/840x480" class="img-fluid"></a>
                                </div>
                                <!-- End Product Images Slider -->

                                <!-- Begin product thumb nav -->
                                <ul class="thumb-nav">
                                    <li><img src="http://via.placeholder.com/72x50"></li>
                                    <li><img src="http://via.placeholder.com/72x50"></li>
                                    <li><img src="http://via.placeholder.com/72x50"></li>
                                    <li><img src="http://via.placeholder.com/72x50"></li>
                                    <li><img src="http://via.placeholder.com/72x50"></li>
                                </ul>
                                <!-- End product thumb nav -->
                            </div>
                            <!-- End Product Images & Alternates -->

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<div class='row mt-2'>
    <div class="col-md-12">
        <div class="card p-2 mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 p-4" style="border-right: 2px solid #333;">
                        <h5 class="mt-1 km-card-main"><u>รายละเอียดบ้าน</u></h5>
                        <p class="mt-1 km-card">- ขายบ้านตามสภาพ รีโนเวทใหม่ชั้น 2</p>
                        <p class="mt-1 km-card">- อายุบ้าน 20+ ปี</p>
                        <p class="mt-1 km-card">- ชื่อหมู่บ้าน รามอินทรา 71 โครงการ 1</p>
                        <h5 class="mt-1 km-card-main"><u>รายละเอียดภายในบ้าน</u></h5>
                        <p class="mt-1 km-card">- มีเฟอร์นิเจอร์ เช่น โต๊ะวางทีวี, ชั้นวางของ, ตู้เสื้อผ้า</p>
                        <p class="mt-1 km-card">- แอร์ 2 ตัว อายุการใช้งาน 2-3 ปี</p>
                        <p class="mt-1 km-card">- เครื่องทำน้ำอุ่น 1 ตัว อายุการใช้งาน 1-2 ปี</p>
                        <h5 class="mt-1 km-card-main"><u>รายละเอียดค่าใช้จ่าย</u></h5>
                        <p class="mt-1 km-card">- ค่าโอนบ้านฟรี</p>
                    </div>
                    <div class="col-md-6 p-4 text-center">
                        <h5 class="mt-1 km-card-main"><u>สถานที่ใกล้เคียง</u></h5>
                        <p class="mt-1 km-card">6.0 km.<br>แฟชั่นไอส์แลนด์ </p>
                        <p class="mt-1 km-card">5.0 km.<br>โรงพยาบาลสินแพทย์ รามอินทรา</p>
                        <p class="mt-1 km-card">4.0 km.<br>รถไฟฟ้าสายสีชมพู สถานีคู้บอน </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-2 ">
    <div class="col-md-12">
        <div class="card p-2 mt-3 mb-3">
            <div class="card-body">
                <h2 class="mt-3 mb-3">แผนที่</h2>
                <div id="dlgLoading" class="loadingWidget"></div>
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>

@include('playground.templates.footer')
<script type="text/javascript"
    src="http://api.nostramap.com/nostraapi/v2.0?key=G3v9lX0QBp(vciI6MblTq4loJrxTcF9WeaWfS2bS6EH7b5OZGqgPQ4ZIhh5t8Y5Ykw99fn6(AaRJ2Qq6nE16BZ0=====2">
</script>
<script>
    $(document).ready(function() {

        var customCallout, map, lat, lon, gLayer;
        var checkOnClickPin = false;
        var lstLabel = [];
        var arrCallout = [{
            lat: 13.868088,
            lon: 100.668045,
            content: "<u>ตำแหน่งบ้าน</u><br>Address: 18/337 ซ.คู้บอน 27 แยก 35 ถ.คู้บอน แขวงท่าแร้ง เขตบางเขน กทม. 10220",
            width: 200,
            height: 70,
            color: "#FFFFFF",
            fontSize: null,
            fontColor: "#000000",
            fontFamily: "Comic Sans MS",
            showShadow: true,
            label: "ตำแหน่งบ้าน"
        }, ];

        nostra.onready = function() {
            nostra.config.Language.setLanguage(nostra.language.E);
            initialize();
        }

        function initialize() {
            showLoading();
            map = new nostra.maps.Map("map", {
                id: "mapSample",
                logo: false,
                scalebar: true,
                slider: true,
                level: 15,
                lat: 13.868088,
                lon: 100.668045
            });
            map.events.load = function() {
                gLayer = new nostra.maps.layers.GraphicsLayer(map);
                map.addLayer(gLayer);
                initPin();
            };
            map.events.click = function(e) {
                lat = e.mapPoint.y;
                lon = e.mapPoint.x;

                var nostraCallout = new nostra.maps.CustomCallout({
                    content: document.getElementById("txtbContent").value,
                    width: document.getElementById("txtbWidth").value,
                    height: document.getElementById("txtbHeight").value,
                    color: document.getElementById("txtbCalloutColor").value,
                    fontSize: document.getElementById("txtbFontSize").value,
                    fontColor: document.getElementById("txtbFontColor").value,
                    fontFamily: document.getElementById("txtbFontFamily").value,
                    showShadow: document.getElementById("rdoShowShadow").checked
                });
                var nostraLabel = new nostra.maps.symbols.Label({
                    text: "testLabel",
                    size: "10",
                    position: "top"
                });
                lstLabel.push(nostraLabel);

                var markerPin = new nostra.maps.symbols.Marker({
                    url: "",
                    width: 60,
                    height: 60,
                    customCallout: nostraCallout,
                    label: nostraLabel,
                    draggable: true
                });
                var g = gLayer.addMarker(lat, lon, markerPin);
            }

            hideLoading();
        }

        function initPin() {
            for (var i in arrCallout) {
                var nostraCallout = new nostra.maps.CustomCallout({
                    content: arrCallout[i].content,
                    width: arrCallout[i].width,
                    height: arrCallout[i].height,
                    color: arrCallout[i].color,
                    fontSize: arrCallout[i].fontSize,
                    fontColor: arrCallout[i].fontColor,
                    fontFamily: arrCallout[i].fontFamily,
                    showShadow: arrCallout[i].showShadow
                })

                if (arrCallout[i].label) {
                    var nostraLabel = new nostra.maps.symbols.Label({
                        text: arrCallout[i].label,
                        size: "10",
                        position: "top"
                    });
                    lstLabel.push(nostraLabel);
                } else {
                    var nostraLabel = null;
                }

                var markerPin = new nostra.maps.symbols.Marker({
                    url: "",
                    width: 60,
                    height: 60,
                    customCallout: nostraCallout,
                    label: nostraLabel,
                    draggable: true
                });
                gLayer.addMarker(arrCallout[i].lat, arrCallout[i].lon, markerPin);
            }
            gLayer.showAllCustomCallout();
        }

        function showLoading() {
            document.getElementById("dlgLoading").style.display = "block";
        }

        function hideLoading() {
            document.getElementById("dlgLoading").style.display = "none";
        }



        $("#detail .main-img-slider").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            fade: true,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 300,
            lazyLoad: "ondemand",
            asNavFor: ".thumb-nav",
            prevArrow: '<div class="slick-prev"><i class="bi bi-arrow-left-circle-fill"></i><span class="sr-only sr-only-focusable">Previous</span></div>',
            nextArrow: '<div class="slick-next"><i class="bi bi-arrow-right-circle-fill"></i><span class="sr-only sr-only-focusable">Next</span></div>'
        });
        // Thumbnail/alternates slider for product page
        $(".thumb-nav").slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
            centerPadding: "0px",
            asNavFor: ".main-img-slider",
            dots: false,
            centerMode: false,
            draggable: true,
            speed: 200,
            focusOnSelect: true,
            prevArrow: '<div class="slick-prev"><i class="bi bi-arrow-left-circle-fill"></i><span class="sr-only sr-only-focusable">Previous</span></div>',
            nextArrow: '<div class="slick-next"><i class="bi bi-arrow-right-circle-fill"></i><span class="sr-only sr-only-focusable">Next</span></div>'
        });

        //keeps thumbnails active when changing main image, via mouse/touch drag/swipe
        $(".main-img-slider").on(
            "afterChange",
            function(event, slick, currentSlide, nextSlide) {
                //remove all active class
                $(".thumb-nav .slick-slide").removeClass("slick-current");
                //set active class for current slide
                $(".thumb-nav .slick-slide:not(.slick-cloned)")
                    .eq(currentSlide)
                    .addClass("slick-current");
            }
        );

    });
</script>
