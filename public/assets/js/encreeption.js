var encreeption = {
  showPreview: function (file) {
    if (!file) {
      return;
    }

    var reader = new FileReader();

    reader.onload = function (e) {
      $('.image-preview')
        .css('background-image', 'url("' + e.target.result + '")')
        .removeClass('image-preview--hidden');
    };

    reader.readAsDataURL(file);
  },

  hidePreview: function () {
    $('.image-preview').addClass('image-preview--hidden');
  },

  onChangeImage: function () {
    if (app.alert.open) {
      app.alert.close();
    }

    if (this.value === '') {
      encreeption.hidePreview();
      encreeption.onImageRemoved();
      return;
    }

    encreeption.checkImageOnServer(
      encreeption.onImageLoaded.bind(this)
    );
  },

  checkImageOnServer: function (onSuccess) {
    var form = $('form')[0];
    form.action = '/ajax/image-info';

    app.sendFormWithAjax(form, function (data) {
      if (!data.success) {
        encreeption.onImageRemoved();
        return app.alert.show('The selected file is not image. Please choose another.');
      }

      onSuccess(data);
    });
  },

  onImageLoaded: function (response) {
    $('#message-input')
      .attr('maxlength', response.max_length)
      .prop('disabled', false)
      .inputCounter()
      .focus();

    encreeption.showPreview(this.files[0]);
  },

  onImageRemoved: function () {
    $('#message-input').prop('disabled', true);
    $('#message-input').next('.input-counter').html('');
  },

  onFormSubmit: function (e) {
    e.preventDefault();

    this.action = '/ajax/encreeption';
    
    app.ajaxForm(this, function (response) {
      var element = document.createElement('a');
      element.setAttribute('href', 'data:image/png;base64,' + response.image);
      element.setAttribute('download', 'creepimage_' + Date.now() + '.png');
      element.style.display = 'none';

      document.body.appendChild(element);

      element.click();

      document.body.removeChild(element);
    });
  },

  init: function () {
    $('#image-input').on('change', this.onChangeImage);
    $('form').on('submit', this.onFormSubmit);
  },
};

$(document).ready(function () {
  encreeption.init();
});
