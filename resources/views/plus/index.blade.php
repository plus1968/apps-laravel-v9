@include('plus.template.header')

@php
    $col_screen = 'col-lg-12 col-md-12 col-sm-12 mt-3';
@endphp
<style>
    .table-sub-show {
        border: 1px solid #ddd;
        padding: 5px;
    }
</style>
<input type='hidden' id='M_CODE' value='' />
<div class='row'>
    <div class='{{ $col_screen }}' id='MenuScreen'>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 pt-3">
                        <div class="btn-group" role="group" aria-label="">
                            <button id='ButtonHome' type="button" class="btn btn-dark">
                                <i class='bx bx-border-all'></i> หน้าหลัก</button>
                            <button id='ButtonOpenUpload' type="button" class="btn btn-info">
                                <i class='bx bx-upload'></i> อัพโหลดข้อมูล Excel</button>
                        </div>
                    </div>
                    <div class="col-md-6 pt-3 text-end">
                        <button id ='ButtonDetail' type="button" class="btn btn-dark" style="display: none;"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='{{ $col_screen }}' id='UploadScreen' style='display:none;'>
        <div class="card">
            <div class="card-header">
                <div class='row'>
                    <div class='col-md-12 text-end'>
                        <button type="button" class="btn btn-sm btn-secondary p-3" aria-label="Close"
                            id='ButtonCloseUpload'>X</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id='form-send' enctype="multipart/form-data">
                    <div class='row'>
                        <div class='col-md-4 pt-3'>
                            <input class="form-control" type='text' name='M_NAME' id='M_NAME'
                                placeholder="ใส่ชื่อตามต้องการ">
                        </div>
                        <div class='col-md-2 pt-3'>
                            <button type="button" class="btn btn-sm btn-secondary" onclick="downloadFile()">
                                <span class="bx bxs-spreadsheet"></span> Template Lasted
                            </button>
                        </div>
                        <div class='col-md-4 pt-3'>
                            <div class="input-group">
                                <input type="file" class="form-control" id="M_EXCEL"name='M_EXCEL'>
                            </div>
                        </div>
                        <div class='col-md-2 pt-3'>
                            <button type="button" class="btn rounded-pill btn-dark"
                                onclick="uploadexcel()">อัพโหลด</button>&nbsp;
                            <button type="button" class="btn rounded-pill btn-success" onclick="ConvertCSV()">แปลง
                                csv</button>
                        </div>

                    </div>
                </form>
                <div class="row">
                    <div class='col-md-6 pt-3'>
                    </div>
                    <div class='col-md-6 pt-3'>
                        <div id="outputCSV"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class='{{ $col_screen }}' id='MainScreen'>
        <div class="card">
            <div class="card-body">
                <div class="table-show table-responsive"></div>
            </div>
        </div>
    </div>
    <div class='{{ $col_screen }}' id='SubScreen' style="display: none;">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 pt-3">
                        <select id='DD_REG' class='form-select' style="width: 100%" onchange="LoadDropDrow_DC(this)">
                            <option value="">กรุณาเลือก...</option>
                        </select>
                    </div>
                    <div class="col-md-4 pt-3">
                        <select id='DD_DC' class='form-select' style="width: 100%"
                            onchange="LoadDropDrow_Route(this)">
                            <option value="">กรุณาเลือก...</option>

                        </select>

                    </div>
                    <div class="col-md-3 pt-3">
                        <select id='DD_ROUTE' class='form-select' style="width: 100%">
                            <option value="">กรุณาเลือก...</option>
                        </select>

                    </div>
                    <div class="col-md-2 pt-3">
                        <button type="button" class="btn rounded-pill btn-dark" onclick="Search_Data()">ค้นหา</button>
                    </div>

                </div>
                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="table-sub-show table-responsive"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id='IMGMain' style="display: none"></div>

<style>

</style>

@include('plus.template.footer') ;

