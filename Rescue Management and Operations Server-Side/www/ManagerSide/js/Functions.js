function ajaxRequest(SendObject, serverPage, myfunction, contentType, processData){
	if(typeof contentType == 'undefined')
		contentType = "application/x-www-form-urlencoded; charset=UTF-8";
	if(typeof processData == 'undefined')
		processData = true;
	$.ajax({ 
			type: 'POST',
			url: serverPage,
			data: SendObject,
			processData: processData,
			contentType: contentType,
			crossDomain: true,
			beforeSend: function(xhr){
					xhr.withCredentials = true;
			},
			success:myfunction,
			error:function(xhr, status, error){
				var str = JSON.stringify(xhr);
				alert("xhr: " + str + "\nStatus: " + status + "\nError: " + error);
			}
	});
}

function serverURL(){
	var url = "http://e734e372.ngrok.io";
	return url;
	
}