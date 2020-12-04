window.onscroll = function() {
  stickNav();
  selectAdd();
};
window.onclick = function() {
  calc();
  scrollT();
};
window.header.onclick = function () { hrefTopNav(); }
window.onload = function() {
  scrollT();
  stickNav();
  modal();
  mobileNav();
  orderCookie();
};

function stickNav() {
  var top = document.getElementById("nav").getBoundingClientRect().top;
  var btm = document.getElementById("header").getBoundingClientRect().bottom;

  if (top <= 0) {
    document.getElementById("nav").classList.add("stick");
    document.getElementById("top").classList.add("marginTop");
  }

  if (btm > 1) {
    document.getElementById("nav").classList.remove("stick");
    document.getElementById("top").classList.remove("marginTop");
  }
};

var lastScrollTop = 0;
window.addEventListener("scroll", function(event){
var st = document.getElementById("main").getBoundingClientRect().top;
if (st > lastScrollTop && lastScrollTop < -20){
  document.getElementById("nav").classList.add("off");
} else {
document.getElementById("nav").classList.remove("off");

}
lastScrollTop = st;
});









function selectAdd() {
  const sections = document.querySelectorAll('section');
  for (let anchor of sections) {
    var tp = anchor.getBoundingClientRect().top;
    var btm = tp + anchor.getBoundingClientRect().height;
    var id = anchor.getAttribute('id');
    var selectAdd = 'a[href="#'+id+'"]';
    if( 0 >= Math.floor(tp) && 0 < Math.floor(btm)){
      document.querySelector(selectAdd).classList.add('active');
      var screenWidth = window.screen.width;
      var elNavWidth = document.querySelector(selectAdd).scrollWidth;
      var elNavLeft = document.querySelector(selectAdd).getBoundingClientRect().left;
      var thisSize = elNavWidth + elNavLeft;
      if(thisSize > screenWidth)document.querySelector('#nav').scrollBy(10, 0);
      if(elNavLeft < 0)document.querySelector('#nav').scrollBy(-10, 0);
    }else{
      document.querySelector(selectAdd).classList.remove('active');
    }
  }
};

function scrollT() {
  var linkNav = document.querySelectorAll('[href*="#"]'),
  V = 0.2;
  linkNav.forEach(function(i){
    i.addEventListener('click', function(e) {
      e.preventDefault();

      var w = window.pageYOffset,
      hash = this.getAttribute('href');
      t = document.querySelector(hash).getBoundingClientRect().top,
      start = null;
      requestAnimationFrame(step);
      function step(time) {
        if (start === null) start = time;
        var progress = time - start,
        r = (t < 0 ? Math.max(w - progress/V, w + t) : Math.min(w + progress/V, w + t));
        window.scrollTo(0,r);
        if (r != w + t) {
          requestAnimationFrame(step)
        } else {
          location.hash = hash;
        }
      }
    }, false);
  });
};

function calc() {
  const array = document.querySelectorAll('.add');

  var it1 = 0;
  var it2 = 0;
  var it3 = '';
  var it4 = '';

  array.forEach(function(i){

    if (i.value > 0) {
      it1 += i.value*i.dataset.price;
      it2 += i.value*i.dataset.weight;
      it3 += '<p>'+i.dataset.name+' ('+i.dataset.weight+' oz)'+' — '+i.value+' pc.</p>';
      it4 += i.dataset.name+' ('+i.dataset.weight+' oz)'+' — '+i.value+' pc.'+'\n';
    }

  });
  if (it1 > 0) {
    document.querySelector('#cart-modal').classList.add('on-cart');
    document.querySelector('#on-cart').classList.remove('hidden');
    it1 = Math.round(it1*10)/10;
    document.querySelector('#on-cart').innerHTML = '$'+it1;
  }else{
    document.querySelector('#cart-modal').classList.remove('on-cart');
    document.querySelector('#on-cart').classList.add('hidden');
    document.querySelector('#on-cart').innerHTML = '';
  };
  var out = document.querySelector('#out');
  var list = document.querySelector('#list');
  var dataList = document.querySelector('#dataList');
  var it2lb = it2/16;
  it2lb = Math.round(it2lb*10)/10;
  it1 = Math.round(it1*10)/10;

  out.innerHTML = '<span>Total </span> $'+it1+'<br><span>Weight </span>'+it2lb+' lb';
  list.innerHTML = it3;
  dataList.value = it3 + '<total>$'+it1+'</total><weight>'+it2lb+' lb</weight>';
};

