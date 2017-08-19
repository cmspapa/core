
'use strict';

/**
 * Generate Id for given type and name.
 * @param {string} type - The type of id we like to generate such as field.
 * @param {string} name - The name that we needs to convert to id.
 * @return {string} The id only contain lowercase letters, numbers, and underscores.
 */
function generatePapaId(type = '', name) {
	if(type !== ''){
		type = type+'_';
	}
	return type+name.replace(/ /g, '_').replace(/\W/g, '').toLowerCase();
}

/*
 * Listen to name filed key up to genrate id for this name.
 * @param {string} type - The type of id we like to generate such as field.
 * @return {void}
 */
function listenToPapaName(type = '') {
	$('input.papa-field-name').on('keyup', function () {
		$('.papa-field-auto-id span').text(generatePapaId(type, $(this).val()));
		$('input.papa-field-id').val(generatePapaId(type, $(this).val()));
	});

	$('input.papa-field-id').on('keyup', function () {
		$('.papa-field-auto-id span').text(generatePapaId(type, $(this).val()));
	});

	$('.papa-field-id-group').css('display', 'none');
	$('a.papa-field-auto-id').on('click', function () {
		$('.papa-field-id-group').toggle();
	});
}
listenToPapaName();
