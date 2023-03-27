window.addEventListener("DOMContentLoaded", function(e) {

});

$(document).ready(function(){
    $(".not_liked")
        .on("click",liked);
    $(".liked")
        .on("click",unliked);   

    $(".unlike")
        .on("click",unlike);
    $(".like")
        .on("click",like);
});

function liked(){
    $(this).attr("src","images/liked.png");
    $(this).attr("class","liked");
    $(this).on("click",unliked);
    $(this).off("click",liked);
    var number = $(this).parent().next().html();
    number++;
    $(this).parent().next().html(number);
}

function unliked(){
    $(this).attr("src","images/not_liked.png");
    $(this).attr("class","not_liked");
    $(this).on("click",liked); 
    $(this).off("click",unliked);
    var number = $(this).parent().next().html();
    number--;
    $(this).parent().next().html(number);
}

function unlike(){
    $(this).attr("class","like");
    $(this).on("click",like);
    $(this).off("click",unlike);

    var likeNum = $(this).next().html();

    $.ajax({
        url: 'unlike.php',
        type: 'post',
        data: {"id": $(this).attr("value"), "number": likeNum },
        success: function(response) {console.log(response);}
    });
}

function like(){
    $(this).attr("class","unlike");
    $(this).on("click",unlike);
    $(this).off("click",like);

    var likeNum = $(this).next().html();

    $.ajax({
        url: 'like.php',
        type: 'post',
        data: {"id": $(this).attr("value"), "number": likeNum},
        success: function(response) {console.log(response);}
    });
}
