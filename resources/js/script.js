//обработка нажатия кнопи=ки "войти"
$('#btn_login').click(function () {
    $('.error').remove();
    $.ajax({
        type: "POST",
        url: "/auth/login/",
        dataType: "json",
        data: $('#authorization').serialize(),
        success: function (data) {
            if(data.auth){
                location.replace('/');
            } else{
                if (data.login_error) {
                    $('#password').after(`<p class="error">${data.login_error}</p>`);
                }
            }
        }
    })
})

//обработка нажатия кнопки "зарегистрироваться"
$('#btn_registration').click(function () {
    $('.error').remove();
    $.ajax({
        type: "POST",
        url: "/registration/new/",
        dataType: "json",
        data: $('#registration').serialize(),
        success: function (data) {
            if(data.registr){
                location.replace('/auth/');
            } else{
                for (let key in data) {
                    $(`#${key}`).after(`<p class="error">${data[key]}</p>`);
                }
            }
        }
    })
})

//Отправка данных формы обратной связи
$('#btn_send_contact_message').click(function () {
    $('.error').remove();
    $.ajax({
        type: "POST",
        url: "/contacts/new_message/",
        dataType: "json",
        data: $('#contact_message').serialize(),
        success: function (data) {
            if(data.was_send){
                $('#contact_message')[0].reset();
                $('#contact_was_send').addClass('no_hidden');
            } else{
                $('#contact_was_send').removeClass('no_hidden');
                for (let key in data) {
                    $(`#${key}`).after(`<p class="error">${data[key]}</p>`);
                }
            }
        }
    })
})

