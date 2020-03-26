function get_result()
{
	document.getElementById('result_popup').style.display='block';
}

var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png", ".heic"];    
function file_validate(dataaa) {
	
	var sFileName = dataaa;
	if (sFileName.length > 0) {
		var blnValid = false;
		for (var j = 0; j < _validFileExtensions.length; j++) {
			var sCurExtension = _validFileExtensions[j];
			if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
				blnValid = true;
				break;
			}
		}
		if (!blnValid) {
			 return false;
		}
	}
	return true;
}