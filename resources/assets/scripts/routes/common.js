export default {
  init() {
    // JavaScript to be fired on all pages

    // Beautify first 5 words
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

    function getPosition(string, subString, index) {
      return string.split(subString, index).join(subString).length;
    }

  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
