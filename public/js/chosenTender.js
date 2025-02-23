
$(document).ready(function (){

    $('.tender-status').click(function () {
        let $this = $(this);
        const priority = this.id;
        let tenderId = $this.closest('.dropdown-menu').attr('id');
        console.log(priority, tenderId)
        console.log(userId);

        $.ajax({
            url: '/set-priority',
            type: 'POST',
            data: {
                'tenderId': tenderId,
                'userId': userId,
                'priority': priority
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response)
            {
                alert("Тендер добавлен");
            },
            error: function(response) {
                console.log(response)
            }
        });

        location.reload(true);
    })
})
