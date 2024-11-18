
var swiper = new Swiper(".mySwiper", {
    slidesPerView: 4.8,
    spaceBetween: "4px",
    freeMode: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      320:{
        slidesPerView: 2, 
        spaceBetween: 0,
      },
      640: {
        slidesPerView: 3, 
        spaceBetween: 0,
      },
      1030:{
        slidesPerView: 5.2,
        spaceBetween: 0,
      }
    }
    
  });
 