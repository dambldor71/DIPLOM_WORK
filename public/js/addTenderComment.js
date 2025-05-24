const formAddComment = document.getElementById('add-сomment-to-tender');

formAddComment.addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем обычную отправку формы

    const formData = new FormData(formAddComment);

    let comment = formData.get('comment');

    console.log(comment, tenderId)

    if (comment !== '') {
        $.ajax({
            url: '/add-comment',
            type: 'POST',
            data: {
                'userId': userId,
                'comment': comment,
                'tenderId': tenderId,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response)
            {
                alert("Комментарий к тендеру добавлен");
            },
            error: function(response) {
                console.log(response)
            }
        });
    }
});
