const order_nowBtn = document.getElementById('order_nowBtn');
const view_prodBtn = document.getElementById('view_prodBtn');
const view_allBtn = document.getElementById('view_allBtn');


order_nowBtn.addEventListener('click', function(){
    window.location.href = "login_page.php";
})
view_prodBtn.addEventListener('click',function (){
    window.location.href = "products.php";
})
view_allBtn.addEventListener('click',function (){
    window.location.href = "products.php";
})

const categoryImg = document.querySelectorAll('.categoryImg');
const categoryImgCont = document.querySelectorAll('.categoryCont p');

categoryImgCont.forEach((p, index) => {
    p.addEventListener("mouseover", () => {
        categoryImgCont[index].style.backgroundColor = "rgb(0,0,0,0.6)";
        categoryImgCont[index].style.color = "#FB951C";
        categoryImg[index].style.transform = "scale(1.5)";
    });
    p.addEventListener("mouseout", () => {
        categoryImgCont[index].style.backgroundColor = "rgb(0,0,0,0.2)";
        categoryImgCont[index].style.color = "#fff";
        categoryImg[index].style.transform = "scale(1)";
    })

});

const scrollArea = document.getElementById('scrollArea');
let isDown = false;
let startX;
let scrollLeft;

scrollArea.addEventListener('mousedown', (e) => {
  isDown = true;
  startX = e.pageX - scrollArea.offsetLeft;
  scrollLeft = scrollArea.scrollLeft;
});

scrollArea.addEventListener('mouseleave', () => {
  isDown = false;
});

scrollArea.addEventListener('mouseup', () => {
  isDown = false;
});

scrollArea.addEventListener('mousemove', (e) => {
  if (!isDown) return;
  e.preventDefault();
  const x = e.pageX - scrollArea.offsetLeft;
  const walk = (x - startX) * 2; 
  scrollArea.scrollLeft = scrollLeft - walk;
});