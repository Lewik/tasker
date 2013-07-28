$(function () {

	$('.taskOpener').click(function(){
		$('.taskTitleContainer[data-id='+$(this).attr('data-id')+']').hide();
		$('.taskEditorContainer[data-id='+$(this).attr('data-id')+']').show();
	});
	
	$('.taskMinimizer').click(function(){
		$('.taskEditorContainer[data-id='+$(this).attr('data-id')+']').hide();
		$('.taskTitleContainer[data-id='+$(this).attr('data-id')+']').show();
	});

	$('.taskListTagSelector').change(function () {
		if ($(this).val() == '__create') {

			$('.taskListTagSelector option:selected').each(function () {
				if ($(this).val() == '__create') {
					this.selected = false;
				}
			});

			var tag;
			if (tag = prompt('Новый тег')) {
				$('.taskListNewTag').val(tag);
			}
		}

		$('.taskListTagSelectorForm').submit();
	})


	$('.taskTagSelector').change(function () {

		markAsUnsaved($(this).attr('data-id'));
		/*
		 Доделать добавление НЕСКОЛЬКИХ новых дегов. Должно аппендиться в список и должно в пхп нормально разбираться.
		 if(in_array('__create',$(this).val(),true)){
		 var tag;
		 if(tag = prompt('Новый тег')){
		 console.log(tag);
		 }
		 }
		 */
	})

	$('.deleteTagSelector').change(function () {
		$('.deleteTagSelectorForm').submit();
	});

	$('.editTagSelector').change(function () {
		var newName;
		if (newName = prompt('Укажите новое имя', $('.editTagSelector :selected').text().trim())) {
			$('.editTagNewName').val(newName);
			$('.editTagSelectorForm').submit();
		}
	});
});

function markAsUnsaved(id) {
	$('#saveButton' + id)
		.css('background-color', 'red')
		.val('Сохранить');
}

function in_array(needle, haystack, strict) {	// Checks if a value exists in an array
	//
	// +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

	var found = false, key, strict = !!strict;

	for (key in haystack) {
		if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
			found = true;
			break;
		}
	}

	return found;
}