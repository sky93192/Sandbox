function delete_action(dev) {
	document.getElementById("selected_dev").value = dev;
	if (confirm('Want to delete?') == true) {
		document.getElementById("arpform").submit();
	}
}