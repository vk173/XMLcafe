function addIndexEl() {
  var arrayUl = document.getElementsByTagName('ul');
  for (var i = 0; i < arrayUl.length; i++) {
    var arrayLi = arrayUl[i].getElementsByTagName('li');
    for (var item = 0; item < arrayLi.length; item++){
      var target = arrayUl[i].children[item];
      target.children[0].value = item+1;
    }
  }
}
function reName() {
  var arrayMenu = document.getElementById('root').children;
  for (var i = 0; i < arrayMenu.length; i++) {
    let arrayNameMenuUl = arrayMenu[i].children[1].children;
    let arrayNameMenuDiv = arrayMenu[i].children[2].children;
    arrayMenu[i].children[0].children[0].addEventListener('change', function (evt){
      let targetNameMenu = evt.target;
      for (var i = 0; i < arrayNameMenuUl.length; i++) {
        arrayNameMenuUl[i].children[1].value = targetNameMenu.value;
        if (arrayNameMenuUl[i].children[1].value == 0) arrayNameMenuUl[i].children[1].value = 'del';
      }
      for (var i = 0; i < arrayNameMenuDiv.length; i++) {
        arrayNameMenuDiv[i].children[0].value = targetNameMenu.value;
        if (arrayNameMenuDiv[i].children[0].value == 0) arrayNameMenuDiv[i].children[0].value = 'del';
      }
    }, false);
    let thisDiv = arrayMenu[i].id;
    arrayMenu[i].children[4].addEventListener('click', function (evt){
      let thisArray = document.getElementById(thisDiv);
      thisArray.children[2].lastChild.children[0].value = thisArray.children[0].children[0].value;
    }, false);
  }
}

function addName() {
  var arrayDataName = document.querySelectorAll('[type="file"]');

  for (var i = 0; i < arrayDataName.length; i++) {
    arrayDataName[i].addEventListener('change', function (evt){
    let targetNameMenu = evt.target;
    let nameId = targetNameMenu.id;
    let nameSelector = '[name="' + nameId + '"]';
    let nameFor = '[for="' + nameId + '"]';
    document.querySelector(nameSelector).value = targetNameMenu.files[0].name;
    document.querySelector(nameFor).innerHTML = targetNameMenu.files[0].name;
    document.querySelector(nameFor).removeAttribute('style');
  });
  }
}

function sortable(rootEl, onUpdate){
  var dragEl, nextEl;
  function _onDragOver(evt){
    evt.preventDefault();
    evt.dataTransfer.dropEffect = 'move';
    var target = evt.target;
    if( target && target !== dragEl && target.nodeName == 'LI' ){

      rootEl.insertBefore(dragEl, rootEl.children[0] !== target && target.nextSibling || target);
    }
  }

  function _onDragEnd(evt){
    evt.preventDefault();

    dragEl.classList.remove('ghost');
    rootEl.removeEventListener('dragover', _onDragOver, false);
    rootEl.removeEventListener('dragend', _onDragEnd, false);

    if( nextEl !== dragEl.nextSibling ){
      onUpdate(dragEl);
      addIndexEl()
    }
  }

  rootEl.addEventListener('dragstart', function (evt){
    dragEl = evt.target;
    nextEl = dragEl.nextSibling;

    evt.dataTransfer.effectAllowed = 'move';
    evt.dataTransfer.setData('Text', dragEl.textContent);

    rootEl.addEventListener('dragover', _onDragOver, false);
    rootEl.addEventListener('dragend', _onDragEnd, false);

    setTimeout(function (){

      dragEl.classList.add('ghost');
    }, 0)
  }, false);
}

for (var i = 1; i < 10; i++) {
  sortable( document.getElementById('list' + i), function (item){
  });
}


addIndexEl();
reName();
addName();
