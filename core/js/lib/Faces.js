  var Faces = {

    options: {
      order: 'id',
      category: 0
    },

    sort: function( by ) {

      Faces.options.order = by;
      Faces._saveCookie();

      var html = '';

      if( Face.length == 0 ) {
        html = '<h2>You haven\'t added any faces yet.</h2>\
          <h4>Upload some images to the import folder and go to the \
          <a href="'+app.baseurl+'/admin/import" style="text-decoration:underline;">admin tool</a> to import them.</h4>';
        $('#faces').html(html);
        return;
      }

      Face.sort( Faces._sortHandler[by] );
      $('#faces').empty();

      for( x in Face ) {
        html = '\
          <div id="face_'+Face[x].id+'" class="face" data-face="'+app.baseurl+'/content/faces/'+Face[x].file+'" data-id="'+Face[x].id+'">\
            <img class="face_thumb" data-original="'+app.baseurl+'/content/thumbs/thumb_120_'+Face[x].file+'" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"/>\
            <div class="face_orig"></div>\
            <div class="gifmarker">►</div>\
            <a class="permalink" href="'+app.baseurl+'/'+Face[x].id+'">➜</div>\
          </div>';

        $('#faces').append( html );
      }

      $('#faces .face').each( function () {
        var face = $(this).data('face');
        if( face.split('.').pop() == 'gif' ) {
          $(this).find('.gifmarker').css('display','block');
        }
      });

      $('.face_thumb').lazyload({
        effect : 'fadeIn'
      });

      Faces.changeCategory( Faces.options.category );
    },

    changeCategory: function( cat ) {

      if( cat == 0 ) {
        $('div.face').css('display','inline-block');
      }
      else {
        for( x in Face ) {
          if( Face[x].category == cat ) {
            $('#face_'+Face[x].id).css('display','inline-block');
          }
          else {
            $('#face_'+Face[x].id).css('display','none');
          }
        }
      }
      Faces.options.category = cat;
      Faces._saveCookie();
      $('#faces').scroll();
    },

    search: function( text ) {
      this.changeCategory(0);
      if( text.length > 0 ) {
        text = text.toLowerCase();
        for( x in Face ) {
          if( Face[x].tags.join(' ').search( text ) > -1 ) {
            $('#face_'+Face[x].id).show();
          }
          else {
            $('#face_'+Face[x].id).hide();
          }
        }
      }
      else $('.face').show();
      $('#faces').scroll();
    },

    restoreInitial: function() {
      var cat   = 0,
          order = 'id';

      try {
        cat = cookie.category;
        order = cookie.order;
      }
      catch(e){}

      this.sort(order);
      this.changeCategory(cat);
    },

    _saveCookie: function() {
      $.post(app.baseurl+'/cookie',Faces.options,function( json ){ return true; },'json');
    },

    _sortHandler: {
      id: function( a, b ) {
        return parseInt( a.id, 10 ) - parseInt( b.id, 10 );
      },
      popularity: function( a, b ) {
        return b.popularity - a.popularity;
      },
      added: function( a, b ) {
        return parseInt( b.added, 10 ) - parseInt( a.added, 10 );
      }
    }
  };