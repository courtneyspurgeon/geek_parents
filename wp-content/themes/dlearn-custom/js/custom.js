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

  // It's action time!
  $('.post-action').click(function(event) {
      event.preventDefault()
      $strPID = $(this).parent().data('pid')

      // Wait for it...
      $('#'+$strPID+'-post-actions .spinner').show()
      $('#post-'+$strPID).addClass('hidden')
      $('#post-'+$strPID+'-wrapper .post-action').hide()

      // Add share buttons on demand
      if ($(this).data('type') == 'share')
      {
          // Go ahead and grab share stuff
          $.ajax({
              type: "POST",
              url: ajaxurl,
              data: { 
                  action: 'get_social_card',
                  post_id: $strPID
              }
          }).done(function(data) {
              $('#post-'+$strPID+'-wrapper .post-favorite-wrapper').removeClass('hidden')
              $('#post-'+$strPID+'-dynamic-content').addClass('share')
              $('#post-'+$strPID+'-dynamic-content').html(data)
              $('#'+$strPID+'-post-actions .spinner').hide()
          });
      }
      else if ($(this).data('type') == 'related')
      {
          $('#post-'+$strPID+'-dynamic-content').html('')
          $('#post-'+$strPID+'-wrapper .related-posts').removeClass('hidden')
          $('#post-'+$strPID+'-dynamic-content').addClass('related')
          $('#'+$strPID+'-post-actions .spinner').hide()
      }
      else if ($(this).data('type') == 'conversation')
      {
          $('#post-'+$strPID+'-dynamic-content').addClass('conversation')
          $('#post-'+$strPID+'-dynamic-content').html('Start a Conversation')
          $('#'+$strPID+'-post-actions .spinner').hide()
      }
      $('#'+$strPID+'-post-actions .social-back').removeClass('hidden')
  });

  // Ghetto sharing
  $('.social-back').click(function(event) {
      event.preventDefault()

      $('#post-'+$strPID+'-wrapper .post-action').show()
      $strPID = $(this).parent().data('pid')
      strType = $('#post-'+$strPID+'-dynamic-content').attr("class")

      if (strType == 'related')
          $('#post-'+$strPID+'-wrapper .related-posts').addClass('hidden')
      if (strType == 'share')
          $('#post-'+$strPID+'-wrapper .post-favorite-wrapper').addClass('hidden')

      // Reset to Original State
      $('#'+$strPID+'-post-actions .social-back').addClass('hidden')
      $('#post-'+$strPID+'-dynamic-content').attr("class",'')
      $('#post-'+$strPID+'-dynamic-content').html('')
      $('#post-'+$strPID).removeClass('hidden')

  });


  $.fn.toggleBody = function(toggleClass) {
     if ($('body').hasClass(toggleClass))
         $('body').removeClass(toggleClass) 
     else
         $('body').addClass(toggleClass) 
  }

  $.fn.toggleClass = function(element, toggleClass) {
     if ($(element).hasClass(toggleClass))
         $(element).removeClass(toggleClass) 
     else
         $(element).addClass(toggleClass) 
  }

  $.fn.toggleFavorite = function(element, toggleClass) {
     if ($(element+'.post-content').hasClass(toggleClass))
         $(element+'.post-content').removeClass(toggleClass) 
     else
         $(element+'.post-content').addClass(toggleClass) 
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

  $('.post-favorite a').click(function(event) {
      event.preventDefault();

      var strPostId = $(this).data('id')
      $(this).addClass('processing hidden')
      $('#'+strPostId+' .spinner').show()

      $.ajax({
          type: "GET",
          url: $(this).attr('href'),
      }).done(function() {
          $('#'+strPostId+' .spinner').hide()
          $.fn.toggleFavorite('#'+strPostId,'favorite');
          $('#'+strPostId+' .post-favorite .spinner').hide()
          $('#'+strPostId+' .post-favorite a').each(function() {
              if ($(this).hasClass('processing'))
                $(this).removeClass('processing')
              else
                $(this).removeClass('hidden')
          });
      });
  });
});
