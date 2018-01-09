var mainFunction = (function()
{
	var webURL = "http://ec2-13-59-23-31.us-east-2.compute.amazonaws.com"; // server url
	
	
	function LoginForm(){ // send login info to server and recieve a session to work with
		var EntranceType = 1; // 1 = web entrance, 2 = mobile entrance 
		var userLoginDetailsData = {
			username : document.getElementById('InputUserName').value,
			password : document.getElementById('InputPassword').value,
			source : EntranceType
		};
		var SignInFrom = {userLoginDetails : userLoginDetailsData};
		ajaxRequest(SignInFrom, webURL + "/index.php", LoginFormResult);
	}
	
	function LoginFormResult(response){ // Get user info to show the appopriate home screen
		var myresponse = response.replace(/\n|\r/g, "");
		alert(myresponse);
		if(myresponse == "admin logged in")
		{
			window.location.href = "MainPage.html";
		}
	}
			
	$("document").ready(function(){
				
		$('#SignInForm').submit(function(event){ // enter the homescreen page
			event.preventDefault();
			LoginForm();
		});
	});
}());