const formAddPriority = document.getElementById('tenderLinkUpdate');
const button = document.getElementById('updateTenderButton');

button.addEventListener('click', function (event) {
    event.preventDefault();

    let link = formAddPriority.getAttribute('href');

    $.ajax({
        url: '/testUpdate',
        type: 'POST',
        data: {
            'link': link
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(response)
        {
            console.log("Код отправлен на бэк")
        },
        error: function(response) {
            console.log(response)
        }
    });

    doSomethingWithDelay();
    console.log("Этот код выполнится почти сразу после начала");
})

function simulateSleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function doSomethingWithDelay() {
    console.log("Начало выполнения");
    await simulateSleep(2500);
    console.log("Прошло 2.5 секунды");
    location.reload(true);
    console.log("Продолжение выполнения");
}
