$(document).ready(function (){

    $('.close-button').click(function (event) {
        let $this = $(this);

        let tenderId = event.target.id
        console.log(tenderId)
        console.log(userId);

        $.ajax({
            url: '/favourite-delete',
            type: 'POST',
            data: {
                'tenderId': tenderId,
                'userId': userId,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response)
            {
                alert("Тендер удалён из избранного");
            },
            error: function(response) {
                console.log(response)
            }
        });

        location.reload(true);
    })
})
