const sidebar = document.querySelector("#navIcon");
const editButton = document.querySelector("#editProfile");
sidebar.addEventListener("click", function () {
   document.body.classList.toggle("active");
});
editButton.addEventListener("click",function(){
    let inputs = document.querySelectorAll("input[type=text]");
    for (let index = 0; index < inputs.length; index++) {
        inputs[index].removeAttribute("readonly");
        inputs[index].style.backgroundColor = "white";
    }
});