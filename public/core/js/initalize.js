document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);

    var elems1 = document.querySelectorAll('.modal');
    var instances = M.Modal.init(elems1);

  });


  $(document).ready(function () {
      if($('#page-title')){
        $('.brand-logo').text($('#page-title').val());
      }

      //Scam Code for Chosen
      setTimeout(function(){
        $('.select-wrapper').hide();
        $('.chosen-search-input').css("width", "95%");
      }, 1);

  });