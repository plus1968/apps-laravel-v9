@php
    function dateThai($date)
    {
        $months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    
        $day = date('d', strtotime($date));
        $month = date('n', strtotime($date));
        $year = date('Y', strtotime($date)) + 543; // Convert to Thai year
    
        return $day . ' ' . $months[$month - 1] . ' ' . $year;
    }
@endphp
<div class="col-lg-12 mb-4 order-0">
    <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-12">
                <div class="card-body">
                    <h5 class="card-title text-primary">การบันทึกเข้า-ออกสำหรับวันที่ {{ dateThai(date('Y-m-d')) }}</h5>
                    <div class="row mt-4">
                        <div class="col-md-8 col-sm-8 mt-3 mb-3">
                            <label class="card-title text-primary">สถานที่ปัจจุบัน : </label>
                            <input class="form-control" type="text" id="locactionshow" placeholder="" readonly="">
                            <input type="hidden" id="sho_id">
                        </div>
                        <div class="col-md-4 col-sm-4 pt-4 mt-3 mb-3">
                            <button type="button" class="btn rounded-pill btn-primary" id='refresh'>
                                <span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; รีเฟรช
                            </button>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-2 col-sm-2 mt-3 mb-3">
                            <button type="button" class="btn rounded-pill btn-primary" id='save_trn1_in'>
                                บันทึกเข้า
                            </button>
                        </div>
                        <div class="col-md-2 col-sm-2 mt-3 mb-3">
                            <button type="button" class="btn rounded-pill btn-secondary" id='save_trn1_out'>
                                บันทึกออก
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_trn1_in" tabindex="-1" aria-modal="true" role="dialog" style="display: none;">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle1">บันทึกการเข้า-ออก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="card-title text-primary">ถ่ายรูปภาพเพื่อบันทึก *</label>
                        <input class="form-control" type="file" accept="image/*" id='file1' capture>
                        <input type='hidden' id='latitude'>
                        <input type='hidden' id='longitude'>
                    </div>
                    <div class="col-md-12 mb-3">
                        <textarea id='checkout-text' style="width: 100%;display:none;">

                        </textarea>
                    </div>


                    <div class="col-md-12 mb-3">
                        <div class="alert alert-danger alert-dismissible fileimg" role="alert" style="display: none;">
                            กรุณาระบุ * ให้ครบถ้วน
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id='trnsave1'>บันทึก</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        var baseurl = '/';
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $('#save_trn1_in').click(function(e) {
            e.preventDefault();
            $('#modal_trn1_in').modal('show')
            $('#file1').val('')
            $('#previewContainer').html('')
            $('.fileimg').fadeOut(200);
        });
        $('#save_trn1_out').click(function(e) {
            e.preventDefault();
            $('#modal_trn1_in').modal('show')
            $('#file1').val('')
            $('#previewContainer').html('')
            $('.fileimg').fadeOut(200);
        });

        // $('#input1').change(function() {
        //     var file = this.files[0];
        //     if (file && file.type.match('image.*')) {
        //         var reader = new FileReader();
        //         reader.onload = function(e) {
        //             var img = new Image();
        //             img.onload = function() {
        //                 var maxWidth = 640; // กำหนดความกว้างสูงสุดที่ต้องการ
        //                 var maxHeight = 480; // กำหนดความสูงสูงสุดที่ต้องการ
        //                 var width = img.width;
        //                 var height = img.height;
        //                 var scale = 1;

        //                 if (width > maxWidth) {
        //                     scale = maxWidth / width;
        //                 } else if (height > maxHeight) {
        //                     scale = maxHeight / height;
        //                 }

        //                 width *= scale;
        //                 height *= scale;

        //                 var canvas = document.createElement('canvas');
        //                 canvas.width = width;
        //                 canvas.height = height;
        //                 var ctx = canvas.getContext('2d');
        //                 ctx.drawImage(img, 0, 0, width, height);

        //                 var resizedImgSrc = canvas.toDataURL(file.type);
        //                 $('#previewContainer').html('<img src="' + resizedImgSrc + '">');
        //             };
        //             img.src = e.target.result;
        //         };
        //         reader.readAsDataURL(file);
        //     } else {
        //         // แสดงข้อความข้อผิดพลาดหรือดำเนินการอื่น ๆ ที่คุณต้องการ
        //         console.log("Please select an image file.");
        //     }

        // });



        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }

        $('#refresh').click(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        })



        function successCallback(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var storedString = localStorage.getItem('dbo_usr');
            var jsonParse = JSON.parse(storedString);

            // ทำสิ่งที่ต้องการกับค่า latitude และ longitude ที่ได้
            console.log("Latitude: " + latitude);
            console.log("Longitude: " + longitude);
            $("#latitude").val(latitude)
            $("#longitude").val(longitude)
            // console.log(storedString);
            // console.log(jsonParse);


            load_location(latitude, longitude, jsonParse.data.id);
        }


        function load_location(latitude, longitude, userid) {
            var url = baseurl + 'load_location'
            $.ajax({
                url: url,
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    latitude: latitude,
                    longitude: longitude,
                    userid: userid,
                },
                success: function(response) {
                    $('#locactionshow').val(response.location.shop)
                    $('#sho_id').val(response.location.sho_id)

                    if (response.location.sho_id == '' || response.location.sho_id == null) {
                        $('#save_trn1_in').prop('disabled', true);
                        $('#save_trn1_out').prop('disabled', true);
                    } else {
                        var data = response.dataall
                        if (data.WI_ID == '' || data.WI_ID == null) {
                            $('#save_trn1_in').prop('disabled', false);
                            $('#save_trn1_out').prop('disabled', true);
                            $('#Checkout').fadeOut(200)

                        } else if (data.WI_ID == 1) {
                            if (data.COUNT_SHO == 0) {
                                $('#save_trn1_in').prop('disabled', false);
                                $('#save_trn1_out').prop('disabled', true);
                                $('#Checkout').fadeOut(200)

                            } else if (data.COUNT_SHO == 1) {
                                $('#save_trn1_in').prop('disabled', true);
                                $('#save_trn1_out').prop('disabled', false);
                                $('#Checkout').fadeIn(200)
                            }
                            // else {
                            //     $('#save_trn1_in').prop('disabled', true);
                            //     $('#save_trn1_out').prop('disabled', true);
                            // }
                        } else {
                            $('#save_trn1_in').prop('disabled', true);
                            $('#save_trn1_out').prop('disabled', true);
                            $('#Checkout').fadeOut(200)

                        }

                    }

                },
                error: function(xhr, status, error) {
                    console.log('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error);
                }
            });
        }

        function errorCallback(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    console.log("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    console.log("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    console.log("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    console.log("An unknown error occurred.");
                    break;
            }
        }
        $('#trnsave1').click(function() {

            if ($('#file1').val() == '') {
                $('.fileimg').fadeIn(200);
            } else {
                $('.fileimg').fadeOut(200);
                var url = baseurl + 'trnsave1'
                var formData = new FormData();
                var storedString = localStorage.getItem('dbo_usr');
                var jsonParse = JSON.parse(storedString);
                formData.append('latitude', $('#latitude').val()); // เพิ่มค่าพารามิเตอร์อื่น ๆ
                formData.append('longitude', $('#longitude').val());
                formData.append('user_id', jsonParse.data.id);
                formData.append('sho_id', $('#sho_id').val());
                formData.append('file1', $('#file1')[0].files[0]);

                var editor = CKEDITOR.instances['checkout-text']; // 'editor' คือ ID ของตัวองค์ประกอบที่เป็น CKEditor 4
                var editorData = editor.getData();

                formData.append('checkout', editorData);



                $.ajax({
                    url: url,
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire(
                            'บันทึกข้อมูลสำเร็จ',
                            '',
                            'success'
                        );
                        $('#modal_trn1_in').modal('hide')
                        load_location($('#latitude').val(), $('#longitude').val(), jsonParse
                            .data.id);
                    },
                    error: function(xhr, status, error) {
                        console.log('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error);
                    }
                });
            }
        })



        CKEDITOR.replace('checkout-text', {
            extraPlugins: 'image,link'
        });

    });
</script>
