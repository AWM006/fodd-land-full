console.log("open.js");

//variable section
const parameter = new URLSearchParams(window.location.search);
let  isCartopen = parameter.get('cart');
let isPopup = parameter.get('popup');


//function section
let popup = () =>
{   if(open == false){
        //for pop up window
        document.querySelector(".go-to-cart-popup").style.display = "block"
        setTimeout(() => {
        document.querySelector(".go-to-cart-popup").style.display = "none";
        }, 5000);
    }
}



//main code section
if(isCartopen === "open"){
    document.querySelector(".cart-div").style.left = "20%" ;
}
else if(isPopup === 'open'){
    popup();
}
window.confirmOrder = () =>{
    const Newparameter = new URLSearchParams(window.location.search);
    
    if(parseInt(Newparameter.get('totalitem')) !== 0){
        window.location.href = `${location.protocol}//${location.host}${location.pathname}`+"files/odering/"+window.location.search;
    }
}