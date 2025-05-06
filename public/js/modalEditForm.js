const openModalBtn = document.getElementById('openModalBtn');
const profileModal = document.getElementById('profileModal');
const closeButton = document.querySelector('.close-button');
const profileForm = document.getElementById('profileForm');

openModalBtn.addEventListener('click', () => {
    profileModal.style.display = 'block';
});

closeButton.addEventListener('click', () => {
    profileModal.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === profileModal) {
        profileModal.style.display = 'none';
    }
});

profileForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Предотвращаем отправку формы

    const formData = new FormData(profileForm);


    let profileName = formData.get('user-name');
    let profileSurname = formData.get('user-surname');
    let profilePhone = formData.get('user-phone');
    let profileBirthday = formData.get('user-birthday');
    let profileOrganization = formData.get('user-organization');

    console.log(userId, profileName, profileSurname, profilePhone, profileBirthday);

    $.ajax({
        url: '/profile/update',
        type: 'POST',
        data: {
            'userId': userId,
            'name': profileName,
            'surname': profileSurname,
            'phone': profilePhone,
            'birthday': profileBirthday.toString(),
            'organization': profileOrganization,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(response)
        {
            alert("Данные пользователя обновлены");},
        error: function(response) {
            console.log(response)
        }
    });

    profileModal.style.display = 'none';
    location.reload(true);
});
