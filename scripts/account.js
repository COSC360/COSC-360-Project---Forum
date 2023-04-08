const sidebar = document.querySelector("#navIcon");
const editButton = document.querySelector("#editProfile");
const saveButton = document.querySelector("#saveProfile");
const cancelButton = document.querySelector("#cancelChanges");
const imageUpload = document.querySelector("#imgUpload");
const uploadLink = document.querySelector("#addPic");


$(document).ready(function() {
    $("#addPic").on('click', function(e) {
        e.preventDefault();
        $("#imgUpload").trigger('click');
    });

    $("#imgUpload").change(function() {
        var formD = new FormData();
        var imageFile = $("#imgUpload")[0].files[0];
        formD.append("imageFile",imageFile);

        $.ajax({
            url:  'profilePic.php',
            type: 'post',
            data: formD,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res != 0) {
                    $("#profPic").attr("src",res);
                } else {
                    alert("Unable to process image");
                }
            }

        });
    });
});
sidebar.addEventListener("click", function () {
   document.body.classList.toggle("active");
});
editButton.addEventListener("click",function(){
    let inputs = document.querySelectorAll("input[type=text]");
    $("figcaption").removeAttr("hidden");
    for (let index = 0; index < inputs.length; index++) {
        inputs[index].removeAttribute("readonly");
        inputs[index].style.backgroundColor = "white";
    }
    saveButton.style.display ="inline";
    cancelButton.style.display ="inline";
});

saveButton.addEventListener("click", function () {
    let inputs = document.querySelectorAll("input[type=text]");
    $("figcaption").attr("hidden","hidden");
    for (let index = 0; index < inputs.length; index++) {
        inputs[index].setAttribute("readonly","readonly");
        inputs[index].style.backgroundColor = "#D9D9D9";
    }
    saveButton.style.display = "none";
    cancelButton.style.display = "none";

});

cancelButton.addEventListener("click", function () {
    let inputs = document.querySelectorAll("input[type=text]");
    $("figcaption").attr("hidden","hidden");
    for (let index = 0; index < inputs.length; index++) {
        inputs[index].setAttribute("readonly","readonly");
        inputs[index].style.backgroundColor = "#D9D9D9";
    }
    saveButton.style.display = "none";
    cancelButton.style.display = "none";

});




