const formDeletePriority = document.getElementById('delete-priority-form');

formDeletePriority.addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем обычную отправку формы


    let priorityId = document.getElementById('selectPriority').value;

    $.ajax({
        url: '/priority-delete',
        type: 'POST',
        data: {
            'priorityId': priorityId,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(response)
        {
            alert("Приоритет удалён");
        },
        error: function(response) {
            console.log(response)
        }
    });

    location.reload(true);
});
