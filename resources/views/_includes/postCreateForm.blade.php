@if($post_type == '1')
	<div class="custom-select" id="custom-select">- Choose Post Tags -</div>
	<div id="custom-select-option-box">
		<div class="custom-select-option">
			<input onchange="toggleFillColor(this);"
				class="custom-select-option-checkbox" type="checkbox"
				name="tags[]" value="PHP"> PHP
		</div>
		<div class="custom-select-option">
			<input onchange="toggleFillColor(this);"
				class="custom-select-option-checkbox" type="checkbox"
				name="tags[]" value="Python"> Python
		</div>
		<div class="custom-select-option">
			<input onchange="toggleFillColor(this);"
				class="custom-select-option-checkbox" type="checkbox"
				name="tags[]" value="Android"> Android
		</div>
		<div class="custom-select-option">
			<input onchange="toggleFillColor(this);"
				class="custom-select-option-checkbox" type="checkbox"
				name="tags[]" value="iOS"> iOS
		</div>
		<div class="custom-select-option">
			<input onchange="toggleFillColor(this);"
				class="custom-select-option-checkbox" type="checkbox"
				name="tags[]" value="UI"> UI
		</div>
	</div>

@endif

<input type="text" name="title" id="title" placeholder="Enter Post Title" required="">
<textarea name="description" id="description" placeholder="Enter Post Description" required=""></textarea>

<input type="file" name="image" id="image">

<button type="button" id="submitBtn"> SUBMIT </button>