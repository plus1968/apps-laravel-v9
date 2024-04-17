<div class="row mt-2">
    <div class="col-md-12">
        {{-- <h5 class="">บันทึกข้อมูล ณ วันที่ {{ date('Y-m-d') }}</h5> --}}
        <div class="card mb-4">

            <div class="card-header">
                <h6>ฐานข้อมูลลูกค้า</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered mt-3" style="width: 100%">
                    <tbody>
                        <tr>
                            <td style="width: 70%">
                                <input type="text" class="form-control" id="CustomerName" placeholder="กรอกชื่อลูกค้า">

                            </td>
                            <td style="width: 30%">
                                <button type='button' class="btn btn-primary" onclick="AddDataCustomer()"
                                    style="width: 100%;">เพิ่มรายชื่อลูกค้า</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-responsive  mt-3">
                    <table class="table table-bordered" style="width: 100%" id="table-customer">
                        <thead class="">
                            <tr>
                                <th style="width:30% ;background:#333;color:#fff">
                                    ชื่อลูกค้า
                                </th>
                                <th style="width:40%;background:#333;color:#fff">
                                    ที่อยู่ลูกค้า
                                </th>
                                <th style="width:30%;background:#333;color:#fff">
                                    เพิ่มที่อยู่ลูกค้า
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tbody-customer">

                        </tbody>
                    </table>

                    {{-- <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <label class="form-label" for="basic-default-customername"></label>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12 text-end">
                            <button type='button' class="btn btn-primary mt-4"
                                style="width: 100%;">เพิ่มรายชื่อลูกค้า</button>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12 text-end">
                            <button type='button' class="btn btn-info mt-4"
                                style="width: 100%;">รายชื่อลูกค้าปัจจุบัน</button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="table-responsive text-nowrap">
                <div class="card-header">
                    <h6>บันทึกรายการลูกค้า</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <label class="form-label" for="basic-default-selcustomer">ค้นหาลูกค้า</label>
                            <select class="form-select SelCustomer" style="width: 100%" id="SelCustomer"></select>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <label class="form-label" for="basic-default-selproduct">ค้นหาสินค้า</label>
                            <select class="form-select SelProduct" style="width: 100%" id="SelProduct"></select>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            <label class="form-label" for="basic-default-transectionunit">จำนวน / ชิ้น</label>
                            <input type="number" class="form-control" id="TransectionUnit">
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <label class="form-label" for="basic-default-transectionaddress">กรอกที่อยู่</label>
                            <input type="text" class="form-control" id="TransectionAddress">
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <label class="form-label" for="basic-default-transectionzipcode">กรอกรหัสไปรษณีย์</label>
                            <input type="text" class="form-control" id="TransectionZipCode">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12 pl-4 pr-4">
                            <button type='button' class="btn btn-primary mt-4"
                                style="width: 100%;">เพิ่มรายการของลูกค้า</button>
                        </div>

                        <div class="col-md-6 col-lg-6 col-sm-12 pl-4 pr-4">
                            <button type='button' class="btn btn-info mt-4"
                                style="width: 100%;">รายการบันทึกของวันนี้</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







<script type="text/javascript">
    $(document).ready(function() {
        var baseurl = '/reseller/';
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        LoadDataCustomer();

    });
    var baseurl = '/reseller/';
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var dbo_usr = JSON.parse(localStorage.getItem('dbo_usr'));


    function AddDataCustomer() {
        if ($('#CustomerName').val() === '') {
            Swal.fire('', 'กรุณากรอกชื่อลูกค้า')

        } else {
            console.log(dbo_usr)
            $.ajax({
                url: baseurl + 'AddDataCustomer',
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    CustomerName: $('#CustomerName').val(),
                    dbo_usr: dbo_usr.data
                },
                success: function(response) {
                    $('#CustomerName').val('')
                    Swal.fire('', 'เพิ่มข้อมูลลูกค้าสำเร็จ')
                    LoadDataCustomer()
                },
                error: function(xhr, status, error) {
                    console.log('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error);
                }
            });
        }

    }

    function LoadDataCustomer() {
        $.ajax({
            url: baseurl + 'LoadDataCustomer',
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {

            },
            success: function(response) {
                $('.tbody-customer').html(response.message)
                $('#table-customer').DataTable();
            },
            error: function(xhr, status, error) {
                console.log('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error);
            }
        });
    }
</script>
