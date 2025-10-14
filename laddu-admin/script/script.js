let itemadd = document.querySelector("#carting-div");
let totalprice = 0;

let cartProduct = async()=>{
        let day_listing = await fetch("../files/data/morning.json");
        day_list = await day_listing.json();
        
        let night_Listing = await fetch("../files/data/evening.json");
        night_List = await night_Listing.json();

        let combo_listing = await fetch("../files/data/combo.json");
        combo_list = await combo_listing.json();



        orders.forEach(order => {

            //string converter
            let queryString = order.url;
            let cleanString = queryString.startsWith('?') ? queryString.slice(1) : queryString;
            let params = new URLSearchParams(cleanString);
            let total = parseInt(params.get('totalitem')) || 0;
            let result = {};
            for (let i = 0; i < total; i++) {
                let id = params.get('id' + i);
                let quan = params.get('quan' + i);
                if (id !== null && quan !== null) {
                    result[id] = parseInt(quan); 
                }
            }

            //makeing textboxdata
            let list = ``;
            for (let [id, quantity] of Object.entries(result)) {
                if (id >= 1 && id <= 100){itemData = day_list;} else if (id >= 101 && id <= 200){itemData = night_List;} else if (id >= 201 && id <= 300){itemData = combo_list;}
                let product = itemData.find(prod => prod.id === Number(id));
                totalprice += parseInt(product.price*quantity);
                list += `${product.name} x ${quantity} = ${parseInt(product.price*quantity)}\n`;
            }

            //add item
            textboxData = list;
            itemadd.insertAdjacentHTML('afterbegin', `
              <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Order #${order.id}</h5>
                            <p class="mb-2"><strong>Name:</strong>${order.name}</p>
                            <p class="mb-2"><strong>Phone:</strong>${order.phone}</p>
                            <p class="mb-2"><strong>Address:</strong>${order.address}</p>
            
                            <label for="items1" class="form-label"><strong>Items</strong></label>
                            <textarea id="items1" class="form-control" rows="1" style="height:140px" readonly>${textboxData}</textarea>
                            <p class="mb-2"><strong>Total Price = ₹${totalprice}</strong></p>
                            <form action="./php/orderDone.php" method="POST" class="mt-3">
                                <input type="hidden" name="order_id" value="${order.id}">
                                <button type="submit" name="submit" class="btn btn-success">Delivered</button>
                            </form>
                        </div>
                </div>
            
            `)
            totalprice = 0; //reset for next div
        })
                
}
cartProduct();

setTimeout(function(){
    location.reload();
}, 15000);
