var app = {
  alert: null,

  sendFormWithAjax: function (form, callback, options) {
    var formData = new FormData(form);

    if (typeof options !== 'object') {
      var options = {};
    }

    options = Object.assign({
      url           : '?r=' + form.getAttribute('action'),
      type          : form.method,
      data          : formData,
      async         : true,
      cache         : false,
      contentType   : false,
      processData   : false,
      success       : callback,
    }, options);

    $.ajax(options);
  },

  ajaxForm: function (form, onSuccess) {
    var $buttonFrame = $(form).find('.button-frame')

    $buttonFrame.addClass('button-frame--loading');

    var callback = function (response) {
      $buttonFrame.removeClass('button-frame--loading');

      if (!response.success) {
        return app.alert.show(response.message);
      }

      onSuccess(response);
    };

    app.sendFormWithAjax(form, callback);
  },

  initAlert: function () {
    this.alert = $('.alert').alert();
  },

  initTooltips: function () {
    $('[data-toggle="tooltip"]').tooltip();
  },

  init: function () {
    this.initAlert();
    this.initTooltips();
  },
};

$(document).ready(function () {
  app.init();
});
