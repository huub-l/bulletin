export default {
  init() {
    // JavaScript to be fired on the home page
  },
  finalize() {
    $('.home-cover-image__img')
      .mouseenter(function () {
        $(this).addClass("home-cover-image__img--hover");})
      .mouseleave(function () {
        $(this).removeClass("home-cover-image__img--hover");});
  },
};
