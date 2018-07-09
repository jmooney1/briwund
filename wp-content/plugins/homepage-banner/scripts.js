jQuery(document).ready(function($){


var currentIndex = 0,
  items = $('.homebanner .banner'),
  itemAmt = $('div.homebanner').children('div').length;
  console.log(itemAmt);

function cycleItems() {
  var item = $('.homebanner .banner').eq(currentIndex);
  items.hide();
  //item.css('display','inline-block');
  item.show();
}

var autoSlide = setInterval(function() {
  currentIndex += 1;
  if (currentIndex > itemAmt - 1) {
    currentIndex = 0;
  }
  cycleItems();
}, 5000);

$('.next').click(function() {
  clearInterval(autoSlide);
  currentIndex += 1;
  if (currentIndex > itemAmt - 1) {
    currentIndex = 0;
  }
  cycleItems();
});

$('.prev').click(function() {
  clearInterval(autoSlide);
  currentIndex -= 1;
  if (currentIndex < 0) {
    currentIndex = itemAmt - 1;
  }
  cycleItems();
});
})

