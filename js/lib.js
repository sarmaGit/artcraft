// ждем загрузки DOM
$(document).ready(function () {
    // блокируем кнопку отправки до того момента, пока все поля не будут проверены
    // $('#reg').prop('disabled', true);

    // elements содержит количество элементов для валидации
    var elements = $('.validation').length;

    // has содержит количество элементов успешно прощедших валидацию
    var has;

    // при изменении значения поля
    $('.validation').change(function () {

        // формируем массив для отправки на сервер, нас интересуют значение поля и css-классы
        //на сервере массив будет доступен в виде $_POST['validation']['name']['value'] и т.п.
        var name = $(this).attr('name');
        var val = $(this).val();
        var data = {};
        data = name + '=' + val;
        // data['validation[' + name + '][class]'] = $(this).attr('class');

        // делаем ajax-запрос методом POST на текущий адрес, в ответ ждем данные HTML
        $.ajax({
            type: 'POST',
            url: '/reg_validate.php',
            dataType: 'html',
            data: data,
            // до выполнения запроса удаляем блок с предыдущими сообщениями
            // beforeSend: function()
            // {
            //     $('#row-' + name + ' div.msg').remove();
            // },
            // в случае удачного выполнения добавляем блок с сообщением
            success: function (msg) {
                // $('#row-' + name).append(msg);
                console.log(msg);
            }
        });

        // проверяем, все ли поля прошли валидацию (признак - css-класс "ok" у блока сообщения) и разблокируем кнопку отправки на сервер
        // has = $('.row:has(div.ok)').length + 1;
        // if (has == elements)
        // {
        //     $('#reg').prop('disabled', false);
        // }
    });
});