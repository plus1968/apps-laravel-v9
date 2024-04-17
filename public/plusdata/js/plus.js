var baseurl = 'http://127.0.0.1:8000/'
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    loadGI()
});
function loadGI(){
    $.post(baseurl+"loadGI", {Value:"1"},
        function (data, textStatus, jqXHR) {
            var res = data.split("^")
            $(".table-show").html(res)
        },
        
    );
}