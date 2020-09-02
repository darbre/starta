window.onload = function() {
    $($('input[id="phone"]')[0]).inputmask({
        mask: '+7 (999) 999-99-99',
        removeMaskOnSubmit: true,
        clearMaskOnLostFocus: false
    });
    var n = $('input[name = "phone"]')[0];
    n.oninput = function(e) {
        document.getElementById("alert").innerHTML = '';
    };
    var td = $('.calendar table td'),te;
    $(td).click(function() {
        document.getElementById("alert").innerHTML = '';
        if (!this.classList.contains('choice')) {
            $(td).removeClass('choice');
            this.classList.add('choice');
            $('input[id="data"]')[0].value = this.getAttribute('data');
        } else {
            this.classList.remove('choice');
            $('input[id="data"]')[0].value = '';
        }
    })
    $('#button').click(function() {
        if ($('input[id="data"]')[0].value == '') {
            document.getElementById("alert").innerHTML = 'Выберите дату';
        } else if (!$($('input[id="phone"]')[0]).inputmask("isComplete")) {
            document.getElementById("alert").innerHTML = 'Введите номер телефона';
        } else {
            var formData = $('form').serialize();

            $.post("ajax.php", formData, function(data) { //  передаем и загружаем данные с сервера с помощью HTTP запроса методом POST
                if (data == 'ok') {
                	te=$('input[id="data"]')[0].value
                    alert('Забронирована дата '+te+' на номер телефона '+$('input[id="phone"]')[0].value+'!')
                    $('.calendar table td[data="'+te+'"]')[0].classList.remove('choice')
                    $('.calendar table td[data="'+te+'"]')[0].classList.add('reserved')
                    $('input[id="data"]')[0].value=''
                    $('input[id="phone"]')[0].value=''
                } else {
                    alert('Ошбика на стороне сервера!')
                }
            })
        }
    })

}