const formDeleteStage = document.getElementById('delete-stage-form');

formDeleteStage.addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем обычную отправку формы


    let stageId = document.getElementById('selectStage').value;

    $.ajax({
        url: '/stage-delete',
        type: 'POST',
        data: {
            'stageId': stageId,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(response)
        {
            alert("Этап удалён");
        },
        error: function(response) {
            console.log(response)
        }
    });
});
