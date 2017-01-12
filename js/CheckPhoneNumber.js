function Check() {
    var phone = $("#ph").val();

	while(phone.includes(" "))
	{
		phone.replace(" ","");
	}
	document.write(phone);
	if (phone.length!=10  ) {
		document.getElementById("help").style.visibility = "visible";
	}
	
}