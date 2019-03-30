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

	if(typeof document.getElementsByClassName("removeCompany") !== "undefined"){
		var removeCompany = document.getElementsByClassName("removeCompany");
		for(var i = 0; i < removeCompany.length; i++){
			removeCompany[i].addEventListener("click", function(){
				let modalTitle = this.getAttribute("data-modalTitle");
				let modalBody = this.getAttribute("data-modalBody");
				let yesText = this.getAttribute("data-yesText");
				let noText = this.getAttribute("data-noText");
				let id = this.getAttribute("data-id");

				var modalFooter = "<button type=\"button\" class=\"btn btn-primary btn-round deleteCompany\" data-id=\""+id+"\">"+yesText+"</button>";
			    modalFooter += "<button type=\"button\" class=\"btn btn-secondary btn-round\" data-dismiss=\"modal\">"+noText+"</button>";
			      
				bootModal(modalTitle, modalBody, modalFooter);


				if(typeof document.getElementsByClassName("deleteCompany")[0] !== "undefined"){
					document.getElementsByClassName("deleteCompany")[0].addEventListener("click", function(){
						let id = document.getElementsByClassName("deleteCompany")[0].getAttribute("data-id");

						var xhttp = ajax("ajax_companies", "type=deleteCompany&id="+id);

						xhttp.onreadystatechange = function() {
							if (this.readyState == 4) {
								var out = {
									status: this.status,
									response: JSON.parse(this.responseText)
								};
								
								if(out.status==200){
									location.reload();
								}else{
									console.log(out);
								}
							}
						};
					});		
				}
			});
		}
	}


	if(typeof document.getElementsByClassName("addCompany")[0] !== "undefined"){
		document.getElementsByClassName("addCompany")[0].addEventListener("click", function(){
			let title = (typeof document.getElementsByClassName("title")[0] !== "undefined") ? document.getElementsByClassName("title")[0].value : '';
			let identity = (typeof document.getElementsByClassName("identity")[0] !== "undefined") ? document.getElementsByClassName("identity")[0].value : '';
			let contact_phone = (typeof document.getElementsByClassName("contact_phone")[0] !== "undefined") ? document.getElementsByClassName("contact_phone")[0].value : '';
			let contact_email = (typeof document.getElementsByClassName("contact_email")[0] !== "undefined") ? document.getElementsByClassName("contact_email")[0].value : '';
			let address = (typeof document.getElementsByClassName("address")[0] !== "undefined") ? document.getElementsByClassName("address")[0].value : '';
			let website = (typeof document.getElementsByClassName("website")[0] !== "undefined") ? document.getElementsByClassName("website")[0].value : '';
			
			var xhttp = ajax("ajax_companies", "type=addCompany&title="+title+"&identity="+identity+"&contact_phone="+contact_phone+"&contact_email="+contact_email+"&address="+address+"&website="+website);

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
							location.href = "/"+Config.language+"/company/index";
						},1500);
					}

					document.getElementsByClassName("companiesFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
				}
			};
		});
	}

	if(typeof document.getElementsByClassName("editCompany")[0] !== "undefined"){
		document.getElementsByClassName("editCompany")[0].addEventListener("click", function(){
			let editid = parseInt(document.getElementsByClassName("editCompany")[0].getAttribute("data-editid"));
			let title = (typeof document.getElementsByClassName("title")[0] !== "undefined") ? document.getElementsByClassName("title")[0].value : '';
			let identity = (typeof document.getElementsByClassName("identity")[0] !== "undefined") ? document.getElementsByClassName("identity")[0].value : '';
			let contact_phone = (typeof document.getElementsByClassName("contact_phone")[0] !== "undefined") ? document.getElementsByClassName("contact_phone")[0].value : '';
			let contact_email = (typeof document.getElementsByClassName("contact_email")[0] !== "undefined") ? document.getElementsByClassName("contact_email")[0].value : '';
			let address = (typeof document.getElementsByClassName("address")[0] !== "undefined") ? document.getElementsByClassName("address")[0].value : '';
			let website = (typeof document.getElementsByClassName("website")[0] !== "undefined") ? document.getElementsByClassName("website")[0].value : '';
			
			var xhttp = ajax("ajax_companies", "type=editCompany&editid="+editid+"&title="+title+"&identity="+identity+"&contact_phone="+contact_phone+"&contact_email="+contact_email+"&address="+address+"&website="+website);

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
							location.href = "/"+Config.language+"/company/edit/"+editid;
						},1500);
					}

					document.getElementsByClassName("companiesFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
				}
			};
		});
	}

})();