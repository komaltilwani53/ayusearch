let selectPlant = document.querySelector('.selected-plant-content');
let selectAnimal = document.querySelector('.selected-animal-content');
let selectCompound = document.querySelector('.selected-compound-content');

function selectPlantName(){
    selectPlant.classList = ['display-element selected-plant-content'];
    selectAnimal.classList = ['hide-element selected-animal-content'];
    selectCompound.classList = ['hide-element selected-compound-content'];
    document.getElementById('compound').value = 'Compound Name';
    document.getElementById('animal').value = 'Animal Name';
}
function selectAnimalName(){
    selectPlant.classList = ['hide-element selected-plant-content'];
    selectAnimal.classList = ['display-element selected-animal-content'];
    selectCompound.classList = ['hide-element selected-compound-content'];
    document.getElementById('compound').value = 'Compound Name';
    document.getElementById('plant').value = 'Plant Name';
}

function selectCompoundName(){
    selectPlant.classList = ['hide-element selected-plant-content'];
    selectAnimal.classList = ['hide-element selected-animal-content'];
    selectCompound.classList = ['display-element selected-compound-content'];
    document.getElementById('animal').value = 'Animal Name';
    document.getElementById('plant').value = 'Plant Name';
}

function resetValues(){
    compoudValue = document.getElementById('compound').value;
    plantValue = document.getElementById('plant').value;
    animalValue = document.getElementById('animal').value;
    console.log("data:",compoudValue,plantValue,animalValue)
}