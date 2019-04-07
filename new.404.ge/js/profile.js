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

	document.getElementsByClassName("updateProfileButton")[0].addEventListener("click", function(){
		let firstname = (typeof document.getElementsByClassName("firstname")[0] !== "undefind") ? document.getElementsByClassName("firstname")[0].value : '';
		let lastname = (typeof document.getElementsByClassName("lastname")[0] !== "undefind") ? document.getElementsByClassName("lastname")[0].value : '';
		let contact_email = (typeof document.getElementsByClassName("contact_email")[0] !== "undefind") ? document.getElementsByClassName("contact_email")[0].value : '';
		let contact_phone = (typeof document.getElementsByClassName("contact_phone")[0] !== "undefind") ? document.getElementsByClassName("contact_phone")[0].value : '';


		var xhttp = ajax("ajax_users", "type=update&firstname="+firstname+"&lastname="+lastname+"&contact_email="+contact_email+"&contact_phone="+contact_phone);

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
						location.href = "/"+Config.language+"/profile/index";
					},1500);
				}

				document.getElementsByClassName("updateProfileMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
				window.scrollTo(0, 0);
			}
		};
	});

	document.getElementsByClassName("updatepasswordButton")[0].addEventListener("click", function(){
		let oldpassword = (typeof document.getElementsByClassName("oldpassword")[0] !== "undefind") ? document.getElementsByClassName("oldpassword")[0].value : '';
		let newpassword = (typeof document.getElementsByClassName("newpassword")[0] !== "undefind") ? document.getElementsByClassName("newpassword")[0].value : '';
		let confirmpassword = (typeof document.getElementsByClassName("confirmpassword")[0] !== "undefind") ? document.getElementsByClassName("confirmpassword")[0].value : '';

		var xhttp = ajax("ajax_users", "type=updatepassword&oldpassword="+oldpassword+"&newpassword="+newpassword+"&confirmpassword="+confirmpassword);		

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
						location.href = "/"+Config.language+"/profile/index";
					},1500);
				}

				document.getElementsByClassName("updatePasswordMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
				window.scrollTo(0, 0);
			}
		};
	});

})();