var nsDate = false;
var nsStart = false;
var nsEnd = false;

function validateDateInput(value, startDate) {
    var start = new Date(value);
    var upperBound = new Date(startDate);
    var lowerBound = upperBound;
    lowerBound.setDate(lowerBound.getDate() + 14);
    console.log(start, upperBound, lowerBound);
}