<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script>
    $.ajax({
        url: 'http://artcraft/api.php?key=8038730764&type=xml',
        // dataType: 'xml',
        success: function (data) {
            console.log(data);
        }
    });
</script>