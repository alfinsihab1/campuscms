<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script type="text/javascript">
	// Generate Quill
	function generate_quill(selector, readonly = false){
		var toolbarOptions = [
			[{ 'header': [1, 2, 3, 4, 5, 6, false] }],
			['bold', 'italic', 'underline', 'strike'],
			[{ 'script': 'sub'}, { 'script': 'super' }],
			['link', 'image', 'video'],
			[{ 'list': 'ordered'}, { 'list': 'bullet' }],
			[{ 'align': [] }],
			[{ 'indent': '-1'}, { 'indent': '+1' }],
			[{ 'direction': 'rtl' }],
			[{ 'color': [] }, { 'background': [] }],
			['clean']     
		];

		// Quill Editor
		var quill = new Quill(selector, {
			modules: {
				toolbar: toolbarOptions
			},
			placeholder: 'Tulis sesuatu...',
			theme: 'snow',
			imageResize: {
				displayStyles: {
					backgroundColor: 'black',
					border: 'none',
					color: 'white'
				},
				modules: [ 'Resize', 'DisplaySize', 'Toolbar' ]
			},
			readOnly: readonly
		});

		return quill;
	}
</script>