function modal() {
  var modalButtons = document.querySelectorAll('.js-open-modal'),
  overlay      = document.querySelector('.js-overlay-modal'),
  closeButtons = document.querySelectorAll('.js-modal-close');

  modalButtons.forEach(function(item) {
    item.addEventListener('click', function(e) {
      e.preventDefault();

      var modalId = this.getAttribute('data-modal'),
      modalElem = document.querySelector('.modal[data-modal="' + modalId + '"]');
      modalElem.classList.add('active');
      overlay.classList.add('active');
    });
  });

  closeButtons.forEach(function(item){
    item.addEventListener('click', function(e) {
      var parentModal = this.closest('.modal');

      parentModal.classList.remove('active');
      overlay.classList.remove('active');
    });
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

// MOBILE nav
function mobileNav () {
document.getElementById('mobileNav').addEventListener('click', function(e) {
  if (!document.getElementById('navNegative').classList.contains('active')) {
    document.getElementById('navNegative').classList.add('active')
  } else {
    document.getElementById('navNegative').classList.remove('active')
  }
});
}

function hrefTopNav() {
  var elСheck = document.getElementById('interior');
  document.getElementById('hrefContacts').addEventListener('click', function(e) {
    document.getElementById('contacts').classList.add('active');
    if (elСheck) document.getElementById('interior').classList.remove('active');
  });
   if (elСheck) {
  document.getElementById('hrefInterior').addEventListener('click', function(e) {
    document.getElementById('interior').classList.add('active');
    document.getElementById('contacts').classList.remove('active');
    showSlide(1);
  });}
  document.getElementById('logo').addEventListener('click', function(e) {
    if (elСheck) document.getElementById('interior').classList.remove('active');
    document.getElementById('contacts').classList.remove('active');
  });
  document.getElementById('hrefMobileContacts').addEventListener('click', function(e) {
    document.getElementById('contacts').classList.add('active');
    if (elСheck) document.getElementById('interior').classList.remove('active');
  });
  if (elСheck) {
  document.getElementById('hrefMobileInterior').addEventListener('click', function(e) {
    document.getElementById('interior').classList.add('active');
    document.getElementById('contacts').classList.remove('active');
    showSlide(1);
  });}
}
function orderCookie() {
  var orderNum = document.cookie.match(new RegExp(
    "(?:^|; )" + 'num'.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  if (orderNum) {
    orderNum = decodeURIComponent(orderNum[1])
    document.getElementById('on-order').classList.remove('hidden');
  } else {
    orderNum = undefined;
  }
}




var slideIndex = 1;
showSlide(slideIndex);

function pushSlides(n) {
  showSlide(slideIndex += n);
}

function currentSlide(n) {
  showSlide(slideIndex = n);
}

function showSlide(n) {
  var i;
  var slides = document.getElementsByClassName("slider");
  var dots = document.getElementsByClassName("dot");

  if (n > slides.length) {
    slideIndex = 1;
  }
  if (n < 1) {
    slideIndex = slides.length;
  }
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none"
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace("active", "")
  }
  if(slides[slideIndex-1] !=  undefined) slides[slideIndex-1].style.display = "block";
  if(slides[slideIndex-1] !=  undefined) dots[slideIndex-1].className += " active";
}
var pushSlidesRun = setInterval(function() {
  pushSlides(1);
}, 4000);
