@php
    $months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    
    function dateThai($date)
    {
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
                    <h5 class="card-title text-primary">ประมวลผลวันหยุดประจำสัปดาห์</h5>
                    <form action="#" id='formid2' enctype="multipart/form-data">
                        <div class='row'>
                            <div class='col-md-4'>
                                <select class="custom-select js-select" name="months[]" id="months"
                                    multiple="multiple" style="width:100%">
                                    @php
                                        $curmonth = date('m');
                                        foreach ($months as $key => $value) {
                                            $K = sprintf('%02d', $key + 1);
                                            if ($K >= $curmonth) {
                                                echo "<option value='" . $K . "'>$value</option>";
                                            }
                                        }
                                    @endphp
                                </select>
                            </div>
                            <div class='col-md-4'>
                                <select name="year" id='year' class='form-select'>
                                    @php
                                        $currentYear = date('Y');
                                        $endYear = $currentYear + 5;
                                    @endphp

                                    @for ($year = $currentYear; $year <= $endYear; $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class='col-md-4'>
                                <button type="button" class="btn rounded-pill btn-primary"
                                    id='btn2'>ประมวลผล</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_trn2" tabindex="-1" aria-modal="true" role="dialog" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle2">ข้อมความระบบ</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3 text-center">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually">กรุณารอสักครู่ระบบกำลังทำรายการ</span>

                        </div>
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



<script>
    $(document).ready(function() {
        var baseurl = '/';
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $('.js-select').select2();

        $("#btn2").click(function(e) {
            e.preventDefault();
            var url = baseurl + 'trnsave2'
            var formData = new FormData();
            var selectedOptions = $("#months option:selected");

            selectedOptions.each(function() {
                var value = $(this).val();
                formData.append("months[]", value);
            });
            formData.append("year", $('#year').val());
            Swal.fire({
                title: 'ข้อความระบบ',
                html: 'ระบบกำลังประมวลผลกรุณารอสักครู่...',
                showCloseButton: true,
                showCancelButton: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
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
                    Swal.close();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'ประมวลผลเสร็จสิ้น',
                        showConfirmButton: false,
                        timer: 1500
                    })

                },
                error: function(xhr, status, error) {
                    console.log('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error);
                }
            });
        });

    });
</script>
