function disable_() {
	document.getElementById("trabajando").style.visibility = "visible";
	// body...
	var fields = document.getElementById("form").getElementsByTagName('*');
	for(var i = 0; i < fields.length; i++)
	{
	    fields[i].disabled = true;
	}
	document.getElementById("process").focus();
}
function enable_() {
	document.getElementById("trabajando").style.visibility = "hidden";
	//alert("ocultando");
	// body...
	var fields = document.getElementById("form").getElementsByTagName('*');
	for(var i = 0; i < fields.length; i++)
	{
	    fields[i].disabled = false;
	}	
}