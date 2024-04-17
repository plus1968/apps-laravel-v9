@include('dooduag.transectionpage.template.header')

@php
    $col_screen = 'col-lg-12 col-md-12 col-sm-12 mt-3';
@endphp
<div class='row'>
    <div class='{{ $col_screen }}' id='ScreenMain'>
        <div class="card">
            <div class="card-header">
                <h6 class="title-header">ประกาศจากทางร้าน</h6>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 p-4">
                        <div class="table-responsive" style="font-size: 14px">
                            <h6> 🌟 รายละเอียดชี้แจง 🌟 </h6>
                            <p> จองคิวออนไลน์ (สแตนดาร์ด 30 นาทีทุกอัน) </p>
                            <p>1.แบบโทร - 15นาที / 30นาที / 1ชั่วโมง / 1ชั่วโมงครึ่ง/2ชั่วโมง </p>
                            <p> 2.พิมพ์ไม่จำกัดคำถาม </p>
                            <p> 3.ลูกอีช่างทัก </p>
                            <p> 4.วัยทำงาน(เน้นเรื่องงาน) </p>
                            <p> 5.ปรึกษาพิมพ์และโทร </p>
                            <p> 6.ปรับจักระ </p>
                            <p> 7.ชูก้ารูน (เน้นความรัก) </p>
                        </div>
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
    <div class="{{ $col_screen }} text-center">
        <button class="btn btn-lg btn-info mr-3" onclick="OpenAnnounce();" style="display: none;"
            id="btnAnnounce">ดูประกาศ</button>
        <button class="btn btn-lg btn-dark" onclick="OpenYear();">เริ่มจองคิว</button>
    </div>


    <div class='{{ $col_screen }}' id='ScreenYear' style='display:none; font-size:15px;'>
        <div class="card">
            <div class="card-header">
                <div class='row'>
                    <div class='col-md-12'>
                        <h2 class="title-header">กรุณาเลือกรายการ</h2>
                        {{-- <button type="button" class="btn btn-sm btn-secondary" aria-label="Close"
                            id='ButtonClose'>X</button> --}}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="{{ $col_screen }}">
                        <select class='form-select' style="width:100%;" id='SelYear' onchange="Loadselectmonth()">
                            @php
                                $startyear = date('Y');
                                $endyear = $startyear + 1;
                                $op = "";
                                for($year = $startyear ; $year<= $endyear ; $year++){
                                    $op .= "<option value='$year'>$year</option>";
                                }
                                echo $op;
                            @endphp
                        </select>
                    </div>
                    <div class="{{ $col_screen }}">
                        <select class='form-select selectmonth' style="width:100%;" id='SelMonth'></select>
                    </div>
                    
                    <div class="{{ $col_screen }} text-right">
                        <button class='btn btn-md btn-dark' onclick="LoadDooDuagAll()">ค้นหาวันจองคิว</button>
                    </div>

                </div>
                <div class='row'>
                    <div class="{{ $col_screen }}">
                        <div class='DivDooDuagShow'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class='{{ $col_screen }}' id='ErrorMessage' style="display: none">

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
<div class="modal fade" id="ModalDooDuagTime" tabindex="-1" aria-modal="true" role="dialog" style="display: none;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitleDooDuagTime">จองคิวออนไลน์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- <div class="col-md-12 mb-3 text-center" id='LoadingSub'>
                        <div class="spinner-border text-danger" role="status"></div>
                    </div> --}}
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4>เวลาที่สามารถเลือกได้</h4>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="DivDooDuagTimeShow"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type='hidden' id="DooDuagSubID" />
                                <input type='hidden' id="DooDuagTranDate" />

                                <label class="form-label" for="basic-default-dooduagsubid">เวลาที่เลือก (จำเป็น)</label>
                                <input type="text" class="form-control" id="DooDuagSubShow" disabled>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label class="form-label" for="basic-default-dooduagcustomername">กรอกชื่อ
                                    (จำเป็น)</label>
                                <input type="text" class="form-control" id="DooDuagCustomerName">
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label class="form-label" for="basic-default-dooduagcustomertel">กรอกเบอร์โทร
                                    (ไม่จำเป็น)</label>
                                <input type="number" class="form-control" id="DooDuagCustomerTel" maxlength="10"
                                    onkeyup="validateTelLength(this)">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label class="form-label" for="basic-default-dooduagcustomerage">กรอกอายุ
                                    (ไม่จำเป็น)</label>
                                <input type="number" class="form-control" id="DooDuagCustomerAge" maxlength="2"
                                    onkeyup="validateAgeLength(this)">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label class="form-label" for="basic-default-dooduagcustomeremail">กรอกอีเมล
                                    (ไม่จำเป็น)</label>
                                <input type="text" class="form-control" id="DooDuagCustomerEmail">
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='trnsave1'>ยืนยัน</button>
            </div>
        </div>
    </div>
</div>



