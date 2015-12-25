/**
var admin-box = "<div id=\"admin-login-box\">\
            <div class=\"row\">\
                <div class=\"col-12\"><h1>Please login to continue</h1></div>\
            </div>\
            <div class=\"row\">\
                <div class=\"col-6\" style=\"background: #7670b3; color:#fff\">\
                    <h2>Administrator</h2>\
                    <form id=\"admin-panel-login\" method=\"post\" action=\"auth.ajax.php?action=2\">\
                        <div class=\"row\">\
                            <img src=\"../img/emailwhite.svg\"><input type=\"text\" name=\"email\">\
                        </div>\
                        <div class=\"row\">\
                            <img src=\"../img/lockwhite.svg\"><input id=\"pin\" type=\"password\" maxlength=\"6\" name=\"pin\">\
                        </div>\
                        <input type=\"submit\" value=\"Login\">\
                    </form>\
                </div>\
            </div>\
        </div>";
        */

var admin = [[]];

function updateMeeting(id){
    
}

function diff(start){
    var startDate = new Date(start).getTime();
    var currDate = new Date().getTime();
    
    var diffTime = new Date(currDate - startDate);
    
    return ("0" + diffTime.getHours()).slice(-2) + ":" +("0" + diffTime.getMinutes()).slice(-2) + ":" + ("0" + diffTime.getSeconds()).slice(-2);
}

$(document).ready(function(){
    loadMeetings();
});

function updateElapsed(){
    $('.meeting-elapsed').each(function(){
        var elapsed = diff($(this).data('start'));
        $(this).text(elapsed);
    });
}

function loadMeetings(){
    $.ajax({
        url:"/meetings.ajax.php?action=get",
        success:function(response){
            $('#meeting-wrapper').html(response);
            initInput();
        },
        dataType:"html"
    });
}

function initInput(){
    $('.scannable').on("submit",function(e){
        e.preventDefault();
        var mid = $(this).parent().parent().data("mid");

        var elem = $(this);
        
        elem.ajaxSubmit({
            data:{
                mid:mid
            },
            success:function(response){
                if(response == "P200"){
                    location.reload();
                }else if(response == "isAdmin"){
                    var panel = confirm("Load admin panel?");
                    if(panel){
                        alert("Feature does not exist");
                    }else{
                        elem.ajaxSubmit({
                            data:{
                                mid:mid,
                                out:true
                            },
                            success:function(response){
                                if(response == "P200"){
                                    alert(response);
                                    location.reload();
                                }else{
                                    alert("You still broke it...\n" + response);
                                }
                            }
                        });
                    }
                }else if(response == "isLast"){
                    var panel = confirm("You are the last person. Add a host?");
                    if(panel){
                        alert("Feature does not exist");
                    }else{
                        elem.ajaxSubmit({
                            data:{
                                mid:mid,
                                out:true
                            },
                            success:function(response){
                                if(response == "P200"){
                                    alert(response);
                                    location.reload();
                                }else{
                                    alert("You still broke it...\n" + response);
                                }
                            }
                        });
                    }
                }else{
                    alert("You broke it!");
                }
            }
        });
    });
}

window.setInterval(function(){
    updateElapsed();
}, 1000);