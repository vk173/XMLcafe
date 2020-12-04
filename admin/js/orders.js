function modal() {
  var overlay      = document.querySelector('.js-overlay-modal'),
  closeButtons = document.querySelector('.js-modal-close'),
  modalElem = document.querySelector('.modal[data-modal="order"]');
  modalElem.classList.add('active');
  overlay.classList.add('active');

  closeButtons.addEventListener('click', function(e) {
    var parentModal = this.closest('.modal');
    parentModal.classList.remove('active');
    overlay.classList.remove('active');
  });

  document.body.addEventListener('keyup', function (e) {
    var key = e.keyCode;

    if (key == 27) {
      document.querySelector('.modal.active').classList.remove('active');
      document.querySelector('.overlay').classList.remove('active');
    };
  }, false);

  overlay.addEventListener('click', function() {
    document.querySelector('.modal.active').classList.remove('active');
    this.classList.remove('active');
  });
};


var arrayOrder;
arrayOrder = 0;
var audio = new Audio();
audio.preload = 'alert';
audio.src = 'mp3/alert.mp3';
function ajaxRead(file){
  var xmlObj;
  if(window.XMLHttpRequest){
    xmlObj = new XMLHttpRequest();
  } else if(window.ActiveXObject){
    xmlObj = new ActiveXObject("Microsoft.XMLHTTP");
  } else {
    return; }
    xmlObj.onreadystatechange = function(){

      if (arrayOrder !== 0) {

        if(xmlObj.readyState == 4) {
          var newArrayOrder = xmlObj.responseXML.getElementsByTagName('order').length;
        if (arrayOrder == newArrayOrder) {
        } else {
          modal();
          audio.play();
        }
      }
    } else {
      if(xmlObj.readyState == 4){
        arrayOrder = xmlObj.responseXML.getElementsByTagName('order').length;
      }
        return arrayOrder;
      }}
      xmlObj.open ('GET', file, true);
      xmlObj.send ();
    }
    setInterval(function(){ajaxRead('../xml/orders.xml')}, 10000);
