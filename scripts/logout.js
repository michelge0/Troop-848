
function logOut() {
	gapi.load('auth2', function() {
		gapi.auth2.init({
			client_id: '251137415595-uttj6cdrkgfahoc0hffe2je2gt29utbo.apps.googleusercontent.com'
		}).then(function() {
			auth2 = gapi.auth2.getAuthInstance();
			auth2.signOut().then(function() {
		        $.ajax({
			        type: "GET",
			        url: "../logout.php",
			        success: function() {
			            window.location = "login.php";
			        },
			        error: function() {
			            alert("AJAX error...");
			        }
			    });
			});
		});
	});
}