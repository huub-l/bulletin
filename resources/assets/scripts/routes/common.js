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
      var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
      var to = "aaaaeeeeiiiioooouuuunc------";
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
    $(".sb-toc-item-a").click(function () {
      
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
      
      table.addClass('table table-striped article-table')
           .wrap('<div class="article-table-wrap"></div>')
           .after('<div class="article-table-overlay"><span class="view-table-text">View table</span></div>');

    })

    $('.article-table-overlay').click(function(){

      var table = $(this).prev();

      table.clone().appendTo('body')
           .addClass('overlay-table')
           .wrap('<div class="clone-table-wrap"></div>');

      $('.clone-table-wrap').click(function () {
        $(this).fadeOut(300, function () { $(this).remove(); });
      })

    });

  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
