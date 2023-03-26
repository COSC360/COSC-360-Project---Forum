function isBlank(inputField)
{
    if (inputField.value=="")
    {
	     return true;
    }
    return false;
}

function makeRed(inputDiv){
	inputDiv.style.borderColor="#AA0000";
}

function makeClean(inputDiv){
	inputDiv.style.borderColor="#FFFFFF";
}

document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementById("form");
    var requiredInputs = document.querySelectorAll(".required");
    
    form.onsubmit = function(e)
    {
        var requiredInputs = document.querySelectorAll(".required");
        var err = false;

	     for (var i=0; i < requiredInputs.length; i++)
       {
	        if( isBlank(requiredInputs[i]))
          {
		          err |= true;
		          makeRed(requiredInputs[i]);
	        }
	        else
          {
		          makeClean(requiredInputs[i]);
	        }
	    }
      if (err == true)
      {
        e.preventDefault();
        document.getElementById("username").addEventListener("focus", function () {
          makeClean(this);
        });
        document.getElementById("password").addEventListener("focus", function () {
          makeClean(this);
        });
      }
      else
      {
        console.log('checking match');
        checkPasswordMatch(e);
      }
    }
})
