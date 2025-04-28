const sorting = document.getElementById('select-sort');
const usingFilters = document.getElementById('using-filters');

sorting.addEventListener('change', function () {
    var selectedValue = this.value;

    const newValue = document.createElement('input');
    newValue.type = 'hidden';
    newValue.name = 'sortParameter';
    newValue.value = this.value;
    usingFilters.appendChild(newValue);

    if (usingFilters) {
        usingFilters.submit();
    }
})

