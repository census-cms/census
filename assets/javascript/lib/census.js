(function() {
	if ($('#quilljs').length > 0) {
		var editor = new Quill('#quilljs', {
			modules: {
				toolbar: [
					[{ header: [] }],
					['bold', 'italic', 'underline', 'link'],
					[{ color: [] }],
					[{ list: 'ordered' }, { list: 'bullet' }],
					['clean']
				]
			},
			theme: 'snow'
		});

		editor.on('editor-change', function() {
			$('#quilljsTarget').val($('.ql-editor').html());
		});
	}
})();