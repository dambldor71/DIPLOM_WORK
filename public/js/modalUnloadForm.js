const openUnloadBtn = document.getElementById('openUnloadBtn');
const unloadModal = document.getElementById('unloadModal');
const closeButton = document.querySelector('.close-button');
const unloadForm = document.getElementById('unloadForm');

openUnloadBtn.addEventListener('click', () => {
    unloadModal.style.display = 'block';
});

closeButton.addEventListener('click', () => {
    unloadModal.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === unloadModal) {
        unloadModal.style.display = 'none';
    }
});

// unloadForm.addEventListener('submit', function (event) {
//
//     const formData = new FormData(unloadForm);
//
//     event.preventDefault(); // Предотвращаем стандартную отправку формы
//
//     let fileName = formData.get('file-name');
//     let uploadKind= formData.get('kinds');
//     let needField = getCheckedCheckboxes();
//
//     if (needField.length === 0) {
//         alert('Для формирования отчёта необходимо указать минимум 1 поле.')
//     }
// });

// function getCheckedCheckboxes() {
//     const checkboxes = document.querySelectorAll('input[name][type="checkbox"]:checked');
//     const checkedValues = [];
//
//     checkboxes.forEach(function(checkbox) {
//         checkedValues.push(checkbox.value);
//     });
//
//     console.log('Выбранные значения:', checkedValues);
//
//     return checkedValues;
// }
