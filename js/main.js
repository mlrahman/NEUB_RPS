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

var _validFileExtensions2 = [".mp4", ".ogg", ".webm"];    
function file_validate2(dataaa) {
	var sFileName = dataaa;
	if (sFileName.length > 0) {
		var blnValid = false;
		for (var j = 0; j < _validFileExtensions2.length; j++) {
			var sCurExtension = _validFileExtensions2[j];
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

var _validFileExtensions3 = [".xlsx"];    
function file_validate3(dataaa) {
	var sFileName = dataaa;
	if (sFileName.length > 0) {
		var blnValid = false;
		for (var j = 0; j < _validFileExtensions3.length; j++) {
			var sCurExtension = _validFileExtensions3[j];
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

function check_mobile_no(str)
{
	if(str.length==11)
	{
		var c=0;
		for(var i=0;i<str.length;i++)
		{
			if(str[i]>='0' && str[i]<='9')
				c++;
		}
		if(c==11)
			return true;
		else 
			return false;
		
	}
	else
		return false;
	
}