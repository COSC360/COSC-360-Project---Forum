const sidebar = document.querySelector("#navIcon");
const editButton = document.querySelector("#editProfile");
const saveButton = document.querySelector("#saveProfile");
sidebar.addEventListener("click", function () {
   document.body.classList.toggle("active");
});
editButton.addEventListener("click",function(){
    let inputs = document.querySelectorAll("input[type=text]");
    for (let index = 0; index < inputs.length; index++) {
        inputs[index].removeAttribute("readonly");
        inputs[index].style.backgroundColor = "white";
    }
    saveButton.style.display ="inline";
});

saveButton.addEventListener("click", function () {
    let inputs = document.querySelectorAll("input[type=text]");
    for (let index = 0; index < inputs.length; index++) {
        inputs[index].setAttribute("readonly","readonly");
        inputs[index].style.backgroundColor = "#D9D9D9";
    }
    saveButton.style.display = "none";
});