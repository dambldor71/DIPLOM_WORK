const formAddPriority = document.getElementById('add-priority-form');

formAddPriority.addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем обычную отправку формы

    const formData = new FormData(formAddPriority);

    let priorityName = formData.get('name');
    let priorityCode = formData.get('code');
    let priorityColor = formData.get('color');

    console.log(priorityName, priorityCode, priorityColor)


    if (priorityName !== '' && priorityCode !== '') {
        $.ajax({
            url: '/priority-add',
            type: 'POST',
            data: {
                'userId': userId,
                'priorityName': priorityName,
                'priorityCode': priorityCode,
                'priorityColor': priorityColor
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response)
            {
                alert("Приоритет добавлен");
            },
            error: function(response) {
                console.log(response)
            }
        });
    }
});