<script type="text/javascript">
    $(document).ready(function() {

        loadMainGI();
        $('#ButtonOpenUpload').click(function() {
            $('#UploadScreen').fadeIn(300);
        })
        $('#ButtonCloseUpload').click(function() {
            $('#UploadScreen').fadeOut(200);
        })
        $('#ButtonHome').click(function() {
            loadMainGI();
            $('#MainScreen').fadeIn(200);
            $('#SubScreen').fadeOut(200);
            if ($('#M_CODE').val() == '') {
                $('#ButtonDetail').fadeOut(300)
            } else {
                $('#ButtonDetail').fadeIn(300)
            }

        })
        $('#ButtonDetail').click(function() {
            $('#MainScreen').fadeOut(200);
            $('#SubScreen').fadeIn(200);
        })
    });


    var baseurl = '/plus/';

    function LoadDropDrow_Reg(iden) {
        var value = $(iden).data('mcode');
        $('#M_CODE').val(value);
        $('#ButtonDetail').html("<i class='bx bx-right-arrow'></i> กลับหน้า " + value);
        //******************************//
        $('#ButtonDetail').fadeIn(300)
        $('#MainScreen').fadeOut(300)
        $('#SubScreen').fadeIn(300)
        //******************************//
        $('.table-sub-show').html('')
        //******************************//
        $('#DD_REG').html('<option value="">กรุณาเลือก...</option>').select2();
        $('#DD_DC').html('<option value="">กรุณาเลือก...</option>').select2();
        $('#DD_ROUTE').html('<option value="">กรุณาเลือก...</option>').select2();


        if (value != '') {

            $.ajax({
                method: 'post',
                url: baseurl + 'LoadDropDrow_Reg',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    DateTime: moment().format(),
                    M_CODE_RECIVE: value
                },
                // contentType: false,
                // processData: false,
                success: function(res) {
                    $('#DD_REG').html(res.data)
                    $('#DD_REG').select2();
                    // $('#TableSub').DataTable({
                    //     paging: false,
                    //     scrollX: true,
                    //     scrollY: 1000
                    // });
                }
            })
        }
    }

    function LoadDropDrow_DC(iden) {
        var value = $(iden).val();
        $('#DD_DC').html('<option value="">กรุณาเลือก...</option>').select2();
        $('#DD_ROUTE').html('<option value="">กรุณาเลือก...</option>').select2();
        if (value != '') {

            $.ajax({
                method: 'post',
                url: baseurl + 'LoadDropDrow_DC',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    DateTime: moment().format(),
                    GI_REG: value,
                    M_CODE_RECIVE: $('#M_CODE').val(),
                },
                // contentType: false,
                // processData: false,
                success: function(res) {
                    $('#DD_DC').html(res.data)
                    $('#DD_DC').select2();
                    // $('#TableSub').DataTable({
                    //     paging: false,
                    //     scrollX: true,
                    //     scrollY: 1000
                    // });
                }
            })
        }
    }

    function LoadDropDrow_Route(iden) {
        $('#DD_ROUTE').html('<option value="">กรุณาเลือก...</option>').select2();
        var value = $(iden).val();
        if (value != '') {
            $.ajax({
                method: 'post',
                url: baseurl + 'LoadDropDrow_Rouge',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    DateTime: moment().format(),
                    GI_REG: $('#DD_REG').val(),
                    GI_DC: $('#DD_DC').val(),
                    M_CODE_RECIVE: $('#M_CODE').val(),
                },
                // contentType: false,
                // processData: false,
                success: function(res) {
                    $('#DD_ROUTE').html(res.data)
                    $('#DD_ROUTE').select2();
                    // $('#TableSub').DataTable({
                    //     paging: false,
                    //     scrollX: true,
                    //     scrollY: 1000
                    // });
                }
            })
        }
    }

    function loadMainGI() {
        // var formData = new FormData(document.getElementById('formadd'))
        $.ajax({
            method: 'post',
            url: baseurl + 'loadMainGI',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                DateTime: moment().format()
            },
            // contentType: false,
            // processData: false,
            success: function(res) {
                $('.table-show').html(res)
                $('#TableMain').DataTable({
                    paging: false,
                    scrollX: true,
                    scrollY: 700
                });
            }
        })
    }

    function uploadexcel() {
        if ($('#M_EXCEL').val() == '') {
            Swal.fire({
                icon: 'warning',
                title: 'คำเตือน',
                text: 'กรุณาเลือกไฟล์!',
                allowOutsideClick: false,
            })
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณารอสักครู่',
                text: 'กำลังประมวลผล',
                allowOutsideClick: false,

                didOpen: () => {
                    Swal.showLoading()
                },
            })
            var formData = new FormData(document.getElementById('form-send'))
            $.ajax({
                method: 'post',
                url: baseurl + 'uploadexcel',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    loadMainGI()
                    Swal.close()

                }
            })
        }

    }

    function ConvertCSV() {
        const csvFileInput = $('#M_EXCEL');
        const outputDiv = $('#outputCSV');
        const M_NAME = $('#M_NAME').val();
        if ($('#M_EXCEL').val() == '') {
            Swal.fire({
                icon: 'warning',
                title: 'คำเตือน',
                text: 'กรุณาเลือกไฟล์!',
                allowOutsideClick: false,
            })
        } else if ($('#M_NAME').val() == '') {
            Swal.fire({
                icon: 'warning',
                title: 'คำเตือน',
                text: 'กรุณาตั้งชื่อไฟล์ csv ใหม่!',
                allowOutsideClick: false,
            })
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณารอสักครู่',
                text: 'กำลังประมวลผล',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                },
            })
            if (csvFileInput[0].files.length > 0) {
                const file = csvFileInput[0].files[0];
                const reader = new FileReader();

                reader.onload = function(event) {
                    // อ่านข้อมูลจากไฟล์ CSV
                    const tis620EncodedData = event.target.result;

                    // แปลงรหัส TIS-620 เป็น UTF-8
                    const utf8EncodedData = new TextDecoder('tis-620').decode(tis620EncodedData);

                    // สร้าง Blob ที่ใช้รหัส UTF-8
                    const utf8Blob = new Blob([utf8EncodedData], {
                        type: 'text/csv;charset=utf-8'
                    });

                    // สร้าง URL สำหรับ Blob
                    const utf8BlobURL = URL.createObjectURL(utf8Blob);

                    // สร้างลิงก์สำหรับดาวน์โหลดไฟล์ UTF-8
                    const downloadLink = $('<a></a>');
                    downloadLink.attr('href', utf8BlobURL);
                    downloadLink.attr('download', M_NAME + '.csv');
                    downloadLink.text('คลิกเพื่อดาวน์โหลดไฟล์ UTF-8');

                    // แสดงลิงก์ใน HTML
                    outputDiv.append(downloadLink);
                };

                reader.readAsArrayBuffer(file);
                Swal.close();

            } else {
                outputDiv.text('โปรดเลือกไฟล์ CSV ก่อนแปลง');
            }
        }
    }

    function Search_Data() {
        Swal.fire({
            icon: 'warning',
            title: 'กรุณารอสักครู่',
            text: 'กำลังประมวลผล',
            allowOutsideClick: false,

            didOpen: () => {
                Swal.showLoading()
            },
        })
        $.ajax({
            method: 'post',
            url: baseurl + 'Search_Data',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                DateTime: moment().format(),
                GI_REG: $('#DD_REG').val(),
                GI_DC: $('#DD_DC').val(),
                GI_ROUTE: $('#DD_ROUTE').val(),
                M_CODE_RECIVE: $('#M_CODE').val(),
            },
            // contentType: false,
            // processData: false,
            success: function(res) {
                $('.table-sub-show').html(res.data)
                $('#TableSub').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copy',
                            filename: '_copy_' + $('#M_CODE').val() + "_" + moment()
                                .format(), // Set the filename for the copy action
                        },
                        {
                            extend: 'csv',
                            filename: '_csv_' + $('#M_CODE').val() + "_" + moment()
                                .format(), // Set the filename for the CSV action
                        },
                        {
                            extend: 'excel',
                            filename: '_excel_' + $('#M_CODE').val() + "_" + moment()
                                .format(), // Set the filename for the Excel action
                        },
                        {
                            extend: 'pdf',
                            filename: '_pdf_' + $('#M_CODE').val() + "_" + moment()
                                .format(), // Set the filename for the PDF action
                        },
                        'print'
                    ],
                    paging: false,

                });
                Swal.close()

            }
        })
    }

    function Save_txt(iden) {
        var GI_ID = $(iden).data('giid');
        var GI_TEXT = $(iden).val();

        $.ajax({
            method: 'post',
            url: baseurl + 'Save_txt',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                DateTime: moment().format(),
                GI_TEXT: GI_TEXT,
                GI_ID: GI_ID,
            },
            // contentType: false,
            // processData: false,
            success: function(res) {
                if (res.data == 'SAVED') {
                    $('.tx_' + GI_ID).css('border', '2px solid #56F72A');

                    // รอเป็นเวลา 2 วินาที (2000 มิลลิวินาที) แล้วกลับสีเดิม
                    setTimeout(function() {
                        $('.tx_' + GI_ID).css('border', ''); // เปลี่ยนเป็นสีเดิม
                    }, 2000);
                }
            }
        })
    }
    // URL of the file you want to download

    // Function to trigger the download
    function downloadFile() {
        const fileUrl = 'https://route.plustrap.com/public/fileall/Template_new_20231117.xlsx';

        fetch(fileUrl)
            .then(response => response.blob())
            .then(blob => {
                // Create a temporary <a> element to trigger the download
                const a = document.createElement('a');
                a.style.display = 'none';
                document.body.appendChild(a);

                // Create a URL for the blob
                const objectUrl = window.URL.createObjectURL(blob);
                a.href = objectUrl;

                // Set the filename for the download (change 'Template_new.zip' to 'Template_new.xlsx')
                a.download = 'Template_new.xlsx';

                // Trigger the click event to start the download
                a.click();

                // Cleanup: remove the <a> element and the object URL
                window.URL.revokeObjectURL(objectUrl);
                document.body.removeChild(a);
            })
            .catch(error => {
                console.error('Error downloading file:', error);
            });
    }

    function ImgDownLoad(iden) {
        Swal.fire({
            icon: 'warning',
            title: 'กรุณารอสักครู่',
            text: 'กำลังประมวลผล',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            },
        })
        var mcode = $(iden).data('mcode');
        var start = $(iden).data('start');
        var end = $(iden).data('end');
        if (mcode != '' && start != '' && end != '') {
            $.ajax({
                method: 'post',
                url: baseurl + 'ImgDownLoad',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    DateTime: moment().format(),
                    M_CODE: mcode,
                    start: start,
                    end: end,
                },
                // contentType: false,
                // processData: false,
                success: function(res) {
                    $("#IMGMain").html(res.body)
                    // Example usage:
                    downloadBase64Images(function() {
                        console.log('All images have been downloaded as a ZIP file.');
                        Swal.close()
                    });

                }
            })
        }
    }

    function downloadBase64Images(callback) {
        var $images = $("#IMGMain img");
        var zip = new JSZip();

        $images.each(function(index) {
            var img = new Image();
            img.crossOrigin = "Anonymous"; // Set crossOrigin to avoid tainted canvas
            img.src = $(this).attr("src");
            img.onload = function() {
                var canvas = document.createElement("canvas");
                canvas.width = img.width;
                canvas.height = img.height;
                var context = canvas.getContext("2d");
                context.drawImage(img, 0, 0);

                // Convert the image to Base64
                var base64Data = canvas.toDataURL("image/jpeg", 0.9);

                // Add the Base64 image to the ZIP file
                zip.file('image' + index + '.jpg', base64Data.split(',')[1], {
                    base64: true
                });

                if (index === $images.length - 1) {
                    // Generate the ZIP file and initiate the download
                    zip.generateAsync({
                        type: "blob"
                    }).then(function(content) {
                        var fileName = 'images.zip';
                        saveAs(content, fileName);

                        if (callback) {
                            callback();
                        }
                    });
                }
            };
        });
    }
</script>
