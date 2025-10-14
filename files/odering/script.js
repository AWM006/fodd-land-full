
let dayProduct = [];
let nightProduct = [];
let comboProduct = [];
let items = {} ;
let listProduct =[];
let cart = document.querySelector("#items-lister");
let total_calc = parseInt(0);
let total_price = document.querySelector("#total-price");


let home = () => {
          document.querySelector('#home').href = "../../"+window.location.search;
          document.querySelector('#urlvalue').value = window.location.search;
    }
    home();

//getting info from url
const params = new URLSearchParams(window.location.search);
const total = parseInt(params.get('totalitem')); 


for(let i=0; i<total; i++){
    items[params.get('id'+i)] = parseInt(params.get('quan'+i));
}




//code for make item var object
let productlist = async()=>{
        const daylist = await fetch("../data/morning.json");
        dayProduct = await daylist.json();
        
        const nightlist = await fetch("../data/evening.json");
        nightProduct = await nightlist.json();

        const combolist = await fetch("../data/combo.json");
        comboProduct = await combolist.json();

    let bgColor = `#5a5156`;
    for (let no in items) {
        let id = parseInt(no);
        if (id >= 1 && id <= 100){listProduct = dayProduct;} else if (id >= 101 && id <= 200){listProduct = nightProduct;} else if (id >= 201 && id <= 300){listProduct = comboProduct;}
        let result = listProduct.find(item => item.id === id);
        let quantity = items[no]; // Use original string key
        
        cart.insertAdjacentHTML("beforeend", ` 

            <div class="col-2">
                <img src="../../${result.src}" alt="Product 1" class="img-fluid">
            </div>
            <div class="col-3">${result.name}</div>
                <div class="col-2">
                    <input type="number" class="form-control" value="${quantity}" min="1">
                </div>
                <div class="col-2">₹${result.price}</div>
                <div class="col-3">₹${result.price * quantity}</div>
            </div>

        `);

        total_calc += result.price * quantity;      
    }
    total_price.innerText = "₹"+total_calc;
}
productlist();