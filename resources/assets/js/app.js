require('./bootstrap');
require('./utils');

$('.vote-button-container.clickable').click(function(){
    let container = $(this);
    if (window.AIMED.userId) {
        window.axios({method: 'POST', url: container.data('action')})
            .then(function(response){
                container.find('.vote-button-count > span').html(response.data);
            });
    }else{
        window.swal({
            title: "Unauthorized",
            text: "You need to be logged in to up-vote.",
            showConfirmButton: true,
            showCancelButton: true,
            type: "error",
            confirmButtonText: "Login",
            cancelButtonText: "Cancel",
            allowOutsideClick: false
        }, function(isConfirm){
            if(isConfirm){
                window.location = '/login';
            }
        });
    }
});