<style>
    .MasterDooduagMain {
        border: 1px solid #dddd;
        padding: 20px;
        border-radius: 23px;
        margin-bottom: 5px;

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
</style>

@include('dooduag.transectionpage.template.footer')

<script type="text/javascript">
    $(document).ready(function() {
        Loadselectmonth()

        $('#trnsave1').click(function() {
            if ($('#DooDuagSubID').val() === '') {
                Swal.fire('', 'กรุณาเลือกเวลา');
            } else if ($('#DooDuagCustomerName').val() === '') {
                Swal.fire('', 'กรุณากรอกชื่อ');
            } else {
                showLoadingAnimation();
                $.ajax({
                    method: 'post',
                    url: baseurl + 'SaveDooDuagTran',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        DateTime: moment().format(),
                        DooDuagSubID: $('#DooDuagSubID').val(),
                        DooDuagSubShow: $('#DooDuagSubShow').val(),
                        DooDuagCustomerName: $('#DooDuagCustomerName').val(),
                        DooDuagCustomerTel: '',
                        DooDuagCustomerAge: '',
                        DooDuagCustomerEmail: '',
                        DooDuagTranDate: $('#DooDuagTranDate').val(),
                    },
                    // contentType: false,
                    // processData: false,
                    success: function(result) {
                        LoadDooDuagAll()
                        $('#ModalDooDuagTime').modal('hide')
                        hiddenLoadingAnimation();
                        Swal.fire('', result.data);


                    }
                })

            }
        })


    });


    var baseurl = '/duag/';

    function Loadselectmonth(){
        var year = $('#SelYear').val();
        var currentYear = new Date().getFullYear();
        var currentMonth = new Date().getMonth() + 1;
        var op ='';
        var monthObject = {
            '01': 'มกราคม',
            '02': 'กุมภาพันธ์',
            '03': 'มีนาคม',
            '04': 'เมษายน',
            '05': 'พฤษภาคม',
            '06': 'มิถุนายน',
            '07': 'กรกฎาคม',
            '08': 'สิงหาคม',
            '09': 'กันยายน',
            '10': 'ตุลาคม',
            '11': 'พฤศจิกายน',
            '12': 'ธันวาคม'
        };
        let start = 0;
        if(year == currentYear){
            start = currentMonth
        }else{
            start = 1
        }
        for (var i = start; i <= 12; i++) {

            mo = formatNumberWithLeadingZeros(i, 2);
            op +="<option value='"+mo+"'>"+monthObject[mo]+"</option>";
        }
        $('.selectmonth').html(op)
    }

    function formatNumberWithLeadingZeros(number, width) {
        return number.toString().padStart(width, '0');
    }

    function OpenYear() {
        $('#ScreenMain').fadeOut(300)
        $('#ScreenYear').fadeIn(300)
        $('#btnAnnounce').fadeIn(300)
        LoadDooDuagAll()
    }

    function OpenAnnounce() {
        $('#ScreenMain').fadeIn(300)
        $('#btnAnnounce').fadeOut(300)
        $('#ScreenYear').fadeOut(300)

    }

    function showLoadingAnimation() {
        $('#ErrorMessage').fadeIn(200);
    }

    function hiddenLoadingAnimation() {
        $('#ErrorMessage').fadeOut(200);
    }


    function OpenMonth(iden) {

    }

    function validateTelLength(input) {
        // ตรวจสอบว่าข้อมูลที่ป้อนเข้ามาเป็นตัวเลขหรือไม่
        if (!/^\d*$/.test(input.value)) {
            // ถ้าไม่ใช่ตัวเลข ให้ลบข้อมูลทั้งหมดทิ้ง
            input.value = '';
        } else if (input.value.length > 10) {
            // ถ้าเป็นตัวเลขและมีความยาวมากกว่า 10 ให้ลบข้อมูลที่เกินออก
            input.value = input.value.slice(0, 10);
        }
    }

    function validateAgeLength(input) {
        // ตรวจสอบว่าข้อมูลที่ป้อนเข้ามาเป็นตัวเลขหรือไม่
        if (!/^\d*$/.test(input.value)) {
            // ถ้าไม่ใช่ตัวเลข ให้ลบข้อมูลทั้งหมดทิ้ง
            input.value = '';
        } else if (input.value.length > 2) {
            // ถ้าเป็นตัวเลขและมีความยาวมากกว่า 2 ให้ลบข้อมูลที่เกินออก
            input.value = input.value.slice(0, 2);
        }
    }

    function LoadDooDuagTime(iden) {
        showLoadingAnimation();
        $('#DooDuagSubID').val('')
        $('#DooDuagSubShow').val('')
        // $('#DooDuagCustomerName').val('')
        // $('#DooDuagCustomerTel').val('')
        // $('#DooDuagCustomerAge').val('')
        // $('#DooDuagCustomerEmail').val('')
        $('#ModalDooDuagTime').modal('show')
        var dooduagdate = $(iden).data('dooduagdate');
        var dooduagday = $(iden).data('dooduagday');
        $('#DooDuagTranDate').val(dooduagdate)

        $.ajax({
            method: 'post',
            url: baseurl + 'LoadDooDuagTime',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                DateTime: moment().format(),
                dooduagdate: dooduagdate,
                dooduagday: dooduagday,
            },
            // contentType: false,
            // processData: false,
            success: function(result) {
                $('.DivDooDuagTimeShow').html(result.data)
                hiddenLoadingAnimation();

            }
        })
    }

    function SelectDooDuagSub(iden) {
        var dooduagsubid = $(iden).data('dooduagsubid');
        var dooduagsubtime = $(iden).data('dooduagsubtime');
        $('#DooDuagSubID').val(dooduagsubid)
        $('#DooDuagSubShow').val(dooduagsubtime)

    }

    function LoadDooDuagAll() {
        showLoadingAnimation();
        var SelYear = $('#SelYear').val()
        var SelMonth = $('#SelMonth').val()
        $.ajax({
            method: 'post',
            url: baseurl + 'LoadDooDuagAll',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                DateTime: moment().format(),
                SelYear:SelYear,
                SelMonth:SelMonth
            },
            // contentType: false,
            // processData: false,
            success: function(result) {
                $('.DivDooDuagShow').html(result.data)
                hiddenLoadingAnimation();

            }
        })

    }
</script>
