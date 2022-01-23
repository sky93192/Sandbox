function search_action(){
	document.getElementById("action").value = "search";
	document.getElementById("all_form").submit();
}

function page_action(){
	var value = document.getElementById("page").value;
	location.href = "index.php?page=" + value;
}

function delete_action(isbn) {
	document.getElementById("action").value = "delete";
	document.getElementById("selected_isbn").value = isbn;
	if (confirm('確定要刪除嗎？') == true) {
		document.getElementById("all_form").submit();
	}
}

function select_all_checkbox(source) {
	let checkboxes = document.getElementsByName("selected_book[]");
	for (let i = 0; i < checkboxes.length; i++) {
		checkboxes[i].checked = source.checked;
	}
}

function export_action(){
	document.getElementById("action").value = "export";
	document.getElementById("all_form").submit();
}

function change_color(tr) {
	tr.style.backgroundColor = '#EEEEEE';
}

function normal_color(tr) {
	tr.style.backgroundColor = '#FFFFFF';
}

function setup_tooltip(){
	let tooltip = '';
	let tooltip_div = document.querySelector(".div-tooltip");
	let tootip_elements = Array.from(document.querySelectorAll(".hover-reveal"));
	
	function displayToolTip(e, obj){
		tooltip = obj.dataset.tooltip;
		tooltip_div.innerHTML = tooltip;
		tooltip_div.style.top = e.clientY + "px";
		tooltip_div.style.left = e.clientX + "px";
		tooltip_div.style.opacity = 1;
	}

	tootip_elements.forEach(function(elem){
		elem.addEventListener("mouseenter", function(e){
			displayToolTip(e, this);
		});
		elem.addEventListener("mouseleave", function(e){
			tooltip_div.style.opacity = 0;
		});
	});
};