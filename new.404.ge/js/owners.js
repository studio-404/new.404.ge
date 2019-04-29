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

	if(typeof document.getElementsByClassName("addOwner")[0] !== "undefined"){
		document.getElementsByClassName("addOwner")[0].addEventListener("click", function(){
			let firstname = (typeof document.getElementsByClassName("firstname")[0] !== "undefined") ? document.getElementsByClassName("firstname")[0].value : '';
			let lastname = (typeof document.getElementsByClassName("lastname")[0] !== "undefined") ? document.getElementsByClassName("lastname")[0].value : '';
			let owners_name = (typeof document.getElementsByClassName("owners_name")[0] !== "undefined") ? document.getElementsByClassName("owners_name")[0].value : '';
			let owners_password = (typeof document.getElementsByClassName("owners_password")[0] !== "undefined") ? document.getElementsByClassName("owners_password")[0].value : '';
			let owners_id = (typeof document.getElementsByClassName("owners_id")[0] !== "undefined") ? document.getElementsByClassName("owners_id")[0].value : '';
			let owners_birthday = (typeof document.getElementsByClassName("owners_birthday")[0] !== "undefined") ? document.getElementsByClassName("owners_birthday")[0].value : '';
			let owners_phone = (typeof document.getElementsByClassName("owners_phone")[0] !== "undefined") ? document.getElementsByClassName("owners_phone")[0].value : '';
			let owners_phone2 = (typeof document.getElementsByClassName("owners_phone2")[0] !== "undefined") ? document.getElementsByClassName("owners_phone2")[0].value : '';
			let owners_email = (typeof document.getElementsByClassName("owners_email")[0] !== "undefined") ? document.getElementsByClassName("owners_email")[0].value : '';
			let owners_gender = (typeof document.querySelector("input[name='owners_gender']:checked") !== "undefined" && document.querySelector("input[name='owners_gender']:checked")!=null) ? document.querySelector("input[name='owners_gender']:checked").value : '';

			var xhttp = ajax("ajax_owners", "type=addOwner&firstname="+firstname+"&lastname="+lastname+"&owners_name="+owners_name+"&owners_password="+owners_password+"&owners_id="+owners_id+"&owners_birthday="+owners_birthday+"&owners_gender="+owners_gender+"&owners_phone="+owners_phone+"&owners_phone2="+owners_phone2+"&owners_email="+owners_email);

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
							location.href = "/"+Config.language+"/owners/index";
						},1500);
					}

					document.getElementsByClassName("ownerFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
					window.scrollTo(0, 0);
				}
			};
		});
	};

	if(typeof document.querySelector("input[name='owners_gender']") !== "undefined"){
		var genders = document.getElementsByClassName("owners_gender");
		for(var i = 0; i < genders.length; i++){
			genders[i].addEventListener("change", (e)=>{
				var val = e.target.value;
				document.getElementsByClassName("owners_gender")[0].checked = false;
				document.getElementsByClassName("owners_gender")[1].checked = false;

				document.querySelector("input[value='"+val+"']").checked = true;
			});
		}
	};

	if(typeof document.getElementsByClassName("editOwner")[0] !== "undefined"){
		document.getElementsByClassName("editOwner")[0].addEventListener("click", function(){
			let editid = parseInt(document.getElementsByClassName("editOwner")[0].getAttribute("data-editid"));
			
			let firstname = (typeof document.getElementsByClassName("firstname")[0] !== "undefined") ? document.getElementsByClassName("firstname")[0].value : '';
			let lastname = (typeof document.getElementsByClassName("lastname")[0] !== "undefined") ? document.getElementsByClassName("lastname")[0].value : '';
			let owners_name = (typeof document.getElementsByClassName("owners_name")[0] !== "undefined") ? document.getElementsByClassName("owners_name")[0].value : '';
			let owners_password = (typeof document.getElementsByClassName("owners_password")[0] !== "undefined") ? document.getElementsByClassName("owners_password")[0].value : '';
			let owners_id = (typeof document.getElementsByClassName("owners_id")[0] !== "undefined") ? document.getElementsByClassName("owners_id")[0].value : '';
			let owners_birthday = (typeof document.getElementsByClassName("owners_birthday")[0] !== "undefined") ? document.getElementsByClassName("owners_birthday")[0].value : '';
			let owners_phone = (typeof document.getElementsByClassName("owners_phone")[0] !== "undefined") ? document.getElementsByClassName("owners_phone")[0].value : '';
			let owners_phone2 = (typeof document.getElementsByClassName("owners_phone2")[0] !== "undefined") ? document.getElementsByClassName("owners_phone2")[0].value : '';
			let owners_email = (typeof document.getElementsByClassName("owners_email")[0] !== "undefined") ? document.getElementsByClassName("owners_email")[0].value : '';
			let owners_gender = (typeof document.querySelector("input[name='owners_gender']:checked") !== "undefined" && document.querySelector("input[name='owners_gender']:checked")!=null) ? document.querySelector("input[name='owners_gender']:checked").value : '';

			var xhttp = ajax("ajax_owners", "type=editOwner&editid="+editid+"&firstname="+firstname+"&lastname="+lastname+"&owners_name="+owners_name+"&owners_password="+owners_password+"&owners_id="+owners_id+"&owners_birthday="+owners_birthday+"&owners_gender="+owners_gender+"&owners_phone="+owners_phone+"&owners_phone2="+owners_phone2+"&owners_email="+owners_email);

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
							location.href = "/"+Config.language+"/owners/edit/"+editid;
						},1500);
					}

					document.getElementsByClassName("ownerFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
					window.scrollTo(0, 0);
				}
			};
		});
	};

	if(typeof document.getElementsByClassName("editOwnerPassword")[0] !== "undefined"){
		document.getElementsByClassName("editOwnerPassword")[0].addEventListener("click", function(){
			let editid = parseInt(document.getElementsByClassName("editOwnerPassword")[0].getAttribute("data-editid"));
			let newpassword = (typeof document.getElementsByClassName("newpassword")[0] !== "undefined") ? document.getElementsByClassName("newpassword")[0].value : '';
			
			var xhttp = ajax("ajax_owners", "type=editOwnerPassword&editid="+editid+"&newpassword="+newpassword);

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
							location.href = "/"+Config.language+"/owners/edit/"+editid;
						},1500);
					}

					document.getElementsByClassName("ownerFormPasswordMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
					window.scrollTo(0, 450); //
				}
			};
		});
	};

	//
	if(typeof document.getElementsByClassName("removeOwener") !== "undefined"){
		var removeOwener = document.getElementsByClassName("removeOwener");
		for(var i = 0; i < removeOwener.length; i++){
			removeOwener[i].addEventListener("click", function(){
				let modalTitle = this.getAttribute("data-modalTitle");
				let modalBody = this.getAttribute("data-modalBody");
				let yesText = this.getAttribute("data-yesText");
				let noText = this.getAttribute("data-noText");
				let id = this.getAttribute("data-id");

				var modalFooter = "<button type=\"button\" class=\"btn btn-primary btn-round deleteOwner\" data-id=\""+id+"\">"+yesText+"</button>";
			    modalFooter += "<button type=\"button\" class=\"btn btn-secondary btn-round\" data-dismiss=\"modal\">"+noText+"</button>";
			      
				bootModal(modalTitle, modalBody, modalFooter);


				if(typeof document.getElementsByClassName("deleteOwner")[0] !== "undefined"){
					document.getElementsByClassName("deleteOwner")[0].addEventListener("click", function(){
						let id = document.getElementsByClassName("deleteOwner")[0].getAttribute("data-id");

						var xhttp = ajax("ajax_owners", "type=deleteOwner&id="+id);

						xhttp.onreadystatechange = function() {
							if (this.readyState == 4) {
								var out = {
									status: this.status,
									response: JSON.parse(this.responseText)
								};
								
								if(out.status==200){
									location.reload();
								}else{
									if(document.getElementsByClassName("modal-body")[0] !== "undefined"){
										document.getElementsByClassName("modal-body")[0].innerHTML = "<p>"+out.response.message+"</p>";
									}

									if(document.getElementsByClassName("modal-footer")[0] !== "undefined"){
										document.getElementsByClassName("modal-footer")[0].remove();
									}
									console.log(out);
								}
							}
						};
					});		
				}
			});
		}
	};

})();