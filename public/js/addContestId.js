const formAddId = document.getElementById('add-id-winner-to-tender');

formAddId.addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем обычную отправку формы

    const formData = new FormData(formAddId);

    let potentialId = formData.get('contest-id');

    console.log(potentialId, tenderId)

    if (potentialId !== '') {
        $.ajax({
            url: '/potential-winner',
            type: 'POST',
            data: {
                'userId': userId,
                'potentialId': potentialId,
                'tenderId': tenderId,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response)
            {
                alert("Идентификационный номер участника добавлен");
            },
            error: function(response) {
                console.log(response)
            }
        });

        location.reload(true);
    }
});
