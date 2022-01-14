function delete_submit(isbn){
	document.getElementById("selected_isbn").value = isbn;
	if(confirm('確定要刪除嗎？') == true){
		document.getElementById("change_form").submit();
	}
}

function select_all_checkbox(source){
	let checkboxes = document.getElementsByName("selected_book");
	for(let i = 0; i < checkboxes.length; i++){
		checkboxes[i].checked = source.checked;
	}
	
}

function change_color(tr){
	tr.style.backgroundColor = '#EEEEEE';
}

function normal_color(tr){
	tr.style.backgroundColor = '#FFFFFF';
}
