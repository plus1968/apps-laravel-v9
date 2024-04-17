@include('dooduag.settingpage.template.header')

@php
    $col_screen = 'col-lg-12 col-md-12 col-sm-12 mt-3';
@endphp
<input id='PIN' type="hidden" />
<div class='row'>
    <div class='{{ $col_screen }}' id='ScreenMain' style="display: none">
        <div class="card">
            <div class="card-header">
                <h4 class="title-header">ตั้งค่ารายการวัน</h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 p-4">
                        <div class="table-responsive DivDooDuagMain"></div>
                    </div>

                    {{-- <div class="col-md-6 pt-3">
                        <div class="btn-group" role="group" aria-label="">
                            <button id='ButtonHome' type="button" class="btn btn-dark">
                                <i class='bx bx-border-all'></i> หน้าหลัก</button>
                            <button id='ButtonOpenUpload' type="button" class="btn btn-info">
                                <i class='bx bx-upload'></i> อัพโหลดข้อมูล Excel</button>
                        </div>
                    </div>
                    <div class="col-md-6 pt-3 text-end">
                        <button id ='ButtonDetail' type="button" class="btn btn-dark" style="display: none;"></button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- <div class='{{ $col_screen }}' id='UploadScreen' style='display:none;'>
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
    </div> --}}

    {{-- <div class='{{ $col_screen }}' id='MainScreen'>
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
    </div> --}}
</div>

<div class='{{ $col_screen }}' id='ErrorMessage' style="display: flex">

    <div class="demo-inline-spacing">

        <div class="spinner-grow text-info" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-info" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-info" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-info" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="ModalDooDuagSub" tabindex="-1" aria-modal="true" role="dialog" style="display: none;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitleDooDuagSub">จัดการเวลา</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- <div class="col-md-12 mb-3 text-center" id='LoadingSub'>
                        <div class="spinner-border text-danger" role="status"></div>
                    </div> --}}
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <input type='hidden' id="DooDuagdayID" />
                        <h4>
                            เวลาที่สามารถเลือกได้
                        </h4>
                        <div class="table-responsive">
                            <div class="row">
                                @php
                                    $Fulltime = '00';
                                    $Halftime = '30';
                                    $start = 11;
                                    $end = 22;
                                    $divsub = '';
                                    for ($i = $start; $i <= $end; $i++) {
                                        $divsub .= "<div class='col-2 mb-1 text-center'>";
                                        $divsub .=
                                            "<button width='100%' 
                                    class='btn btn-sm btn-secondary' 
                                    data-subtime ='" .
                                            $i .
                                            '.' .
                                            $Fulltime .
                                            "' 
                                    data-subtimename ='" .
                                            $i .
                                            $Fulltime .
                                            "' 
                                    onclick='AddDooDuagSub(this)'>" .
                                            $i .
                                            '.' .
                                            $Fulltime .
                                            '</button>';
                                        $divsub .= '</div>';
                                        $divsub .= "<div class='col-2 mb-1 text-center'>";
                                        $divsub .=
                                            "<button width='100%' 
                                    class='btn btn-sm btn-secondary' 
                                    data-subtime ='" .
                                            $i .
                                            '.' .
                                            $Halftime .
                                            "' 
                                    data-subtimename ='" .
                                            $i .
                                            $Halftime .
                                            "' 
                                    onclick='AddDooDuagSub(this)'>" .
                                            $i .
                                            '.' .
                                            $Halftime .
                                            '</button>';
                                        $divsub .= '</div>';
                                    }
                                    echo $divsub;
                                @endphp
                            </div>
                        </div>
                        <h4>เวลาที่เลือกแล้ว</h4>

                        <div class="DivDooDuagSub"></div>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id='trnsave1'>บันทึก</button>
            </div> --}}
        </div>
    </div>
</div>



<style>
    body {
        font-size: 14px;
    }

    #ErrorMessage {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        /* Semi-transparent white background */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        /* Adjust the z-index value based on your needs */
    }

    .MasterDooduagMain {
        border: 1px solid #dddd;
        padding: 20px;
        border-radius: 23px;
        margin-bottom: 5px;

    }
</style>

@include('dooduag.settingpage.template.footer')

