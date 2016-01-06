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
    var start = new Date(start);
    var startDate = start.getTime()*1000;
    var currDate = Math.round(Date.now());
    
    var diffTime = new Date((currDate - startDate) + start.getTimezoneOffset() * 60000);
        
    return ("0" + diffTime.getHours()).slice(-2) + ":" +("0" + diffTime.getMinutes()).slice(-2) + ":" + ("0" + diffTime.getSeconds()).slice(-2);
}

$(document).ready(function(){
    loadMeetings();
});

function updateElapsed(){
    $('.meeting-elapsed').each(function(index){
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
        console.log("Triggered.");
        
        var mid = $(this).parent().parent().data("mid");
        var sid = $(this).find('#input').val();
        
        var form = $(this);
        
        $.ajax('members.ajax.php?action=isHost',{
            method:"POST",
            data:{
                stuid:sid
            },
            success:function(response){
                if(response == "true" && confirm('Load admin panel?')){
                    alert("Lol feature no implement.");
                }else{
                    $.ajax('members.ajax.php?action=isLastHost',{
                        method:"POST",
                        data:{
                            stuid:sid
                        },
                        success:function(response){
                            if(response == "true" && confirm("You are the last host. Transfer?")){
                                alert("Transfering is not something we can do at this time.");
                                 
                            }else{
                                $.ajax('meetings.ajax.php?action=end',{
                                    method:"POST",
                                    data:{
                                        mid:mid,
                                        end_by:sid
                                    },
                                    success:function(response){
                                        alert(response);
                                    }
                                });
                            }
                            form.ajaxSubmit();
                        }
                    });
                }
            }
        
        });
    });
    
    $('#meeting-new').on("submit",function(e){
        e.preventDefault();
        $(this).ajaxSubmit({
            success:function(response){
                alert(response);
            }
        });
    });
}

window.setInterval(function(){
    updateElapsed();
}, 1000);