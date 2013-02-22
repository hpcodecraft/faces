var Tag = {
  show: function() {
    $('#show-new-tag').hide();
    $('.new-tag-form').show();
    $('#newtag').focus();
  },
  cancel: function() {
    $('#show-new-tag').show();
    $('.new-tag-form').hide();
    $('#newtag').val('').blur();
    document.activeElement.blur();
  },
  save: function() {
    var tag = $('#newtag').val();
    var data = {
      cmd: 'Face.addTag',
      args: {
        id: faceId,
        tag: tag
      }
    };
    $.post(app.baseurl+'/ajax', data, function( json ) {
      $(window).scrollTo(0);
      $('header #message').html( json.msg ).fadeIn('medium',function(){
        setTimeout(function(){
          $('header #message').fadeOut('medium');
        }, 5000);
      });
      Tag.cancel();
    }, 'json' );
  }
};