<script type="text/javascript">
    $(document).ready(function() {
        // var myKey = 'myKey';
        // var timestampKey = 'myKeyTimestamp';
        // let TimeLess = 30;
        // var myValue = localStorage.getItem(myKey);
        // showLoadingAnimation();


        // if (myValue !== null) {
        //     // 'myKey' exists, check the timestamp
        //     var storedTimestamp = localStorage.getItem(timestampKey);
        //     var currentTime = new Date().getTime();

        //     if (storedTimestamp && (currentTime - parseInt(storedTimestamp)) < TimeLess * 60 * 1000) {
        //         LoadListCustomer();
        //     } else {
        //         // 30 minutes or more have passed, clear 'myKey'
        //         localStorage.removeItem(myKey);
        //         localStorage.removeItem(timestampKey);
        //         // Prompt the user for a new numeric value
        //         promptUser();
        //     }
        // } else {
        //     // 'myKey' does not exist, prompt the user for a numeric value
        //     promptUser();
        // }


        // function promptUser() {
        //     var userInput;

        //     do {
        //         userInput = prompt('Enter a numeric value for myKey:');

        //         // Check if userInput is a numeric value and equal to 123456
        //         if (userInput !== null && /^\d+$/.test(userInput) && parseInt(userInput) === 123456) {
        //             // Set the value for 'myKey' and the timestamp
        //             localStorage.setItem(myKey, userInput);
        //             localStorage.setItem(timestampKey, new Date().getTime().toString());
        //             LoadListCustomer();
        //             break; // Exit the loop if the condition is met
        //         } else if (userInput === null) {
        //             // User clicked "Cancel," show loading animation
        //         } else {
        //             // User entered something other than a numeric value
        //             alert('Invalid input. Please enter a numeric value equal.');
        //         }
        //     } while (userInput !== null); // Continue the loop until the user cancels the prompt
        // }
        LoadListCustomer();
    });




    var baseurl = '/duag/';

    function RemoveCustomer(iden) {
        var dooduagtranid = $(iden).data('dooduagtranid');

        Swal.fire({
            text: `ต้องยกเลิก ใช่หรือไม่ ?`,
            showDenyButton: true,
            confirmButtonText: "ใช่",
            denyButtonText: `ไม่ใช่`,
            confirmButtonColor: "#28a745",
            denyButtonColor: "#dc3545"
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    method: 'post',
                    url: baseurl + 'RemoveCustomer',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        DateTime: moment().format(),
                        dooduagtranid: dooduagtranid,
                    },
                    // contentType: false,
                    // processData: false,
                    success: function(result) {
                        Swal.fire('', result.data);
                        LoadListCustomer();
                    }
                })
            }
        });
    }

    function LoadListCustomer() {
        showLoadingAnimation();

        $.ajax({
            method: 'post',
            url: baseurl + 'LoadListCustomer',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                DateTime: moment().format(),
            },
            // contentType: false,
            // processData: false,
            success: function(result) {
                $('.DivDooDuagMain').html(result.data)
                $('#TableDooDuagCustomer').DataTable({
                    "paging": false,
                    "ordering": false, // Set ordering/sorting to false
                });
                hiddenLoadingAnimation();

            }
        })
    }

    function LoadDooDuagSub(iden) {
        $('#ModalDooDuagSub').modal('show')
        var ID = $(iden).data('id');
        $('#DooDuagdayID').val(ID)
        HandleDooDuagSub();
    }

    function AddDooDuagSub(iden) {
        var subtime = $(iden).data('subtime');
        var subtimename = $(iden).data('subtimename');
        $.ajax({
            method: 'post',
            url: baseurl + 'AddDooDuagSub',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                DateTime: moment().format(),
                DooDuagdayID: $('#DooDuagdayID').val(),
                DooDuagSubTime: subtime,
                DooDuagSubTimeName: subtimename,
            },
            // contentType: false,
            // processData: false,
            success: function(result) {
                Swal.fire('', result.data);
                HandleDooDuagSub()
            }
        })
    }

    function RemoveDooDuagSub(iden) {
        var dooduagsubid = $(iden).data('dooduagsubid');
        $.ajax({
            method: 'post',
            url: baseurl + 'RemoveDooDuagSub',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                DateTime: moment().format(),
                DooDuagSubID: dooduagsubid,
            },
            // contentType: false,
            // processData: false,
            success: function(result) {
                Swal.fire('', result.data);
                HandleDooDuagSub()
            }
        })
    }

    function HandleDooDuagSub() {
        $.ajax({
            method: 'post',
            url: baseurl + 'LoadDooDuagSub',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                DateTime: moment().format(),
                DooDuagdayID: $('#DooDuagdayID').val()
            },
            // contentType: false,
            // processData: false,
            success: function(result) {
                $('.DivDooDuagSub').html(result.data)
            }
        })
    }

    function showLoadingAnimation() {
        $('#ErrorMessage').fadeIn(200);
        $('#ScreenMain').fadeOut(200);
    }

    function hiddenLoadingAnimation() {
        $('#ErrorMessage').fadeOut(200);
        $('#ScreenMain').fadeIn(200);
    }

    function LoadDooDuagMain() {
        // var formData = new FormData(document.getElementById('formadd'))
        var myValue = localStorage.getItem('myKey');
        if (myValue !== null) {
            $.ajax({
                method: 'post',
                url: baseurl + 'LoadDooDuagMain',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    DateTime: moment().format()
                },
                // contentType: false,
                // processData: false,
                success: function(result) {
                    $('.DivDooDuagMain').html(result.data)
                    hiddenLoadingAnimation();
                    // $('#TableDooDuagMain').DataTable({
                    //     paging: false,
                    //     scrollX: true,
                    //     scrollY: 700
                    // });
                }
            })
        } else {

        }

    }

    function HandleIsActiveMain(iden) {
        var ID = $(iden).data('id');
        var NAME = $(iden).data('name');

        Swal.fire({
            text: `ต้องการเลิกใช้งานวัน ${NAME} ใช่หรือไม่ ?`,
            showDenyButton: true,
            confirmButtonText: "ใช่",
            denyButtonText: `ไม่ใช่`,
            confirmButtonColor: "#28a745",
            denyButtonColor: "#dc3545"
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    method: 'post',
                    url: baseurl + 'HandleIsActiveMain',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        DateTime: moment().format(),
                        DooDuagMainID: ID,
                    },
                    // contentType: false,
                    // processData: false,
                    success: function(result) {
                        LoadDooDuagMain();
                    }
                })
            }
        });

    }
</script>
