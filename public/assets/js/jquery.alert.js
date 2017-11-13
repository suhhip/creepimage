$.fn.alert = function () {
  this.opened = false;

  this.show = function (message) {
    this.open = true;
    this.removeClass('alert--hidden')
      .find('.alert__message').html(message);
  };

  this.close = function () {
    this.open = false;
    this.addClass('alert--hidden');
  };

  this.find('.close').on('click', this.close.bind(this));

  return this;
};
