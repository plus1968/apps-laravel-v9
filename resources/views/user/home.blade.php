@include('template.header')


<div id='apps'>

</div>



<div id='logsday'>

</div>


{{-- <div class="col-lg-12 mb-4 order-0" style="display: none;">
    <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-12">
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div> --}}



@include('template.footer')

<script>
    $(document).ready(function() {
        var baseurl = '/';
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        check_localst()
        load_page('1')


        $("#logout").click(function() {
            localStorage.removeItem('dbo_usr');
            window.location.replace(baseurl + 'login');

        })

        function check_localst() {
            var storedString = localStorage.getItem('dbo_usr');
            // console.log(storedString);


            if (storedString === null) {
                window.location.replace(baseurl + 'login');
            } else {
                var jsonParse = JSON.parse(storedString);
                // console.log(jsonParse)
                $('#jsonfullname').html(jsonParse.data.name)
            }
        }

    });

    function load_page(page) {
        var baseurl = '/';
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        switch (page) {
            case '1':
                var url = baseurl + 'load_page1'
                break;
            case '2':
                var url = baseurl + 'load_page2'
                break;
            case '3':
                var url = baseurl + 'load_page3'
                break
            case '4':
                var url = baseurl + 'load_page4'
                break
            case '5':
                var url = baseurl + 'load_page5'
                break
            case '6':
                var url = baseurl + 'load_page6'
                break
            case '7':
                var url = baseurl + 'load_page7'
                break
            case '8':
                var url = baseurl + 'load_page8'
                break
        }



        $.ajax({
            url: url,
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                page: page
            },
            success: function(response) {
                $('#apps').html(response)
            },
            error: function(xhr, status, error) {
                console.log('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error);
            }
        });
    }
</script>
