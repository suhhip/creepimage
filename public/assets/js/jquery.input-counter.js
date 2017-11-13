$.fn.inputCounter = function () {
  var $counterPlace = this.next('.input-counter');

  function countMethod() {
    var actualLength   = this.value.length;
    var maxLength      = this.maxLength;
    var text;

    if (actualLength > maxLength) {
      text = maxLength + ' / ' + maxLength + ' (' + actualLength + ')';
    }
    else {
      text = actualLength + ' / ' + maxLength;
    }

    $counterPlace.html(text + ' chars');
  }

  this
    .unbind('keyup.counter')
    .on('keyup.counter', countMethod)
    .trigger('keyup');

  return this;
};
