
$(document).ready(function (){

    $('.tender-status').click(function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        let $this = $(this);
        const priority = this.id;
        let tenderId = $this.closest('.dropdown-menu').attr('id');
        console.log(priority, tenderId)
        console.log(userId);
        console.log(csrfToken);

        // $.ajax({
        //     method: 'POST',
        //     url: 'http://127.0.0.1:8001/chosentender',
        //     headers: {
        //         'X-CSRF-TOKEN': csrfToken
        //     },
        //     data: {
        //         'tenderId': tenderId,
        //         'userId': userId,
        //         'priority': priority
        //     },
        //     success:function(response)
        //     {
        //
        //     },
        //     error: function(response) {
        //     }
        // });
    })
})
