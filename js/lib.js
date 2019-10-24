function objDump(object) {
    var out = "";
    if (object && typeof(object) == "object") {
        for (var i in object) {
            out += i + ": " + object[i] + "\n";
        }
    } else {
        out = object;
    }
    console.log(out);
}

$(document).ready(function () {
    $('.js-validate').on('keyup change', function () {
        var name = $('#name').val();
        var email = $('#email').val();
        var errors;
        $.ajax({
            type: 'POST',
            url: '/ajax_validate.php',
            data: {name: name, email: email},
            success: function (data) {
                if (data == 1) {
                    console.log("valid" + data);
                    errors = 0;
                    $("#registration").attr('disabled', false);
                    $("#registration").addClass('alert alert-success');
                    $("#errors").empty();
                } else {
                    console.log(objDump(data));
                    errors = 1;
                    $("#registration").attr('disabled', true);
                    $("#registration").removeClass('alert alert-success');
                    $("#errors").empty();
                    for (var i in data) {
                        $("#errors").append(i + " : " + data[i]+"<br>");
                    }
                }
            },
            dataType: "json",
        });
    });
});