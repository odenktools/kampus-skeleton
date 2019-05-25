var INIT = {
	run: function () {
		this.tooltip();
		this.icheck();
		this.select2();
		this.preloader();
		this.prepareAjax();
	},
	tooltip: function () {
		$('[title], [data-title]').tooltip();
	},
	icheck: function () {
		$('.checkbox.icheck [type="checkbox"]').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' // optional
		});
	},
	select2: function () {
		$('.select2').select2({
			placeholder: function () {
				$(this).data('placeholder');
			},
			allowClear: true
		});
	},
	preloader: function () {
		var $preloader = $('#preloader'),
		$spinner = $preloader.find('.spinner');
		$spinner.fadeOut();
		$preloader.delay(500).fadeOut('slow');
		window.scrollTo(0, 0);
	},
	prepareAjax: function () {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	}
}

var CALL = {
	clearModalBackground: function (modal) {
		$(modal).find('.modal-header')
		.removeClass('modal-primary')
		.removeClass('modal-success')
		.removeClass('modal-info')
		.removeClass('modal-warning')
		.removeClass('modal-danger');
	},
	previewImage: function (input, image) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$(image).attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	},
}

var MODAL = {
	run: function () {
		this.action();
		this.form();
	},
	action: function (button) {
		var me = '#modal-action';

		if (button == undefined) {
			button = '.btn-modal-action';
		}

		$(document).on('click', button, function (e) {
			var href = $(this).data('href');
			var title = $(this).data('title');
			var icon = $(this).data('icon');
			var background = $(this).data('background');

			if (icon == undefined) {
				icon = '';
			} else {
				icon = '<i class="' + icon + '"></i>';
			}

			$.ajax({
				url: href,
				type: 'GET',
				dataType: 'HTML',
				success: function (data) {
					CALL.clearModalBackground(me);
					$(me).find('.modal-header').addClass(background);
					$(me).find('.modal-title').html(icon + title);
					$(me).find('.modal-body').html(data);
					$(me).modal('show');
					INIT.run();
				}
			});

			e.preventDefault();
		});
	},
	form: function (button) {
		var me = '#modal-form';

		if (button == undefined) {
			button = '.btn-modal-form';
		}

		$(document).on('click', button, function (e) {
			var href = $(this).data('href');
			var title = $(this).data('title');
			var icon = $(this).data('icon');
			var background = $(this).data('background');

			if (icon == undefined) {
				icon = '';
			} else {
				icon = '<i class="' + icon + '"></i>';
			}

			$.ajax({
				url: href,
				type: 'GET',
				dataType: 'HTML',
				success: function (data) {
					CALL.clearModalBackground(me);
					$(me).find('.modal-header').addClass(background);
					$(me).find('.modal-title').html(icon + title);
					$(me).find('.modal-body').html(data);
					$(me).modal('show');
					INIT.run();
				}
			});

			e.preventDefault();
		});

		$(document).on('click', me + ' [type="submit"]', function (e) {
			var form = $(this).parents('form');
			var action = $(form).attr('action');

			var formData = new FormData($(form)[0]);

			$.ajax({
				url: action,
				type: 'POST',
				dataType: 'HTML',
				data: formData,
				enctype: "multipart/form-data",
				cache: false,
				contentType: false,
				processData: false,
				success: function (data) {
					try {
						data = JSON.parse(data);
						if (data.redirect != undefined) {
							window.location.href = data.redirect;
						}
					} catch (e) {
						$(me).find('.modal-body').html(data);
					}
					INIT.run();
				}
			});

			e.preventDefault();
		});
	},
}

$(function () {
	INIT.run();
	MODAL.run();
});
