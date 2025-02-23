const formAddStage = document.getElementById('add-stage-form');

formAddStage.addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем обычную отправку формы

    const formData = new FormData(formAddStage);

    let stageName = formData.get('name');
    let stageCode = formData.get('code');

    if (stageName !== '' && stageCode !== '') {
        $.ajax({
            url: '/stage-add',
            type: 'POST',
            data: {
                'userId': userId,
                'stageName': stageName,
                'stageCode': stageCode,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response)
            {
                alert("Этап добавлен");
            },
            error: function(response) {
                console.log(response)
            }
        });
    }
});
