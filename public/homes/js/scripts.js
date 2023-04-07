function clipboard(value){
	var copyText = document.getElementById('copyText');
	copyText.select();
	if (value=='copy') {
		document.execCommand('copy')
	}
}