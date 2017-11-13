var decreeption = {
  onFormSubmit: function (e) {
    e.preventDefault();

    app.alert.close();
    $('#encreepted-data').hide('fast');

    app.ajaxForm(this, function (response) {
      $('#encreepted-data').show('fast');
      $('#encreepted-data__text').html(response.data);
    });
  },

  initForm: function () {
    $('#decreeption-form').on('submit', this.onFormSubmit);
  },

  init: function () {
    this.initForm();
  },
};

$(document).ready(function () {
  decreeption.init();
});
