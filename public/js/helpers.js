function removeButtons() {
  var buttons = document.getElementById('buttons');
  buttons.parentNode.removeChild(buttons);
  var back = document.getElementById('backButton');
  back.parentNode.removeChild(back);
  var nav = document.getElementById('quickNav');
  nav.parentNode.removeChild(nav);

  document.querySelector('#printPage').style.height = "400px";
  document.querySelector('#printPage').style.width = "1000px";
}
