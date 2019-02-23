function validateForm(form) {
    var elements = form.elements;
    var passed = true;
    for (var i = 0; i < elements.length; i ++){
        if (elements[i].nodeName === "INPUT") {
            if (elements[i].value == null || elements[i].value == "") {
                elements[i].parentNode.classList.add('has-error');
                passed = false;
            }
        }
    }
    return passed;
}