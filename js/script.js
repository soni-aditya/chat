/*
in script.js we will post messages by ajax

On line 12 we will wait for the #reply button to be click and when the button is clicked we will get message,conversation_id,user_from,user_to and send then to post_message_ajax.php


On line 31 we are getting the conversation_id and then we are loading get_message_ajax.php into .display-message on a interval of every 2 second
 */

$(document).ready(function(){
    /*post message via ajax*/
    $("#reply").on("click", function(){
        var message = $.trim($("#message").val()),
            conversation_id = $.trim($("#conversation_id").val()),
            user_form = $.trim($("#user_form").val()),
            user_to = $.trim($("#user_to").val()),
            error = $("#error");

        if((message != "") && (conversation_id != "") && (user_form != "") && (user_to != "")){
            error.text("Sending...");
            ///post ajax call
            $.post("post_message_ajax.php",{message:message,conversation_id:conversation_id,user_form:user_form,user_to:user_to}, function(data){
                error.text(data);
                //clear the message box
                $("#message").val("");
            });
        }
    });


    //get message
    c_id = $("#conversation_id").val();
    //get new message every 2 second
    setInterval(function(){
        //get ajax call
        $(".display-message").load("get_message_ajax.php?c_id="+c_id);
    }, 2000);
    ///scroll back to the very top of the conversation
    $(".display-message").scrollTop($(".display-message")[0].scrollHeight);
});