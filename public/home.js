$(document).ready(function () {

    //Setting Menu items to active
    $('li').removeClass('active');
    $('#dashboard').addClass('active');
    $('#inception-nav-menu').css("display","none");
    $('#inception-nav-menu').addClass('nav-hide');
    
    //Approval Count
     var count = $('#count').val();
    
        if(count>0){
            $.gritter.add({
                title: 'Pending Approvals',
                text: 'You have <b>'+count+'</b> unapproved Requests.<br>Please go the <a href="/approvals">Approval sections</a>',
                sticky: true,
                time: '',
                class_name:'gritter-light'
            });
    
            $('#gritter-item-1').hover(function(){
                $('.gritter-close').css('left','261px');
            });
        }
    
    
    });