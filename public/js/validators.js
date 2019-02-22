var nsDate = false;
var nsStart = false;
var nsEnd = false;

function validateDateInput(value, startDate) {
    var start = new Date(value);
    var upperBound = new Date(startDate);
    var lowerBound = new Date(startDate);
    lowerBound.setDate(lowerBound.getDate() + 14);
    if (start >= upperBound && start <= lowerBound) {
        nsDate = true;
        document.querySelector('#nsError').innerHTML = "";
        document.querySelector('#nsDate').classList.remove("has-error");
    }
    else {
        document.querySelector('#nsError').innerHTML = "Invalid Date";
        document.querySelector('#nsDate').classList.add("has-error");
    }
    checkIsValid();
}

function startIsValid(value) {
    if (value) {
        nsStart = true;
    }
    else {
        nsStart = false;
    }
    checkIsValid();
}

function endIsValid(value) {
    if (value) {
        nsEnd = true;
    }
    else {
        nsEnd = false;
    }
    checkIsValid();
}

function nsIsValid() {
    if(nsDate && nsStart && nsEnd){
        return true;
    }
    document.querySelector('#nsError').innerHTML = "Fill all fields";
    return false;
}

function checkIsValid(){
    if(nsDate && nsStart && nsEnd){
        document.querySelector('#submitNewShift').classList.remove('disabled');
    }
}