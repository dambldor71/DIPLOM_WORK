const formAddParsingTime = document.getElementById('add-parsing-time-form');

formAddParsingTime.addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем обычную отправку формы

    const formData = new FormData(formAddParsingTime);

    let allTendersTime = formData.get('all-time');
    let favouriteTendersTime = formData.get('favourite-time');

    console.log(formData);
    console.log(allTendersTime, favouriteTendersTime)

    $.ajax({
        url: '/parsing-time-add',
        type: 'POST',
        data: {
            'userId': userId,
            'allTendersTime': allTendersTime,
            'favouriteTendersTime': favouriteTendersTime,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(response)
        {
            alert("Данные часоты парсинга обновлены");
        },
        error: function(response) {
            console.log(response)
        }
    })
});
