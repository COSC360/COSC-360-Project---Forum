const fname = document.querySelector("input[name=fname]");
const lname = document.querySelector("input[name=lname]");
const uname = document.querySelector("input[name=uname]");
const email = document.querySelector("input[name=email]");
const password = document.querySelector("input[name=pword]");
const repassword = document.querySelector("input[name=repword]");
const createAcc = document.querySelector("#createAcc");

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
                if (res !=0) {
                    $("#profPic").attr("src",res);
                } else {
                    alert("Unable to process image");
                }
            }

        });
    });
});

createAcc.addEventListener("click",function(e) {
    let errFlags = [];
    if (fname.value == "" | lname.value == "" | uname.value == "" | email.value == "" | password.value == "" | repassword.value == "") {
        alert("Please ensure all fields are filled");
        e.preventDefault();
    } else if (password.value != repassword.value) {
        alert("Please ensure the passwords are the same");
        e.preventDefault();
    }

});
