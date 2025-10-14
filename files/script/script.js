console.log("script.js is loaded");
let cartImage = document.querySelector("#cart-img");
let cartAdd = document.querySelector(".carting");
let mainCart = document.querySelector(".cart-div");
let open = false;
let close = document.querySelector(".close");
let count = document.querySelector("#count"); 
let countNo = parseInt(count.innerText);
let i;
let decrease = document.querySelector(".decrease");
let increase = document.querySelector(".increase");
let listProductHTML = document.querySelector('#addItem');
let mainItemAdder = document.querySelector('#main-container');
let dayProduct = [];
let nightProduct = [];
let comboProduct = [];
let listProduct;
let morningSection = document.querySelector(".morning");
let eveningSection = document.querySelector(".evening");
let comboSection = document.querySelector(".combo");
let totalFood;
let d = new Date();





addMYfood = (timing) => {
  listProductHTML.innerHTML = ''; // clear product list first
 
  if (timing.length > 0) {

    timing.forEach(product => {
      listProductHTML.insertAdjacentHTML('beforeend', `

        <div class="col-sm-6 col-md-4">
          <div class="card h-100">
            <div class="card-img-top" 
                 style="background-image:url('${product.src}'); 
                        background-size: cover; 
                        background-position: center; 
                        height: 200px;">
            </div>
            <div class="card-body text-center">
              <h5 class="card-title">${product.name}</h5>
              <p class="card-text">₹${product.price}</p>
              <form action="./files/php/cart_conn.php" method="post">
                <input type="number" value="${product.id}" name="prod_id" hidden/>
                <input type="text" value="${window.location.href}" name="url" hidden/>
                <input type="text" name="popup" hidden/>
                <button type="submit" name="submit" class="btn w-100" style="background-color: brown; color: white;" onclick="addtoCart(${product.id}); popup();">Cart</button>
              </form>
            </div>
          </div>
        </div>

      `);
    });
  }
}

addMyCombo = () =>{
    listProductHTML.innerHTML = '';
    if(comboProduct.length > 0){
        listProductHTML.innerHTML = "";
        comboProduct.forEach(product =>{

            let itemsHTML = '';    
            Object.values(product.items).forEach(item => {
                itemsHTML += `<p>*${item}</p>`;
            })                      

            let photoHTML = '';    
            Object.values(product.item_src).forEach(photo => {
                photoHTML += `<img src="${photo}">`;
            })                
            
            listProductHTML.insertAdjacentHTML('beforeend', `
                        <div style="margin-bottom: 0.5rem;">
                            <div class="combo-div">             
                                    <div class="combo_image">
                                        ${photoHTML}
                                    </div>
                                    <div class="combo-caring">
                                        <form action="./files/php/cart_conn.php" id="cartForm" method="post">
                                            <input type="number" value="${product.id}" name="prod_id" hidden/>
                                            <input type="text" value="${window.location.href}" name="url" hidden/>
                                            <input type="text" name="popup" hidden/>
                                            <button type="submit" name="submit" class="addCart" onclick="addtoCart(${product.id}); popup();">Cart</button>
                                        </form>
                                    </div>
                            </div>
                            <div class="combo-set">
                                <div style="width: 70%;">
                                    ${itemsHTML}
                                </div>
                                <div>
                                    <p>price</p>
                                    <p><b>${product.price}</b></p>
                                </div>
                            </div>
                        </div>

            `)
        })
    }
}
//code for add itemsmenu
const daylist = () =>{
    fetch("files/data/morning.json")
    .then(response => response.json())
    .then(data => {
        dayProduct = data;
        eveningSection.style.backgroundColor = "brown";
        eveningSection.style.color = "white";
        comboSection.style.backgroundColor = "brown";
        comboSection.style.color = "white";
        morningSection.style.backgroundColor = "white";
        morningSection.style.color = "brown"
        addMYfood(dayProduct);
    })
}

const nightlist = () =>{
    fetch("files/data/evening.json")
    .then(response => response.json())
    .then(data => {
        nightProduct = data ;
        eveningSection.style.backgroundColor = "white";
        eveningSection.style.color = "brown";
        morningSection.style.backgroundColor = "brown";
        morningSection.style.color = "white";
        comboSection.style.backgroundColor = "brown";
        comboSection.style.color = "white";
        addMYfood(nightProduct);
    })
}
const combolist = ()=>{
    fetch("files/data/combo.json")
    .then(response => response.json())
    .then(data => {
        comboProduct = data;
        eveningSection.style.backgroundColor = "brown";
        eveningSection.style.color = "white";
        morningSection.style.backgroundColor = "brown";
        morningSection.style.color = "white";
        comboSection.style.backgroundColor = "white";
        comboSection.style.color = "brown";
        addMyCombo();
    })
}
//set timig for foods
(d.getHours()>5 && d.getHours()<15)?(daylist()):( nightlist());

//code for cart open
cartImage.addEventListener('click',()=>{
    if(open == false){
        mainCart.style.left = "20%" ;
        open = true ;
        document.querySelector(".go-to-cart-popup").style.display = "none";
    }
    else{
        mainCart.style.left = "100%" ;
        open = false ;
    }
})
cartAdd.addEventListener('click',()=>{
    if(open == false){
        mainCart.style.left = "20%" ;
        open = true ;
        document.querySelector(".go-to-cart-popup").style.display = "none"
    }
})
close.addEventListener('click',()=>{
    mainCart.style.left = "100%";
    open = false;
})


window.low = (a) =>{
    if(a>=1 && a<=100) {listProduct = dayProduct} else if(a>=101 && a<=200){listProduct = nightProduct}
    result =  listProduct.find(item => item.id === a);
    if(existORnot[a]){
        if(document.querySelector(".total-item"+a).innerText > 1){
            document.querySelector(".total-item"+a).innerText = parseInt(document.querySelector(".total-item"+a).innerText) - 1;
            countNo = countNo - 1;
            count.innerText = countNo;
            document.querySelector(".total-bill"+a).innerText = parseInt( document.querySelector(".total-bill"+a).innerText) - parseInt(result.price);
            document.querySelector(".total1").innerText = parseInt(document.querySelector(".total1").innerText) - parseInt(result.price) ;
             existORnot[a] -= 1;
        }
        else{
            delete existORnot[a]; 
            document.querySelector(".total1").innerText = parseInt(document.querySelector(".total1").innerText) - parseInt(result.price) ;
            let parentWithId = document.querySelector(".total-item"+a).closest('div[id]');
            if (parentWithId) {
                parentWithId.remove();
            }
            countNo = countNo - 1;
            count.innerText = countNo;
            let index = existORnot.indexOf(a); // find the index
           if (index > -1) {
           existORnot.splice(index, 1);
            }
            return;
        }
    }
}  
              




