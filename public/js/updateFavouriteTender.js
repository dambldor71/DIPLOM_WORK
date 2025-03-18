$(document).ready(function (){

    $('.tender-status').click(function () {
        let $this = $(this);
        const priority = this.id;
        let tenderId = $this.closest('.dropdown-menu').attr('id');
        console.log(priority, tenderId)
        console.log(userId);

        $.ajax({
            url: '/favourite-add',
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
                alert('Тендер добавлен в избранное.');
            },
            error: function(response) {
                console.log(response)
            }
        });

        const locationPathName = (window.location.pathname).split('/');

        if (locationPathName[1] === 'catalog' && locationPathName.length === 3) {
            window.location.href = 'http://127.0.0.1:8000/favourite-catalog/' + locationPathName[2];
        } else {
            location.reload(true);
        }
    })

    $('.tender-stage').click(function () {
        let $this = $(this);
        const stage = this.id;
        let tenderId = $this.closest('.dropdown-menu').attr('id');

        $.ajax({
            url: '/favourite-stage',
            type: 'POST',
            data: {
                'tenderId': tenderId,
                'userId': userId,
                'stage': stage
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response)
            {
                alert("Этап тендера обновлён");
            },
            error: function(response) {
                console.log(response)
            }
        });

        location.reload(true);
    })
})
