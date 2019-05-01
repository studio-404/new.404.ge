var messageBox = (className, status, text) => {
	let out = "<div class=\"alert alert-"+className+" alert-dismissible fade show\"><button type=\"button\" aria-hidden=\"true\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><i class=\"nc-icon nc-simple-remove\"></i></button><span><b>"+status+" - </b> "+text+"</span></div>";
	return out;
};

var ajax = (request, post) => {
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", Config.ajax + "/" + request, true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(post);
	return xhttp;
};

(function(){

	document.getElementsByClassName("g-signin")[0].addEventListener("click", function(){
		let username = (typeof document.getElementsByClassName("username")[0] !== "undefind") ? document.getElementsByClassName("username")[0].value : '';
		let password = (typeof document.getElementsByClassName("password")[0] !== "undefind") ? document.getElementsByClassName("password")[0].value : '';
		let code = (typeof document.getElementsByClassName("code")[0] !== "undefind") ? document.getElementsByClassName("code")[0].value : '';

		var xhttp = ajax("ajax_users", "type=select&signtry=true&username="+username+"&password="+password+"&code="+code);
		
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4) {
				var out = {
					status: this.status,
					response: JSON.parse(this.responseText)
				};
				
				var className = "danger";
				if(out.status==200){
					className = "success";

					setTimeout(() => {
						location.href = "/"+Config.language+out.response.redirect;
					},1500);
				}

				document.getElementsByClassName("messageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
			}
		};
	});

})();