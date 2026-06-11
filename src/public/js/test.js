'use strict';

$('#loginForm').on("submit", function(event) {
    event.preventDefault();
    var actionurl = event.currentTarget.action;

    $.ajax({
        url: actionurl,
        type: 'POST',
        dataType: 'application/json',
        data: $("#loginForm").serialize(),
        success: function(data) {
            alert("login success");
        },
        error: function(request, err) {
            alert("error: " + err);
        }
    });
});
