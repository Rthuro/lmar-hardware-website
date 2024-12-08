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


const category = [
  {
    link: "products.php?category=",
    img: "/frontend/assets/category_img/10.png",
    name: "All Products",
  },
  {
    link: "products.php?category=Hand%20Tools",
    img: "/frontend/assets/category_img/1.png",
    name: "Hand Tools",
  },
  {
    link: "products.php?category=Measuring%20Tools",
    img: "/frontend/assets/category_img/2.png",
    name: "Measuring Tools",
  },
  {
    link: "products.php?category=Cutting%20Tools",
    img: "/frontend/assets/category_img/3.png",
    name: "Cutting Tools",
  },
  {
    link: "products.php?category=Fastening%20Tools",
    img: "/frontend/assets/category_img/4.png",
    name: "Fastening Tools",
  },
  {
    link: "products.php?category=Grinding%20Tools",
    img: "/frontend/assets/category_img/5.png",
    name: "Grinding Tools",
  },
  {
    link: "products.php?category=Clamping%20Tools",
    img: "/frontend/assets/category_img/6.png",
    name: "Clamping Tools",
  },
  {
    link: "products.php?category=Finishing%20Tools",
    img: "/frontend/assets/category_img/7.png",
    name: "Finishing Tools",
  },
  {
    link: "products.php?category=Building%20Materials",
    img: "/frontend/assets/category_img/9.png",
    name: "Building Materials",
  },
];


const categoryContainer = document.getElementById('categoryContainer');

function createCategory(category){
    const fragment = document.createDocumentFragment();
    category.forEach(data=>{
        const categoryCont = document.createElement('a');
        categoryCont.classList.add('categoryCont');
        categoryCont.href = data.link;
        const categoryImg = document.createElement('img');
        categoryImg.classList.add('categoryImg');
        categoryImg.src = data.img;
        categoryCont.appendChild(categoryImg);

        const categoryName = document.createElement('p');
        categoryName.classList.add('absolute', 'top-0', 'bottom-0','right-0','left-0');
        categoryName.textContent = data.name;
        categoryCont.appendChild(categoryName);

        fragment.appendChild(categoryCont);
    });

    return fragment;
}

categoryContainer.appendChild(createCategory(category));

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
