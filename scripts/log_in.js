window.addEventListener("DOMContentLoaded", function(e) {
    console.log('DOM fully loaded and parsed');

    var form = document.getElementById("login_form");

    form.addEventListener('submit', function(event) {
        console.log('submitted');
        valid = false;
        authorize = false;

        var username = document.getElementById("username").value;
        console.log('input username: '+username);

        var pass = document.getElementById("password").value;
        console.log('input username: '+pass);

        if(username != "" && pass !=""){
            valid = true;
        }

        if (valid === false) {
            event.preventDefault();
            alert("Empty fields. Try again.");
        }else{
            event.preventDefault();
            $.ajax({
                url: 'action_log_in.php',
                type: 'post',
                data: {"username": username, "password": pass },
                success: function(response) {
                    const data = JSON.parse(response);
                    if(pass === data['password']){
                        authorize=true;
                        console.log("authorize: "+authorize);
                    }
                    if(authorize === false){
                        alert("Wrong password.");
                    }else{
                        succesful(username);
                        form.submit();
                    }
                },
            });
        }

    });

});

function succesful(user){
    $.ajax({
        url: 'succesful_login.php',
        type: 'post',
        data: {"username": user},
        success: function(response) {console.log(response);}
    });
}