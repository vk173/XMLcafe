function ajaxReadSettings(file){
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
      document.querySelector('meta[name="description"]').content = arraySettings[0].getElementsByTagName("description")[0].innerHTML;
      document.querySelector('#logo img').src = '../img/' + arraySettings[0].getElementsByTagName("logo")[0].innerHTML;

      document.getElementById('telephone').innerHTML = '<a href="tel:'
      + arraySettings[0].getElementsByTagName("tel")[0].innerHTML + '"><img src="../img/call.png" alt="Telephone"><span>'
      + arraySettings[0].getElementsByTagName("tel")[0].innerHTML + '<span><img src="../img/timeW.png" alt="Time">'
      + arraySettings[0].getElementsByTagName("time")[0].innerHTML + '</span></span></a>';

      var map = arraySettings[0].getElementsByTagName("map")[0].innerHTML.replace(/&quot;/g, '"').replace(/&lt;/g, '<').replace(/&gt;/g, '>');
      document.getElementById('contacts').innerHTML = '<h2>Contacts</h2><div class="contactList"><p>'+ arraySettings[0].getElementsByTagName("address")[0].innerHTML + '</p><p><img src="img/time.png" alt="Time">'+ arraySettings[0].getElementsByTagName("time")[0].innerHTML + '</p><a href="tel:' + arraySettings[0].getElementsByTagName("tel")[0].innerHTML + '"><img src="img/call-cont.png" alt="Telephone">' +arraySettings[0].getElementsByTagName("tel")[0].innerHTML + '</a><a href="mailto:'+ arraySettings[0].getElementsByTagName("email")[0].innerHTML + '"><img src="img/mail.png" alt="Mail">'+ arraySettings[0].getElementsByTagName("email")[0].innerHTML + '</a></div><div class="map">' + map + '</div>';
    }
  }
  xmlObj.open ('GET', file, true);
  xmlObj.send ();
}
ajaxReadSettings('xml/settings.xml');

function ajaxReadMenu(file){
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
      const arrayNav = xmlObj.responseXML.getElementsByTagName('nameMenu');
      const arrayMenu = xmlObj.responseXML.getElementsByTagName('menu');

      for (var i = 0; i < arrayNav.length; i++) {
        if (arrayNav[i].length !== 0 && arrayNav[i].firstChild != null) {
          var nameMenu = arrayNav[i].firstChild.data;
        } else {
          nameMenu = 'нет nameMenu';
        }
        if (nameMenu != 'нет nameMenu') {
          var hrefI = i+1;
          document.getElementById('ulNav').innerHTML +=
          '<li id="svgMenu' + hrefI + '" class="svg"><a href="#blockMenu' + hrefI + '" class="scroll-to">' + nameMenu + '</a></li>';
          document.getElementById('MenuSection').innerHTML +=
          '<section id ="blockMenu' + hrefI + '"><h2>' + nameMenu + '</h2><ul id="menu' + hrefI + '" class="thumbs product-list"></ul></section>';
        }
      }

      for (var item = 0; item < arrayMenu.length; item++) {
        let array = arrayMenu[item].getElementsByTagName('item');
        let hrefId = 'menu' + (item+1);
        for (var i = 0; i < array.length; i++) {
          let hiddenButton = '';
          if (array[i].getElementsByTagName('name').length !== 0 && array[i].getElementsByTagName('name')[0].firstChild != null) {
            var name = array[i].getElementsByTagName('name')[0].firstChild.data;
          } else {
            name = 'нет name';
          }
          if (array[i].getElementsByTagName('description').length !== 0 && array[i].getElementsByTagName('description')[0].firstChild != null) {
            var description = array[i].getElementsByTagName('description')[0].firstChild.data;
          } else {
            description = '';
          }
          if (array[i].getElementsByTagName('weight').length !== 0 && array[i].getElementsByTagName('weight')[0].firstChild != null) {
            var weight = array[i].getElementsByTagName('weight')[0].firstChild.data;
          } else {
            weight = '?';
            hiddenButton = 'hidden';
          }
          if (array[i].getElementsByTagName('price').length !== 0 && array[i].getElementsByTagName('price')[0].firstChild != null) {
            var price = array[i].getElementsByTagName('price')[0].firstChild.data;
          } else {
            price = '?';
            hiddenButton = 'hidden';
          }
          if (array[i].getElementsByTagName('img').length !== 0 && array[i].getElementsByTagName('img')[0].firstChild != null) {
            var img = array[i].getElementsByTagName('img')[0].firstChild.data;
          } else {
            img = 'not.png';
          }
          document.getElementById(hrefId).innerHTML +=
          '<li itemscope itemprop="hasMenuItem" itemtype="https://schema.org/MenuItem"><div class="image"><div class="badge-wrapper"><img itemprop="image" alt="' + name + '" title="' + name + '" src="/img/menu/' + img + '"></div></div><h5><span itemprop="name">' + name + '</span></h5><span itemprop="description" class="summary">' + description + '</span><table class="features ' + hiddenButton + '"><tbody><tr><td class="name">Weight: </td><td class="value" itemprop="description">' + weight + ' oz</td></tr></tbody></table><div class="add-input"><button type="button" onclick="this.nextElementSibling.stepDown()"' + hiddenButton + '>-</button><input class="add" type="number" min="0" onblur="if(this.value<0) this.value=0" value="" data-name="' + name + '" data-price="' + price + '" data-weight="' + weight + '" readonly><button type="button" onclick="this.previousElementSibling.stepUp()"' + hiddenButton + '>+</button></div><div itemprop="offers" class="offers ' + hiddenButton + '" itemscope itemtype="https://schema.org/Offer"><div class="pricing"><span class="price nowrap"><span>$</span>' + price + '</span><meta itemprop="price" content="' + price + '"><meta itemprop="priceCurrency" content="$"></div></div></li>';
        }
      }
    }
  }
  xmlObj.open ('GET', file, true);
  xmlObj.send ();
}
ajaxReadMenu('xml/menu.xml');

function ajaxReadSlider(file){
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
      const arraySlider = xmlObj.responseXML.getElementsByTagName('name');
      console.log(arraySlider.length);
      if (arraySlider.length > 0) {
          let div = document.createElement('div');
          div.className = "interior";
          div.id = "interior";
          div.innerHTML = '<h2>Interior</h2><div class="interiorSlider"><div id="boxSlider" class="box-slider"></div><div id="divDot" class="div-dot"></div></div>';
          console.log(div);
          document.getElementById('content').prepend(div);
          document.querySelector('.topNav').innerHTML += '<a id="hrefInterior" href="#interior">Interior</a>';
          document.querySelector('.navNegative').innerHTML += '<li><a id="hrefMobileInterior" href="#interior">Interior</a></li>';
      for (var i = 0; i < arraySlider.length; i++) {
        if (arraySlider[i].length !== 0 && arraySlider[i].firstChild != null) {
          document.getElementById('boxSlider').innerHTML += '<div class="slider fade"><img src="img/slider/' + arraySlider[i].firstChild.data + '" alt=""></div>';
          document.getElementById('divDot').innerHTML += '<span class="dot" onclick="currentSlide(' + Math.round(i + 1) + ')"></span>';
        }
      }
        }
    }
  }
  xmlObj.open ('GET', file, true);
  xmlObj.send ();
}
ajaxReadSlider('xml/slider.xml');
