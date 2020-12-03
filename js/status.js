function readSettings(file){
  var xmlObj;
  if(window.XMLHttpRequest){
    xmlObj = new XMLHttpRequest();
  } else if(window.ActiveXObject){
    xmlObj = new ActiveXObject("Microsoft.XMLHTTP");
  } else {
    return;
  }
  xmlObj.onreadystatechange = function(){
    if(xmlObj.readyState == 4){
      const arraySettings = xmlObj.responseXML.getElementsByTagName('root');

      document.querySelector('title').innerHTML = arraySettings[0].getElementsByTagName("name")[0].innerHTML;
      document.querySelector('#logo img').src = '../img/' + arraySettings[0].getElementsByTagName("logo")[0].innerHTML;

    }
  }
  xmlObj.open ('GET', file, true);
  xmlObj.send ();
}
readSettings('xml/settings.xml');



function getCookie(name) {
let matches = document.cookie.match(new RegExp(
  "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
));
return matches ? decodeURIComponent(matches[1]) : undefined;
}
const numOrder = getCookie('num');
const dateOrder = getCookie('date');

function ajaxRead(file){
  var xmlObj;
  if(window.XMLHttpRequest){
    xmlObj = new XMLHttpRequest();
  } else if(window.ActiveXObject){
    xmlObj = new ActiveXObject("Microsoft.XMLHTTP");
  } else {
    return;
  }
  xmlObj.onreadystatechange = function(){
    if(xmlObj.readyState == 4){
      const statusOrder = xmlObj.responseXML.getElementsByTagName('status')[0].firstChild.data;
      var messageOrder = document.getElementById('messageOrder');
      messageOrder.innerHTML = 'Order №'  + numOrder + '<h2>' + statusOrder + '</h2>';
      if(statusOrder == 'Awaiting verification') document.getElementById('statusImg').className = 'check';
      if(statusOrder == 'Cooking') document.getElementById('statusImg').className = 'cook';
      if(statusOrder == 'Sent by courier') document.getElementById('statusImg').className = 'check';
      if(statusOrder == 'Delivered') document.getElementById('statusImg').className = 'check';
      if(statusOrder == 'Cancelled') document.getElementById('statusImg').className = 'cancel';
    }
  }
  xmlObj.open ('GET', file, true);
  xmlObj.send ();
}
const fileRead = 'xml/this/' + dateOrder + 'order' + numOrder + '.xml';
setInterval(function(){ajaxRead(fileRead)}, 5000);
setInterval(function(){document.getElementById('messageOrder').classList.remove('preloader');}, 5000);
