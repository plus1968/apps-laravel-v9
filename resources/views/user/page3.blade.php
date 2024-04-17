<?php
$months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

function dateThai($date)
{
    $day = date('d', strtotime($date));
    $month = date('n', strtotime($date));
    $year = date('Y', strtotime($date)) + 543; // Convert to Thai year

    return $day . ' ' . $months[$month - 1] . ' ' . $year;
}
?>

<div class='row mb-3'>
    <div class="col-md-4 col-lg-4 order-2 mb-3">
        <div class="card h-100">
            <h5 class="card-header">รายการการลา (<span class='badge bg-label-success'>อนุมัติ</span>)</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>รายการ</th>
                                <th>จำนวน (วัน/ชม.)</th>
                            </tr>
                        </thead>
                        <tbody class="body_show3_dash">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-lg-8 order-2 mb-3">
        <div class="card h-100">
            <h5 class="card-header">รายละเอียด</h5>
            <div class="card-body">
                <select class="custom-select js-select" name="months_3" id="months_3" style="width:100%">
                    @php
                        $curmonth = date('m');
                        foreach ($months as $key => $value) {
                            $K = sprintf('%02d', $key + 1);
                            $sel = '';
                            if ($K == $curmonth) {
                                $sel = 'selected';
                            }
                            if ($K <= $curmonth) {
                                echo "<option value='" . $K . "' $sel>$value</option>";
                            }
                        }
                    @endphp
                </select>
                <div class="table-responsive text-nowrap mt-3 mb-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>รายการ</th>
                                <th>เวลา</th>
                                <th>สถานะ</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class='body_show3'>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<h5 class="card-title text-primary">บันทึกการลา</h5>

<div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#tabs1"
                aria-controls="tabs1" aria-selected="false">ลารายวัน</button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tabs2"
                aria-controls="tabs2" aria-selected="false">ลารายชั่วโมง</button>
        </li>

    </ul>
    <div class="tab-content">
        <div class="tab-pane fade active show" id="tabs1" role="tabpanel">
            <div class="row mb-3">
                <div class='col-md-12 mb-3'>
                    <label class="card-title text-primary">กรุณาเลือกประเภทการลา *</label>
                    <select class="custom-select js-select"style="width:100%" id='WK_ID_1'>
                        <option value=''>กรุณาเลือกประเภทการลา..</option>
                        @php
                            foreach ($MST_WORK as $key => $value) {
                                echo "<option value='$value->WK_ID'>" . $value->WK_ID . '::' . $value->WK_NAME . '</option>';
                            }
                        @endphp
                    </select>
                </div>
                <div class='col-md-12 mb-3'>
                    <label class="card-title text-primary">กรุณาเลือกวันลา *</label>
                    <input class="flatpickr flatpickr-input form-control" type="text" placeholder="เลือกวันที่..."
                        name="MA_DT_1" id="MA_DT_1">
                    {{-- <select class="custom-select js-dt" 
                        style="width:100%">
                        @php
                        echo "<option value=''>กรุณาเลือกวันที่</option>";

                            $day = date('d');
                            $month = date('m');
                            $year = date('Y');
                            $Months = [$month - 1, $month, $month + 1];
                            foreach ($Months as $key => $value) {
                                $M = sprintf('%02d', $value);
                                $endday[$key] = date('t', strtotime("$year-$M"));
                                for ($i = 1; $i <= $endday[$key]; $i++) {
                                    $days = sprintf('%02d', $i);
                                    $newdate = "$year-$M-$days";
                                    echo "<option value='" . $newdate . "'>" . $newdate . '</option>';
                                }
                            }
                        @endphp
                    </select> --}}
                </div>
            </div>
            <div class="row mb-3">
                <div class='col-md-12 mb-3'>
                    <label class="card-title text-primary">เหตุผล</label>
                    <textarea class="form-control" id="MA_REMARK_1" rows="3"></textarea>
                </div>

                <div class='col-md-2'>
                    <button type="button" class="btn rounded-pill btn-primary" id='btn3_1'>บันทึก</button>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tabs2" role="tabpanel">
            <div class="row mb-3">
                <div class='col-md-12 mb-3'>
                    <label class="card-title text-primary">กรุณาเลือกประเภทการลา *</label>
                    <select class="custom-select js-select"style="width:100%" id='WK_ID_2'>
                        <option value=''>กรุณาเลือกประเภทการลา..</option>
                        @php
                            foreach ($MST_WORK as $key => $value) {
                                echo "<option value='$value->WK_ID'>" . $value->WK_ID . '::' . $value->WK_NAME . '</option>';
                            }
                        @endphp
                    </select>
                </div>
                <div class='col-md-12 mb-3'>
                    <label class="card-title text-primary">กรุณาเลือกวันลา *</label>
                    <input class="flatpickr flatpickr-input form-control" type="text" placeholder="เลือกวันที่..."
                        name="MA_DT_2" id="MA_DT_2">

                    {{-- <select class="custom-select js-dt" name="MA_DT_2" id="MA_DT_2" style="width:100%">
                        @php
                        echo "<option value=''>กรุณาเลือกวันที่</option>";
                        $day = date('d');
                        $month = date('m');
                        $year = date('Y');
                        $Months = [$month - 1, $month, $month + 1];

                        foreach ($Months as $key => $value) {
                            $M = sprintf('%02d', $value);
                            $endday[$key] = date('t', strtotime("$year-$M"));
                            for ($i = 1; $i <= $endday[$key]; $i++) {
                                $days = sprintf('%02d', $i);
                                $newdate = "$year-$M-$days";
                                echo "<option value='" . $newdate . "'>" . $newdate . '</option>';
                            }
                        }
                    @endphp
                    </select> --}}
                </div>
            </div>
            <div class="row mb-3">
                <div class='col-md-2'><label class="card-title text-primary">ตั้งแต่ *</label></div>
                <div class='col-md-4'><input class="form-control" type="time" value="" id="SU_PIC_TIME_START">
                </div>
                <div class='col-md-2'><label class="card-title text-primary">ถึง *</label></div>
                <div class='col-md-4'><input class="form-control" type="time" value="" id="SU_PIC_TIME_END">
                </div>
            </div>
            <div class="row mb-3">
                <div class='col-md-12 mb-3'>
                    <label class="card-title text-primary">เหตุผล</label>
                    <textarea class="form-control" id="MA_REMARK_2" rows="3"></textarea>
                </div>

                <div class='col-md-2'>
                    <button type="button" class="btn rounded-pill btn-primary" id='btn3_2'>บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</div>






