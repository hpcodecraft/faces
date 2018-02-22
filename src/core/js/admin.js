var Category = {

  add: function() {
    var name = $('#category-add').val();
    var data = {
      cmd: 'Category.add',
      args: {
        name: name
      }
    };
    $.post('../ajax', data, function( json ) {

      $('#message').html( json.msg ).fadeIn('medium',function(){
        setTimeout(function(){
          $('#message').fadeOut('medium');
        }, 10000);
      });

      $('#category-add').val('');

      if( json.success === true ) {
       $('#category-add').before('<li class="category" data-id="'+json.id+'" data-weight="'+json.weight+'">\
            <input type="text" class="category-name" value="'+json.name+'">\
            <button type="button" class="category-delete">✖</button>\
            <button type="button" class="category-up">⬆</button>\
            <button type="button" class="category-down">⬇</button>\
          </li>');
      }

    }, 'json' );
    return false;
  },
  setName: function( id, name ) {
    var data = {
      cmd: 'Category.setName',
      args: {
        id: id,
        name: name
      }
    };
    $.post('../ajax', data, function( json ) {
      $('#message').html( json.msg ).fadeIn('medium', function() {
        setTimeout(function(){
          $('#message').fadeOut('medium');
        }, 10000);
      });
    }, 'json' );
  },
  remove: function( id, name ) {
    var data = {
      cmd: 'Category.remove',
      args: {
        id: id,
        name: name
      }
    };
    $.post('../ajax', data, function( json ) {
      $('#message').html( json.msg ).fadeIn('medium', function() {
        setTimeout(function(){
          $('#message').fadeOut('medium');
        }, 10000);
      });

      if( json.success === true ) {
        $('.category[data-id='+json.id+']').remove();
      }
    }, 'json' );
  },
  up: function( id ) {
    var data = {
      cmd: 'Category.up',
      args: {
        id: id
      }
    };
    $.post('../ajax', data, function( json ) {
      $('#message').html( json.msg ).fadeIn('medium', function() {
        setTimeout(function(){
          $('#message').fadeOut('medium');
        }, 10000);
      });

      if( json.success === true ) {
        $('.category[data-id='+json.changed.id+']').data('weight', json.changed.weight );
        var copy = $('.category[data-id='+json.id+']').clone().data('weight', json.weight );
        $('.category[data-id='+json.id+']').remove();
        $('.category[data-id='+json.changed.id+']').before( copy );
      }
    }, 'json' );
  },
  down: function( id ) {
    var data = {
      cmd: 'Category.down',
      args: {
        id: id
      }
    };
    $.post('../ajax', data, function( json ) {
      $('#message').html( json.msg ).fadeIn('medium', function() {
        setTimeout(function(){
          $('#message').fadeOut('medium');
        }, 10000);
      });

      if( json.success === true ) {
        $('.category[data-id='+json.changed.id+']').data('weight', json.changed.weight );
        var copy = $('.category[data-id='+json.id+']').clone().data('weight', json.weight );
        $('.category[data-id='+json.id+']').remove();
        $('.category[data-id='+json.changed.id+']').after( copy );
      }
    }, 'json' );
  }
};

var Tag = {
  reject: function() {
      var tag = $(this).data('tag');
      var face = $(this).data('face');
      var data = {
        cmd: 'Face.deleteTag',
        args: {
          id: face,
          tag: tag
        }
      };
      $.post('../ajax', data, function( json ) {
        $('#message').html( json.msg ).fadeIn('medium',function(){
          setTimeout(function(){
            $('#message').fadeOut('medium');
          }, 10000);
        });
        $('.edittag_'+json.id+'[data-tag="'+json.tag+'"]').remove();
      }, 'json' );
      return false;
  },
  enable: function() {
      var tag = $(this).data('tag');
      var face = $(this).data('face');
      var data = {
        cmd: 'Face.enableTag',
        args: {
          id: face,
          tag: tag
        }
      };
      $.post('../ajax', data, function( json ) {
        $('#message').html( json.msg ).fadeIn('medium',function(){
          setTimeout(function(){
            $('#message').fadeOut('medium');
          }, 10000);
        });
        $('.edittag_'+json.id+'[data-tag="'+json.tag+'"]').remove();
        $('#tags_'+json.id).append('\
          <li class="edittag_'+json.id+'" data-tag="'+json.tag+'">\
            '+json.tag+'\
            <button data-face="'+json.id+'" data-tag="'+json.tag+'">✖</button>\
          </li>');
      }, 'json' );
      return false;
  }
};

// ready()
$(function() {
  $(document).on('click', 'button.edittag-save', Tag.enable);
  $(document).on('click', 'button.edittag-cancel', Tag.reject);

  // scroll up/down button
  var scrollDuration = 250;
  $('.scroller').click( function() {
    var direction = $(this).data('direction');
    if( direction == 'up' ) {
      $(window).scrollTo( 0, {duration: scrollDuration});
    }
    else {
      $(window).scrollTo( 'max', {duration: scrollDuration});
    }
  });

  $(window).scrollTo(0);
  $(window).scroll( function() {
    if( window.scrollY == (document.documentElement.scrollHeight - document.documentElement.clientHeight) ) {
      $('.scroller').data('direction','up').html('▲');
    }
    else if( window.scrollY === 0 ) {
      $('.scroller').data('direction','down').html('▼');
    }
  });

  // fade message after 10 seconds if visible
  var msg = $('#message');
  if( msg.text().length > 0 ) {
    msg.show();
    setTimeout(function(){
      msg.fadeOut('medium');
    }, 10000);
  }

  // setup category managment
  $('#setting-categories button.add').click( Category.add );
  $(document).on('keydown', '.category-name', function(e){
    if( e.keyCode == 13 ) {
      Category.setName( $(e.target).parent('.category').data('id'), $(e.target).val() );
      return false;
    }
  });
  $(document).on('click', '.category-delete', function(e) {
    var category = $(e.target).parent('.category');
    Category.remove( category.data('id'), category.find('.category-name').val() );
  });
  $(document).on('click', '.category-up',  function(e) {
    var category = $(e.target).parent('.category');
    Category.up( category.data('id') );
  });
  $(document).on('click', '.category-down', function(e) {
    var category = $(e.target).parent('.category');
    Category.down( category.data('id') );
  });
});