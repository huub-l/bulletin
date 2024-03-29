export default {
  init() {
    // JavaScript to be fired on all pages

    /**
     * Beautify first 3 words in the "Abstract" of articles
     */ 
    $('#single-article-exerpt').each(function () {
      var word = $(this).html();
      var index = getPosition(word, ' ', 3);
      if (index == -1) {
        index = word.length;
      }
      $(this).html('<span class="single-abstract-first-words">'  
                    + word.substring(0, index) 
                    + '</span>' 
                    + word.substring(index, word.length));
    });

    /**
     * Beautify first 2 words of image caption
     */ 
    $('figcaption').each(function () {
      var word = $(this).html();
      var index = getPosition(word, ' ', 2);
      if (index == -1) {
        index = word.length;
      }
      $(this).html('<span class="caption-first-words">'  
                    + word.substring(0, index) 
                    + '</span>' 
                    + word.substring(index, word.length));
    });

    /**
     * Generate ToC for articles
     * 
     */ 
    var sbtoc = '<ul class="sb-toc">';

    $('.type-article h1:not(#sb-entry-title)').each(function(){
      var title = $(this).html().trim();
      var titleSlug = sluggify(title);

      $(this).attr('id', titleSlug);

      if (title.toLowerCase() != 'keywords'){
        sbtoc += '<a class="sb-toc-item-a" href="#' + titleSlug + '"><li class="sb-toc-item">' + title +'</li></a>';
      }

    });

    $('#sb-toc-wrap').html(sbtoc+'</ul>');

    /**
     * Get position of a certain occurance of a subString in string
     */ 
    function getPosition(string, subString, index) {
      return string.split(subString, index).join(subString).length;
    }

    /** 
     * Sluggyfy a string
     * Courtesy of @codeguy https://gist.github.com/codeguy/6684588
     * 
     */
    function sluggify(str) {
      str = str.replace(/^\s+|\s+$/g, ''); // trim
      str = str.toLowerCase();

      // remove accents, swap ñ for n, etc
      var from = 'àáäâèéëêìíïîòóöôùúüûñç·/_,:;';
      var to = 'aaaaeeeeiiiioooouuuunc------';
      for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
      }

      str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

      return str;
    }

    /**
     * Smooth scroll for ToC
     * 
     */
    $('.sb-toc-item-a').click(function () {
      
      var heading = $(this).attr('href');

      $('html, body').animate({
        scrollTop: $(heading).offset().top - 100,
      }, 500);

    });

    /**
     * Manipulate tables in the article
     * 
     */
    $('article.type-article table').each(function () {
      
      var table = $(this);
      
      table.addClass('table table-bordered table-condensed table-responsive article-table');

      if (window.matchMedia('screen').matches) {
        if (table.children('tbody').width() > 730 || table.children('tbody').height() > 500 ) {
          table.wrap('<div class="article-table-wrap"></div>') 
              .after('<div class="article-table-overlay"> \
                      <button class="btn btn-primary view-table-text"> \
                      View table<span class="print-only"> online</span> \
                      </button></div>');
        }
      }
    });

    $('.article-table-overlay').click(function(){

      var table = $(this).prev();

      table.clone().appendTo('body')
           .addClass('overlay-table')
           .wrap('<div class="clone-table-wrap"></div>');

      $('.clone-table-wrap').click(function () {
        $(this).fadeOut(300, function () { $(this).remove(); });
      })

    });


    /**
     * Use popups instead of scrolls for anchor references.
     * https://github.com/APN-ComDev/bulletin/issues/69
     */
    
    $('.article-content a').each(function(){
           
      var $anchor = $(this);
      var href = $anchor.attr('href');

      if (href && href.substring(0,1) == '#') {
      // This is is an in-text anchor

        var $reference   = $(href);
        var popupId = 'ref-popup-' + href.slice(1) + Math.random().toString(36).substr(2, 5);
        var $referenceLi = $reference.parent();

        if($referenceLi.is('li')) {
        // There's a corresponding anchor in the ref list

          $('article').append(
            '<span class="ref-popup__span ref-popup__span--hidden" id="' + popupId + '"> \
                <button type = "button" class= "close ref-popup__close-button" aria-label="Close" > \
                   <span aria-hidden="true">&times;</span> \
                </button> \
            </span>'
          );

          var $popupText = $referenceLi.clone();

          $popupText.find('a').each( function(){
          // Resolve duplicated anchor ID
            
            var $anchor = $(this);

            if ( $anchor.text().trim().length == 0 ) {

              $anchor.remove();

            } else {

              $anchor.removeAttr('id');

            }

          });

          // Add reference text to the popup span
          $('#' + popupId).css('max-width', $('.article-content').outerWidth())
                        .append($popupText.contents());
          
          // Listen to click events on in-text citations
          $anchor.on('click', function(event) {

            event.preventDefault();

            $('.ref-popup__span').removeClass('slideInUp')
              .addClass('ref-popup__span--hidden');

            $('#' + popupId).removeClass('ref-popup__span--hidden')
                            .addClass('animated slideInUp');

          });
        }
      }

    });

    /**
     * 
     * Close ref-popup
     * 
     */

    $('.ref-popup__close-button').on('click', function(){
      $('.ref-popup__span').removeClass('slideInUp')
        .addClass('ref-popup__span--hidden');
    });

    /** 
     * Animation on cover images 
     * 
     * */

    $('.sb-cover-image__img')
      .mouseenter(function () {
        $(this).addClass('sb-cover-image__img--hover');
      })
      .mouseleave(function () {
        $(this).removeClass('sb-cover-image__img--hover');
      });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
