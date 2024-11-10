const filter_Bttn = document.getElementById('filter_Bttn');
const filter_mobileCont = document.getElementById('filter_mobileCont');
const filter_xBttn = document.getElementById('filter_xBttn');

filter_Bttn.addEventListener('click', (e)=>{
    (filter_mobileCont.style.display === 'flex')? filter_mobileCont.style.display='none':filter_mobileCont.style.display='flex';
    e.stopPropagation();
})
filter_xBttn.addEventListener('click',(e)=>{
    (filter_mobileCont.style.display === 'flex')? filter_mobileCont.style.display='none':filter_mobileCont.style.display='flex';
    e.stopPropagation();
})

document.addEventListener('click', (e) => {
  if (filter_mobileCont.style.position === 'fixed' || !filter_mobileCont.contains(e.target) ) {
        filter_mobileCont.style.display = 'none';
    }
});

let priceRange = document.getElementById('priceRange');
let minPrice = document.getElementById('minPrice');

minPrice.innerHTML = "PHP " + 0;
priceRange.value = 0

priceRange.addEventListener('input', (e) => {
    minPrice.innerHTML = "PHP " + e.currentTarget.value;
})

let priceRange2 = document.getElementById('priceRange2');
let minPrice2 = document.getElementById('minPrice2');

minPrice2.innerHTML = "PHP " + 0;
priceRange2.value = 0

priceRange2.addEventListener('input', (e) => {
    minPrice2.innerHTML = "PHP " + e.currentTarget.value;
})