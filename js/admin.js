"use strict"

const adminCheckApplicationBtns = document.querySelectorAll("main#admin section.content form.ordersCheckedForm button");
if(adminCheckApplicationBtns){
    adminCheckApplicationBtns.forEach(item=>{
        item.addEventListener("click",function(event){
            if (window.confirm("Do you really want to do this?")) {
                this.parentElement.querySelector("input[name='isCheck']").setAttribute("value","true")
            } else {
                this.parentElement.querySelector("input[name='isCheck']").setAttribute("value","false")
            }
        })
    })
}

const adminDeleteBtns = document.querySelectorAll("main#admin section.content form.goodsDeleteForm button");
if(adminDeleteBtns){
    adminDeleteBtns.forEach(item=>{
        item.addEventListener("click",function(event){
            if (window.confirm("Do you really want to do this?")) {
                this.parentElement.querySelector("input[name='isDelete']").setAttribute("value","true")
            } else {
                this.parentElement.querySelector("input[name='isDelete']").setAttribute("value","false")
            }
        })
    })
}


const paginationBtns = document.querySelectorAll("main#admin section.content .paginationBtns button");
if(paginationBtns){
    paginationBtns.forEach(item=>{
        item.addEventListener("click",function(){
            if (!item.classList.contains("noactive")) {
                window.location.href = item.getAttribute("link")
            }
        })
    })
}


const categorySelect = document.querySelector("section.admin .container section.content select.cat")
const sizesBlock = document.querySelector("section.admin .container section.content .sizes")
if(categorySelect){
    categorySelect.addEventListener('change', (event) => {
        if(event.target.value==1||event.target.value==2){
            sizesBlock.classList.add("active")
        } else {
            sizesBlock.classList.remove("active")
        }
    });
}

const changePhotoBtn = document.querySelector("section.admin .container section.content .applicationAbout .applicationAbout__row.photo .change a")
const changePhotoInput = document.querySelector("section.admin .container section.content .applicationAbout .applicationAbout__row.photo .change input")
if(changePhotoBtn){
    changePhotoBtn.addEventListener('click', () => {
        changePhotoBtn.classList.toggle("active")
        changePhotoInput.classList.toggle("active")
        changePhotoInput.parentElement.parentElement.classList.toggle("change")
        if(changePhotoBtn.classList.contains("active")){
            changePhotoBtn.textContent = "Close"
        } else {
            changePhotoInput.value = null;
            changePhotoBtn.textContent = "Change"
        }
    });
}

if(document.querySelector("section.admin .container section.content")){
    const adminPasswordRecoveryShowBtn = document.querySelector("main#admin section.content form#personalSettings a.passwordRecoveryOpen");
    const adminPasswordRecoveryBlock = document.querySelector("main#admin section.content .content__block__child.passwordRecovery .passwordRecovery");
    const adminPasswordRecoveryHead = document.querySelector("main#admin section.content .content__block__child.passwordRecovery .head");
    const adminPasswordRecoveryInputs = document.querySelectorAll("main#admin section.content .content__block__child.passwordRecovery .passwordRecovery input");
    const adminPersonalSettingsBtn = document.querySelector("main#admin section.content form#personalSettings button");
    adminPasswordRecoveryShowBtn.addEventListener("click",function(){
        if(adminPasswordRecoveryBlock.classList.contains("active")){
            adminPasswordRecoveryBlock.style.bottom = "0";
            adminPasswordRecoveryHead.classList.remove("active")
            adminPersonalSettingsBtn.style.marginTop = "24px"
            adminPasswordRecoveryBlock.classList.remove("active")
            adminPasswordRecoveryBlock.style.top = "unset";
            adminPasswordRecoveryInputs.forEach(item=>{
                item.removeAttribute("required")
            })
        } else {
            adminPasswordRecoveryHead.classList.add("active")
            adminPasswordRecoveryBlock.classList.add("active")
            adminPersonalSettingsBtn.style.marginTop = adminPasswordRecoveryBlock.offsetHeight+24+"px"
            adminPasswordRecoveryBlock.style.top = document.querySelector("main#admin section.content .content__block__child.passwordRecovery").offsetHeight+"px";
            adminPasswordRecoveryBlock.style.bottom = "unset";
            adminPasswordRecoveryInputs.forEach(item=>{
                item.setAttribute("required","required")
            })
        }
    })

    document.addEventListener("DOMContentLoaded",function(){
        if(adminPasswordRecoveryBlock.classList.contains("active")){
            adminPasswordRecoveryHead.classList.add("active")
            adminPasswordRecoveryBlock.classList.add("active")
            adminPersonalSettingsBtn.style.marginTop = adminPasswordRecoveryBlock.offsetHeight+24+"px"
            adminPasswordRecoveryBlock.style.top = document.querySelector("main#admin section.content .content__block__child.passwordRecovery").offsetHeight+"px";
            adminPasswordRecoveryBlock.style.bottom = "unset";
        }
    })


    const adminPasswordRecoveryPasswordBtns = document.querySelectorAll("main#admin section.content .content__block__child.passwordRecovery .passwordRecovery .inputBlock .input .passwordImg");
    adminPasswordRecoveryPasswordBtns.forEach(item=>{
        item.addEventListener("click",function(event){
            if(event.target.tagName=="I"){
                item.classList.remove("active")
                item.parentElement.querySelector("img").classList.add("active")
                item.parentElement.querySelector("input").setAttribute("type","password")
            } else if(event.target.tagName=="IMG"){
                item.classList.remove("active")
                item.parentElement.querySelector("i").classList.add("active")
                item.parentElement.querySelector("input").setAttribute("type","text")
            }
        })
    })
}