document.addEventListener('DOMContentLoaded', function() {
    addToEdit();
});

document.getElementById('attributeSelect').addEventListener('change', function() {
    addToEdit();
});

function addToEdit() {
    const selectElement = document.getElementById('attributeSelect');
    const selectedOption = selectElement.options[selectElement.selectedIndex];

    const name = selectedOption.getAttribute('data-name');

    document.getElementById('nameUpdate').value = name || '';
}