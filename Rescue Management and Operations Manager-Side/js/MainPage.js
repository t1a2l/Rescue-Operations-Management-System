var mainFunction = (function()
{
	var webURL = "http://ec2-13-59-23-31.us-east-2.compute.amazonaws.com"; // server url
	
	function LogOut(){ // log out from app
		var stopSession = {logout : true};
		ajaxRequest(stopSession, webURL + "/logout.php", LogOutResult);
	}
	
	function LogOutResult(response){ // show sign in page after log out
		if(response == "Success")
		{
			window.location.href = "LoginPage.html";
		}
		else
			alert(response);
		
	}
		
		
	$("document").ready(function(){
				
		$(document).on("click", "#newEventBtn", function(){ // Create new event
			event.preventDefault();
			window.location.href = "NewEvent.html";
		});
		
		$(document).on("click", "#joinEventBtn", function(){ // Return to active evnet
			event.preventDefault();
			window.location.href = "ActiveEvent.html";
		});
		
		$(document).on("click", "#logoutBtn", function(){ // log out from system
			event.preventDefault();
			LogOut();
		});
		
	});
}());