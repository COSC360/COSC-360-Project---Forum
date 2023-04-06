window.addEventListener("DOMContentLoaded", function(e) {
    $("#log_out").click(logout);

    var log_out = $("#log_out");
    log_out.addClass("selected");
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

    $(".post_unlike")
        .on("click",post_unlike);
    $(".post_like")
        .on("click",post_like);

    $(".admin_button")
        .on("click",deleteComment);
});

//Heart image

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


//Database asynchronous updates for comment likes
function unlike(){
    $(this).attr("class","like");
    $(this).on("click",like);
    $(this).off("click",unlike);

    var likeNum = $(this).next().html();

    $.ajax({
        url: 'unlike_comment.php',
        type: 'post',
        data: {"commentID": $(this).attr("value"), "number": likeNum },
        success: function(response) {console.log(response);}
    });
}

function like(){
    $(this).attr("class","unlike");
    $(this).on("click",unlike);
    $(this).off("click",like);

    var likeNum = $(this).next().html();

    $.ajax({
        url: 'like_comment.php',
        type: 'post',
        data: {"commentID": $(this).attr("value"), "number": likeNum},
        success: function(response) {console.log(response);}
    });
}

//Database asynchronous updates for post likes

function post_unlike(){
    $(this).attr("class","post_like");
    $(this).on("click",post_like);
    $(this).off("click",post_unlike);

    var likeNum = $(this).next().html();

    $.ajax({
        url: 'unlike.php',
        type: 'post',
        data: {"id": $(this).attr("value"), "number": likeNum },
        success: function(response) {console.log(response);}
    });
}

function post_like(){
    $(this).attr("class","post_unlike");
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

function logout(){
    $.ajax({
        url: 'logout.php',
        type: 'post',
        success: function(response) {console.log("logged out");}
    });
}

function deleteComment(){
    if(confirm("Do you want to delete this comment?")){
        console.log("yes");

        $.ajax({
            url: 'delete_comment.php',
            type: 'post',
            data: {"id": $(this).attr("value")},
            success: function(response) {console.log(response);}
        });

        location.reload();
    }else{
        console.log("no");
    }
}