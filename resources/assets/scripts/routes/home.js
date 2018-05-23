export default {
  init() {

    $('.home-keywords__button').on('click', function(event){
      event.preventDefault();
      $('#home-keyword-list__div').toggleClass('home-keyword-list__div--short');
      $('.home-keywords__button').toggleClass('hidden');
    });

  },
  finalize() {
    
  },
};
