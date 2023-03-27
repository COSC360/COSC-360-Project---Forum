window.addEventListener("DOMContentLoaded", function(e) {
    console.log('DOM fully loaded and parsed');

    var form = document.getElementById("make_post");

    var inputs = document.getElementsByClassName("required");

    form.addEventListener('submit', function(event) {
        console.log('submitted');

        valid = false;
    
        if (inputs[0].value != "" && inputs[1].value != "") {
            valid = true;
        }
            
        console.log("valid="+valid);

        if (valid == false) {
            event.preventDefault();
            alert("Missing fields");
        }
        else{
            form.submit();
        }
    });
});