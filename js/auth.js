$(document).ready(function(){
   $('#user-control-login').on("submit",function(e){
         e.preventDefault();
        console.log("Submit on user triggered");
        $(this).ajaxSubmit({
            success:function(response){
                alert(response);
            }
        });
   });
    
    $('#admin-panel-login').on("submit",function(e){
        e.preventDefault();
        console.log("Submit on admin triggered");
        $(this).ajaxSubmit({
            success:function(response){
                if(response == "P200") location.reload(); //logged in successfully
                if(response == "P403") alert("At least use the right PIN number. I mean seriously, are you even trying?"); //incorect user/pass
                else alert("You broke it!");
            }
        });
   });
});