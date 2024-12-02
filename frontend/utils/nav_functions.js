
const logoBtn = document.getElementById('logo');
logoBtn.addEventListener('click', function(){
    window.location.href = "landing_page.php";
});


const burger_menuBttn = document.getElementById('burger_menuBttn');
const burger_menu = document.getElementById('burger_menu');
burger_menu.style.display='none';
burger_menuBttn.addEventListener('click', ()=>{
    (burger_menu.style.display === 'none')? burger_menu.style.display='flex':burger_menu.style.display='none';
})

const burger_category = document.getElementById('burger_category');
const burger_categoryList = document.getElementById('burger_categoryList');
burger_category.addEventListener('click' , ()=>{
    (burger_categoryList.style.display === 'flex')? burger_categoryList.style.display = 'none':burger_categoryList.style.display ='flex';
               
})


const categoryDropdown = document.getElementById('categoryDropdown');
const categoryDropdownContainer = document.getElementById('categoryDropdownContainer');

categoryDropdownContainer.style.display = "none";


categoryDropdown.addEventListener("click", () => {
    if (categoryDropdownContainer.style.display === "none") {
        categoryDropdownContainer.style.display = "flex";
      
    } else {
        categoryDropdownContainer.style.display = "none";
        
    }
})


document.addEventListener('click', (e) => {
    if (!categoryDropdownContainer.contains(e.target)&&!categoryDropdown.contains(e.target) ) {
        categoryDropdownContainer.style.display = "none";
    }
});
categoryDropdownContainer.addEventListener('click', (e) =>{
    e.stopPropagation();
})

const loginBtn = document.getElementById('loginBtn');

if(loginBtn !== null){
    loginBtn.addEventListener("click", ()=> {
        window.location.href = "login_page.php";
    })
}


const cart = document.getElementById('cart');
const cartContainer = document.getElementById('cartContainer');

cartContainer.style.display = 'none';

cart.addEventListener('click', (e)=>{
    if(  cartContainer.style.display === 'none'){
            cartContainer.style.display = 'flex';
        } else {
            cartContainer.style.display = 'none';
        }
        e.stopPropagation();
        
})

