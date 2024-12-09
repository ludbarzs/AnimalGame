document.addEventListener('DOMContentLoaded', function() {
    setImage();
    addToEdit();
});

document.getElementById('animalSelect').addEventListener('change', function() {
    
    setImage();
    addToEdit();

});

function setImage(){
    const id = document.getElementById('animalSelect');
    const selectedId = id.value + "-img";
    console.log(selectedId);
    const images = document.querySelectorAll('.animal-img');
    images.forEach(image => {
        image.classList.remove('show');
        image.classList.add('hide');
    });

    const selectedImage = document.getElementById(selectedId);
    if (selectedImage) {
        selectedImage.classList.remove('hide');
        selectedImage.classList.add('show');
    }
}


function addToEdit() {
    const selectElement = document.getElementById('animalSelect');
    const selectedOption = selectElement.options[selectElement.selectedIndex];

    const name = selectedOption.getAttribute('data-name');
    const species = selectedOption.getAttribute('data-species');
    const description = selectedOption.getAttribute('data-description');

    document.getElementById('nameUpdate').value = name || '';
    document.getElementById('speciesUpdate').value = species || '';
    document.getElementById('descriptionUpdate').value = description || '';
}