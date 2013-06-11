jQuery(document).ready(function( $ ) {

  // When log book is visible: toggle body class "logbook-show"
  $("#logbook-heading a").click(function() {
      current = $('div#user-logbook').attr('class')
      newclass = current == 'logbook-hide' ? 'logbook-show' : 'logbook-hide';
      $('div#user-logbook').attr('class',newclass);
      $.fn.toggleBody('logbook-body-show');
  });
  
  // For sign in form
  $('.editfield:first').hide();

  $.fn.toggleBody = function(toggleClass) {
     if ($('body').hasClass(toggleClass))
         $('body').removeClass(toggleClass) 
     else
         $('body').addClass(toggleClass) 
  }

  $.fn.toggleFavorite = function(toggleClass) {
     if ($('.post-content').hasClass(toggleClass))
         $('.post-content').removeClass(toggleClass) 
     else
         $('.post-content').addClass(toggleClass) 
  }

  // When search bar receives focus, toggle body class "search-show"
  $('#search-terms').click(function() {
      $.fn.toggleBody('search-show');
  }); 
  $('#search-terms').focusout(function() {
      $.fn.toggleBody('search-show');
  }); 

  
  $('#signup_submit').click(function() {
      strFirst = $('#field_6').val();
      strLast = $('#field_7').val();
      $('#field_1').val(strFirst + ' ' +  strLast);
  });

  $('#post-favorite a').click(function(event) {
      event.preventDefault();
      $('#logbook-spinner').show()
      $(this).addClass('processing hide')
      $.ajax({
          type: "GET",
          url: $(this).attr('href'),
      }).done(function() {
          $('#logbook-spinner').hide()
          $.fn.toggleFavorite('favorite');
          $('#post-favorite a').each(function() {
              if ($(this).hasClass('processing'))
                $(this).removeClass('processing')
              else
                $(this).removeClass('hide')
          });
      });
  });
});
