"use strict"
window.addEventListener('DOMContentLoaded', () => {
    let formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    })
    const userActionsBtn = document.querySelector("header .container nav .user button")
    if(userActionsBtn){
        userActionsBtn.addEventListener("click",userActionsAnimation)
        window.addEventListener("resize",()=>{userActionsAnimation("remove")})
        window.addEventListener("scroll",()=>{userActionsAnimation("remove")})
        window.addEventListener("click",(e)=>{
            if(!e.path.includes(document.querySelector("header .container nav .user"))){
                userActionsAnimation("remove")
            }
        })
        function userActionsAnimation(act){
            if(act == "remove"){
                userActionsBtn.parentElement.querySelector("ul").classList.remove("active")
            } else {
                userActionsBtn.parentElement.querySelector("ul").classList.toggle("active")
            }
        }
    }

    const searchBtn = document.querySelector("header .container nav .search button.mainBtn")
    if(searchBtn){
        searchBtn.addEventListener("click",searchAnimation)
        window.addEventListener("resize",()=>{searchAnimation("remove")})
        window.addEventListener("scroll",()=>{searchAnimation("remove")})
        window.addEventListener("click",(e)=>{
            if(!e.path.includes(document.querySelector("header .container nav .search"))){
                searchAnimation("remove")
            }
        })
        function searchAnimation(act){
            if(act == "remove"){
                searchBtn.parentElement.classList.remove("active")
            } else {
                searchBtn.parentElement.classList.toggle("active")
            }
        }
    }

    const shoppingCartBtn = document.querySelector("header .container nav .shoppingCart")
    if(shoppingCartBtn){
        if(JSON.parse(localStorage.getItem("cart"))!=null){
            shoppingCartBtn.classList.add("active")
        }
    }

    const removeShoppingCartBtns = document.querySelectorAll("section.cart .container table tbody tr td.remove img")
    if(removeShoppingCartBtns){
        removeShoppingCartBtns.forEach(item=>{
            item.addEventListener("click",function(){
                let isRight = confirm("Do you really want to remove the item from the cart?");
                if(isRight){
                    let id = item.parentElement.parentElement.querySelector("td.item .info .num").textContent.split(":")[1].trim();
                    let newCart = [];
                    let cart = JSON.parse(localStorage.getItem("cart"));
                    for (let i = 0; i < cart.length; i++) {
                        if(cart[i].id!=id){
                            newCart.push(cart[i]);
                        }
                    } 
                    if(newCart.length>0){
                        localStorage.setItem("cart",JSON.stringify(newCart))
                    } else {
                        localStorage.removeItem("cart")
                    }
                    window.location.href = "index.php?redirect=cart" 
                }
            })
        })
    }

    const totalShoppingCart = document.querySelector("section.cart .container table tfoot");
    if(totalShoppingCart){
        if(JSON.parse(localStorage.getItem("cart"))!=null){
            totalShoppingCart.querySelector("tr td span.num").textContent = JSON.parse(localStorage.getItem("cart")).length
        } else {
            totalShoppingCart.querySelector("tr td span.num").textContent = totalShoppingCart.parentElement.querySelectorAll("tbody tr").length
        }
        let totalPrices = document.querySelectorAll("section.cart .container table tbody tr td.total")
        let totalPrice = 0;
        totalPrices.forEach(item=>{
            totalPrice += +item.textContent.split("$")[1].split(",").join("");
        })
        let nPrice = formatter.format(totalPrice);
        totalShoppingCart.querySelector("tr td.total").textContent = nPrice


        let dataLabels = ["Item","Price","Quantity","Total","Remove"]
        let products = totalShoppingCart.parentElement.querySelectorAll("tbody tr");
        for (let i = 0; i < products.length; i++) {
            let tds = products[i].querySelectorAll("td")
            for (let ind = 0; ind < tds.length; ind++) {
                tds[ind].setAttribute("data-label",dataLabels[ind])
            }
        }
    }

    const orderShoppingCart = document.querySelector("section.order .container .order__block .shoppingCart .products")
    if(orderShoppingCart){
        if(orderShoppingCart.offsetHeight>document.querySelector("section.order .container .order__block .contacts form").offsetHeight){
            orderShoppingCart.classList.add("scroll")
            document.querySelector("section.order .container .order__block .shoppingCart .totalPrice").classList.add("active")
        }
        if(localStorage.getItem("cart")){
            let totalPrices = JSON.parse(localStorage.getItem("cart"))
            let totalPrice = 0;
            totalPrices.forEach(item=>{
                totalPrice += +item.total.split("$")[1].split(",").join("");
            })
            let nPrice = formatter.format(totalPrice);
            document.querySelector("section.order .container .order__block .shoppingCart .totalPrice span.num").textContent = nPrice 
        }
        let maxHeight = document.querySelector("section.order .container .order__block .contacts form").offsetHeight - 70;
        orderShoppingCart.style.maxHeight = maxHeight+"px";
        orderShoppingCart.style.height = maxHeight+"px";
    }

    const productsPhotos = document.querySelectorAll("section.shop .container .shopBlock .products .product .product__photo")
    if(productsPhotos){
        productsPhotos.forEach(item=>{
            item.style.backgroundImage = `url(${item.querySelector("img").getAttribute("src")})`
        })
    }

    const productPhoto = document.querySelector("section.product .container .photo")
    if(productPhoto){
        productPhoto.addEventListener("click", () => {
            productPhoto.classList.toggle("active")
        });  
    }

    const sizesButtonsOfShopItem = document.querySelectorAll("section.product .container .info .info_row .size button")
    const amountOfShopItem = document.querySelector("section.product .container .info .info_row .amount")
    const addToCartButton = document.querySelector("section.product .container .info form button")
    const cartButton = document.querySelector("section.product .container .info a.cart")
    if(addToCartButton){
        if(localStorage.getItem("cart")){
            let cart = JSON.parse(localStorage.getItem("cart"))
            for (let i = 0; i < cart.length; i++) {
                if(cart[i].id==addToCartButton.parentElement.querySelector("input[name='ID']").getAttribute("value")){
                    addToCartButton.parentElement.classList.add("noactive")
                    amountOfShopItem.classList.add("noactive")
                    amountOfShopItem.querySelector("span.num").textContent = cart[i].amount;
                    cartButton.classList.add("active")
                    document.querySelector("section.product .container .info .price").textContent = cart[i].total
                    if(sizesButtonsOfShopItem[0]!=undefined){
                        sizesButtonsOfShopItem[0].parentElement.classList.add("noactive")
                    }
                    if(cart[i].size!=undefined){
                        for (let n = 0; n < sizesButtonsOfShopItem.length; n++) {
                            sizesButtonsOfShopItem[n].classList.remove("active")
                            if(sizesButtonsOfShopItem[n].textContent==cart[i].size){
                                sizesButtonsOfShopItem[n].classList.add("active")
                            }
                        }
                    }
                }
            }
        }
    }

    if(sizesButtonsOfShopItem){
        sizesButtonsOfShopItem.forEach(item=>{
            if(!item.parentElement.classList.contains("noactive")){
                item.addEventListener("click",function(){
                    sizesButtonsOfShopItem.forEach(i=>{
                        i.classList.remove("active")
                    })
                    item.classList.add("active")
                    shopItemForm.querySelector('input[name="size"]').setAttribute("value",item.textContent)
                })
            }
        })
    }

    const shopItemForm = document.querySelector("section.product .container .info form")
    if(amountOfShopItem&&!amountOfShopItem.classList.contains("noactive")){
        let amount = +amountOfShopItem.querySelector("span.num").textContent;
        let price = +document.querySelector("section.product .container .info .price").textContent.split("$")[1].split(",").join("");
        amountOfShopItem.querySelector("span.m").addEventListener("click",()=>{changeAmountOfShopItem("-")})
        amountOfShopItem.querySelector("span.b").addEventListener("click",()=>{changeAmountOfShopItem("+")})
        function changeAmountOfShopItem(act) {
            if(act=="-"){
                if(amount>1){
                    amount--;
                }
            } else if(act=="+"){
                if(amount<100){
                    amount++;
                }
            }
            let nPrice = formatter.format(amount*price);
            amountOfShopItem.querySelector("span.num").textContent = amount;
            document.querySelector("section.product .container .info .price").textContent = nPrice;

            shopItemForm.querySelector('input[name="amount"]').setAttribute("value",amount)
            shopItemForm.querySelector('input[name="total"]').setAttribute("value",nPrice)
        }
    }

    function formSignInSubmit(event){
        if(new Date(localStorage.getItem('signInEndTime'))>new Date()){
            event.preventDefault();
            document.querySelector("#wait").classList.add("active")
            document.querySelector("#invalid").classList.remove("active")
        } else {
            localStorage.removeItem('signInError')
            localStorage.removeItem('signInEndTime')
        }
    }

    const toggleBtn = document.querySelector("header .container nav .toggle")
    if(toggleBtn){
        toggleBtn.addEventListener("click",toggleFunction)
        window.addEventListener("resize",()=>{toggleFunction("remove")})
        window.addEventListener("scroll",()=>{toggleFunction("remove")})
        window.addEventListener("click",(e)=>{
            if(!e.path.includes(toggleBtn)){
                toggleFunction("remove")
            }
        })
        function toggleFunction(act){
            if(act=="remove"){
                toggleBtn.classList.remove("active")
                document.querySelector("header .container nav ul.menu").classList.remove("active")
            } else {
                toggleBtn.classList.toggle("active")
                document.querySelector("header .container nav ul.menu").classList.toggle("active")
            }
        }
    }   

    function noDigits(event) {
        if ("1234567890!@#$%^&*()_+-?/".indexOf(event.key) != -1) event.preventDefault();
    }
});
  