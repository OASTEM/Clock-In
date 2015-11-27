$(document).ready(function() {
    $(".box").keydown(function (e) {
        var boxes = ["1","a","b","c","d","e"];
        var i = boxes.indexOf(e.target.getAttribute("id"));
        
        // Allow: delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                 return;
        }
        if(e.keyCode >= 48 && e.keyCode <= 57 || e.keyCode >= 96 && e.keyCode <= 105 || e.keycode == 39){
            $("#" + boxes[++i]).focus();
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});