<script>
    $(document).ready(function() {
        var baseurl = '/';
        var csrfToken = $('meta[name="csrf-token"]').attr('content');


        $('.js-select').select2();
        $('.flatpickr-input').flatpickr({
            mode: "multiple",
            dateFormat: "Y-m-d",
        });

        load_wk()
        load_wk_dash()

        $('#btn3_1').on('click', function() {
            var formData = new FormData();
            var storedString = localStorage.getItem('dbo_usr');
            var jsonParse = JSON.parse(storedString);
            formData.append('user_id', jsonParse.data.id);

            if ($('#WK_ID_1').val() == '' && $('#MA_DT_1').val() == '') {
                Swal.fire(
                    'กรุณาระบุ * ให้ครบถ้วน',
                    '',
                    'danger'
                );
            } else {
                formData.append('TYPE', 'ALLDAY');
                formData.append('MA_DT_1', $('#MA_DT_1').val());
                formData.append('MA_REMARK_1', $('#MA_REMARK_1').val());
                formData.append('WK_ID_1', $('#WK_ID_1').val());

                $.ajax({
                    url: baseurl + 'trnsave3',
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.error == 0) {
                            Swal.fire(
                                'บันทึกข้อมูลสำเร็จ',
                                '',
                                'success'
                            );
                            $('#MA_DT_1').val('')
                            $('#MA_REMARK_1').val('')
                            $('#WK_ID_1').val('').trigger('change')
                        } else {
                            Swal.fire(
                                'มีการบันทึกซ้ำกรุณาตรวจสอบอีกครั้ง',
                                '',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error);
                    }
                });
            }
        });
        $('#btn3_2').on('click', function() {
            var formData = new FormData();
            var storedString = localStorage.getItem('dbo_usr');
            var jsonParse = JSON.parse(storedString);
            formData.append('user_id', jsonParse.data.id);
            if ($('#WK_ID_2').val() == '' && $('#MA_DT_2').val() == '' && $('#SU_PIC_TIME_START')
                .val() == '' && $(
                    '#SU_PIC_TIME_END').val() == '') {
                Swal.fire(
                    'กรุณาระบุ * ให้ครบถ้วน',
                    '',
                    'danger'
                );
            } else {
                formData.append('WK_ID_2', $('#WK_ID_2').val());
                formData.append('TYPE', 'HOUR');
                formData.append('MA_DT_2', $('#MA_DT_2').val())
                formData.append('MA_REMARK_2', $('#MA_REMARK_2').val());
                formData.append('SU_PIC_TIME_START', $('#SU_PIC_TIME_START').val());
                formData.append('SU_PIC_TIME_END', $('#SU_PIC_TIME_END').val());

                $.ajax({
                    url: baseurl + 'trnsave3',
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.error == 0) {
                            Swal.fire(
                                'บันทึกข้อมูลสำเร็จ',
                                '',
                                'success'
                            );
                            $('#MA_DT_2').val('')
                            $('#MA_REMARK_2').val('')
                            $('#SU_PIC_TIME_START').val('')
                            $('#SU_PIC_TIME_END').val('')
                            $('#WK_ID_2').val('').trigger('change')
                        } else {
                            Swal.fire(
                                'มีการบันทึกซ้ำกรุณาตรวจสอบอีกครั้ง',
                                '',
                                'error'
                            );
                        }

                    },
                    error: function(xhr, status, error) {
                        console.log('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error);
                    }
                });
            }
        });

        $('#months_3').on('change', function() {
            load_wk();
            load_wk_dash();
        });

    });
    var baseurl = '/';
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var storedString = localStorage.getItem('dbo_usr');
    var jsonParse = JSON.parse(storedString);

    function load_wk() {
        var month = $('#months_3 option:selected').val()
        var formData = new FormData();
        formData.append('user_id', jsonParse.data.id);
        formData.append('month', month);
        $.ajax({
            url: baseurl + 'load_wk',
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('.body_show3').html(response)
            },
            error: function(xhr, status, error) {
                console.log('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error);
            }
        })
    }

    function load_wk_dash() {
        var month = $('#months_3 option:selected').val()
        var formData = new FormData();
        formData.append('user_id', jsonParse.data.id);
        formData.append('month', month);
        $.ajax({
            url: baseurl + 'load_wk_dash',
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('.body_show3_dash').html(response)
            },
            error: function(xhr, status, error) {
                console.log('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error);
            }
        })
    }
</script>
