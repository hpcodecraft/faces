// This file needs to be minified to /js/min/app-min.js
// If you're using Codekit you're lucky and everything is done automatically.
// If not, include the following files before:

// @codekit-prepend 'lib/jquery-1.9.0.js'
// @codekit-prepend 'lib/jquery.scrollTo.js'
// @codekit-prepend 'lib/jquery.lazyload.js'

// @codekit-prepend 'lib/hammer.js'
// @codekit-prepend 'lib/jquery.hammer.js'
// @codekit-prepend 'lib/jquery.specialevent.hammer.js'

// @codekit-prepend 'lib/Faces.js'
// @codekit-prepend 'lib/Tag.js'

$(function() {

  function handleSearch( e ) {
    Faces.search( $(e.target).val() );
    if( $(e.target).val() === '' ) $('#search-clear').hide();
    else $('#search-clear').show();
  }

  function handleSearchClear( e ) {
    Faces.search('');
    $('#search').val('').focus();
    $('#search-clear').hide();
  }

  function handleChangeCategory( e ) {
    $('#nav-main a.category').removeClass('active');
    $(e.target).addClass('active');
    Faces.changeCategory( $(e.target).attr( 'rel' ));
  }

  function handleChangeOrder( e ) {
    $('#nav-main a.order').removeClass('active');
    $(e.target).addClass('active');
    Faces.sort( $(e.target).attr( 'rel' ));
  }

  function handleWindowScrollHelper( e ) {
    var scrollDuration = 250;
    var direction = $(e.target).attr('data-direction');
    if( direction == 'up' ) {
      $(window).scrollTo( 0, {duration: scrollDuration});
    }
    else {
      $(window).scrollTo( 'max', {duration: scrollDuration});
    }
  }

  function handleWindowScroll( e ) {
      if( window.scrollY == (document.documentElement.scrollHeight - document.documentElement.clientHeight) ) {
        $('.scroller').attr('data-direction','up').html('▲');
      }
      else if( window.scrollY === 0 ) {
        $('.scroller').attr('data-direction','down').html('▼');
      }
  }

  function showFaceAnimation( f ) {
    var face = $(f).data('face');
    if( face.split('.').pop() == 'gif' ) {
      $(f).find('.face_orig').css('background-image','url('+face+')');
    }
  }

  function hideFaceAnimation( f ) {
    $(f).find('.face_orig').css('background-image','none');
  }

  // captain, we have a touch device here
  if ("ontouchstart" in document.documentElement) {

    // main view

    // search
    $('#search').change( handleSearch );
    $('#search-clear').hammer({ prevent_default:true }).bind( 'tap', handleSearchClear );

    // categories & order
    $('#nav-main a.category').hammer({ prevent_default:true }).bind( 'tap', handleChangeCategory );
    $('#nav-main a.order').hammer({ prevent_default:true }).bind( 'tap', handleChangeOrder );

    // scroll helper
    $('.scroller').hide();

    // faces
    $('#faces').hammer({ prevent_default:true }).on( 'tap', '.face', function(e){
      $(this).find('.permalink').css('display','none !important');
      var id  = $(this).data('id'),
          url = app.baseurl+'/'+id;
      document.location.href = url;
    });

    // single face view

    // add tag form
    $('#show-new-tag').hammer({ prevent_default:true }).bind( 'tap', Tag.show );
    $('#newtag-save').hammer({ prevent_default:true }).bind( 'tap', Tag.save );
    $('#newtag-cancel').hammer({ prevent_default:true }).bind( 'tap', Tag.cancel );

    $('.wrapper.single').hammer({ prevent_default:true }).bind( 'swipe', function(e) {
      switch( e.direction ) {
        case 'left':
          document.location.href = app.baseurl+'/'+next;
          break;
        case 'right':
          document.location.href = app.baseurl+'/'+prev;
          break;
        case 'up':
        case 'down':
          document.location.href = app.baseurl;
          break;
      }
    });

    $('.embed').hide();

  } // end of touch bindings

  // mouse events - how retro!
  else {

    // main view

    // search
    $('#search').keyup( handleSearch );
    $('#search-clear').click( handleSearchClear );

    // categories & order
    $('#nav-main a.category').click( handleChangeCategory );
    $('#nav-main a.order').click( handleChangeOrder );

    // scroll helper
    $('.scroller').click( handleWindowScrollHelper );
    $(window).scrollTo(0).scroll( handleWindowScroll );

    // faces
    $(document).on('mouseover','.face', function() {
      showFaceAnimation(this);
    });

    $(document).on('mouseout','.face', function() {
      hideFaceAnimation(this);
    });

    $(document).on('click','.face', function(e) {

      if( $(e.target).hasClass( 'permalink' )) return true;

      var id = $(this).data('id');

      $('#face-url').val( app.baseurl+'/'+id ).focus().select();
      $('.face').removeClass('clicked');
      $('.face[data-id="'+id+'"]').addClass('clicked');
      $(window).scrollTo(0);

      // animate copy hint

      // get the position value that will be animated (the negative one)
      var tipDOM = $('#alert'),
          tip = {
            top: parseInt( tipDOM.css('top'), 10 ),
            right: parseInt( tipDOM.css('right'), 10 ),
            bottom: parseInt( tipDOM.css('bottom'), 10 ),
            left: parseInt( tipDOM.css('left'), 10 )
          };

      var animationTarget = {
        css: 'bottom',
        val: 0
      };

      var aniCSS = 'bottom',
          aniVal = 0;

      for( x in tip ) {
        if( tip[x] <  0 ) {
          aniCSS = x;
          aniVal = tip[x];
          break;
        }
      }

      function createProp( obj, propName, propValue ) {
        obj[propName] = propValue;
        return obj;
      }

      var animateIn = {},
          animateOut = {};
      createProp( animateIn, aniCSS, 0 );
      createProp( animateOut, aniCSS, aniVal );

      // fire animation
      tipDOM.animate(animateIn, 150, function(){
        $("#alerttext").css("display","block");
        setTimeout( function() {
          $("#alerttext").fadeOut("medium");
          tipDOM.animate(animateOut, 150 );
        }, 1500 );
      });

      return false;
    });

    // single face view

    // add tag form
    $('#show-new-tag').click( Tag.show );
    $('#newtag-save').click( Tag.save );
    $('#newtag-cancel').click( Tag.cancel );

    // embed urls
    $('.embed input').mouseover( function() {
      var hint = '<span class="hint">'+app.copytext+'</span>';
      $(this)
        .select()
        .focus()
        .parent().append(hint);
    })
    .mouseout(function(){
      $(this).blur();
      $('.hint').remove();
    });
  } // end of mouse bindings


  // general stuff
  $('#alertlabel').html(app.copytext);
  // load faces
  Faces.restoreInitial();
});