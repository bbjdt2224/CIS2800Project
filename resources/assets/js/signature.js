/* Implement the signature functionality. Takes three DOM elements as 
 * arguments. Copied from email*/
function signature() {
  var signaturePad = new SignaturePad($('#signature').get(0), {
    backgroundColor: '#ffffff',
    penColor: '#000000'
  });

  $('#submit').get(0).addEventListener('click', function(event) {
    var dataUrl = signaturePad.toDataURL('image/jpeg');
    $('#signature-input').attr('value', dataUrl);
  });

  $('#clear-signature').get(0).addEventListener('click', function(event) {
    event.preventDefault();
    signaturePad.clear();
  });
}
