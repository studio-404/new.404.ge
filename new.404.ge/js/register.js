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

var bootModal = (modalTitle, modalBody, modalFooter) => {
	$(".modal").remove();
	let out = "<div class=\"modal\" tabindex=\"-1\" role=\"dialog\">";
	out += "<div class=\"modal-dialog\" role=\"document\">";
  	out += "<div class=\"modal-content\">";
	out += "<div class=\"modal-header\">";
    out += "<h5 class=\"modal-title\">"+modalTitle+"</h5>";
    out += "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    out += "<span aria-hidden=\"true\">&times;</span>";
	out += "</button>";
    out += "</div>";
    out += "<div class=\"modal-body\">";
    out += modalBody;
	out += "</div>";
    out += "<div class=\"modal-footer\">";
    out += modalFooter;  
    out += "</div>";
   	out += "</div>";
  	out += "</div>";
	out += "</div>";
	$("body").append(out);
	$(".modal").modal("show");
};

(function(){

	if(typeof document.getElementsByClassName("g-registeruser")[0] !== "undefined"){
		document.getElementsByClassName("g-registeruser")[0].addEventListener("click", () => {
			let firstname = document.getElementsByClassName("firstname")[0].value;
			let lastname = document.getElementsByClassName("lastname")[0].value;
			let username = document.getElementsByClassName("username")[0].value;
			let password = document.getElementsByClassName("password")[0].value;
			let contact_email = document.getElementsByClassName("contact_email")[0].value;
			let contact_phone = document.getElementsByClassName("contact_phone")[0].value;
			
			let company_title = document.getElementsByClassName("company_title")[0].value;
			let company_identity = document.getElementsByClassName("company_identity")[0].value;
			let company_contact_number = document.getElementsByClassName("company_contact_number")[0].value;
			let company_email = document.getElementsByClassName("company_email")[0].value;
			let company_address = document.getElementsByClassName("company_address")[0].value;
			let company_website = document.getElementsByClassName("company_website")[0].value;
			let code = document.getElementsByClassName("code")[0].value;

			var xhttp = ajax(
				"ajax_register", 
				"type=adduser"+
				"&firstname="+firstname+
				"&lastname="+lastname+
				"&username="+username+
				"&password="+password+
				"&contact_email="+contact_email+
				"&contact_phone="+contact_phone+
				"&company_title="+company_title+
				"&company_identity="+company_identity+
				"&company_contact_number="+company_contact_number+
				"&company_email="+company_email+
				"&company_address="+company_address+
				"&company_website="+company_website+
				"&code="+code
			);

			xhttp.onreadystatechange = function() {
				if (this.readyState == 4) {
					var out = {
						status: this.status,
						response: JSON.parse(this.responseText)
					};
					
					var className = "danger";
					if(out.status==200){
						className = "success";

						document.getElementsByTagName("form")[0].reset();
					}

					document.getElementsByClassName("messageBoxRegister")[0].innerHTML = messageBox(className, out.status, out.response.message);
					window.scrollTo(0, 0);
				}
			};

		});
	};

})();