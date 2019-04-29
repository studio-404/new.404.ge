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
	if(typeof document.getElementsByClassName("removeUser") !== "undefined"){
		var removeUser = document.getElementsByClassName("removeUser");
		for(var i = 0; i < removeUser.length; i++){
			removeUser[i].addEventListener("click", function(){
				let modalTitle = this.getAttribute("data-modalTitle");
				let modalBody = this.getAttribute("data-modalBody");
				let yesText = this.getAttribute("data-yesText");
				let noText = this.getAttribute("data-noText");
				let id = this.getAttribute("data-id");

				var modalFooter = "<button type=\"button\" class=\"btn btn-primary btn-round deleteUser\" data-id=\""+id+"\">"+yesText+"</button>";
			    modalFooter += "<button type=\"button\" class=\"btn btn-secondary btn-round\" data-dismiss=\"modal\">"+noText+"</button>";
			      
				bootModal(modalTitle, modalBody, modalFooter);


				if(typeof document.getElementsByClassName("deleteUser")[0] !== "undefined"){
					document.getElementsByClassName("deleteUser")[0].addEventListener("click", function(){
						let id = document.getElementsByClassName("deleteUser")[0].getAttribute("data-id");

						var xhttp = ajax("ajax_users", "type=deleteUser&id="+id);

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

	if(typeof document.getElementsByClassName("addUser")[0] !== "undefined"){
		document.getElementsByClassName("addUser")[0].addEventListener("click", function(){
			let firstname = (typeof document.getElementsByClassName("firstname")[0] !== "undefined") ? document.getElementsByClassName("firstname")[0].value : '';
			let lastname = (typeof document.getElementsByClassName("lastname")[0] !== "undefined") ? document.getElementsByClassName("lastname")[0].value : '';
			let username = (typeof document.getElementsByClassName("username")[0] !== "undefined") ? document.getElementsByClassName("username")[0].value : '';
			let password = (typeof document.getElementsByClassName("password")[0] !== "undefined") ? document.getElementsByClassName("password")[0].value : '';
			let contact_email = (typeof document.getElementsByClassName("contact_email")[0] !== "undefined") ? document.getElementsByClassName("contact_email")[0].value : '';
			let contact_phone = (typeof document.getElementsByClassName("contact_phone")[0] !== "undefined") ? document.getElementsByClassName("contact_phone")[0].value : '';
			let user_type = (typeof document.querySelector("input[name='user_type']:checked") !== "undefined") ? document.querySelector("input[name='user_type']:checked").value : '';

			var companyCheckbox = document.getElementsByClassName("companyCheckbox");
			var permission_company = new Array();
			for(var i = 0; i < companyCheckbox.length; i++){
				if(companyCheckbox[i].checked){
					let v = companyCheckbox[i].value;
					permission_company.push(v);
				}
			}

			var buildingCheckbox = document.getElementsByClassName("buildingCheckbox");
			var permission_buldings = new Array();
			for(var i = 0; i < buildingCheckbox.length; i++){
				if(buildingCheckbox[i].checked){
					let v = buildingCheckbox[i].value;
					permission_buldings.push(v);
				}
			}

			var entranceCheckbox = document.getElementsByClassName("entranceCheckbox");
			var permission_entrance = new Array();
			for(var i = 0; i < entranceCheckbox.length; i++){
				if(entranceCheckbox[i].checked){
					let v = entranceCheckbox[i].value;
					permission_entrance.push(v);
				}
			}

			var floorCheckbox = document.getElementsByClassName("floorCheckbox");
			var permission_floor = new Array();
			for(var i = 0; i < floorCheckbox.length; i++){
				if(floorCheckbox[i].checked){
					let v = floorCheckbox[i].value;
					permission_floor.push(v);
				}
			}

			var roomCheckbox = document.getElementsByClassName("roomCheckbox");
			var permission_room = new Array();
			for(var i = 0; i < roomCheckbox.length; i++){
				if(roomCheckbox[i].checked){
					let v = roomCheckbox[i].value;
					permission_room.push(v);
				}
			}

			var own_company = new Array();
			var companies = document.getElementsByClassName("companiesOwned");
			for(var i = 0; i<companies.length; i++){
				if(companies[i].checked){
					own_company.push(companies[i].value);
				}
			}

			var xhttp = ajax("ajax_users", "type=addUser&firstname="+firstname+"&lastname="+lastname+"&username="+username+"&password="+password+"&contact_email="+contact_email+"&contact_phone="+contact_phone+"&user_type="+user_type+"&permission_company="+permission_company.join()+"&permission_buldings="+permission_buldings.join()+"&permission_entrance="+permission_entrance.join()+"&permission_floor="+permission_floor.join()+"&permission_room="+permission_room.join()+"&own_company="+own_company.join());

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
							location.href = "/"+Config.language+"/users/index";
						},1500);
					}

					document.getElementsByClassName("userFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
					window.scrollTo(0, 0);
				}
			};
		});
	}

	if(typeof document.getElementsByClassName("editUser")[0] !== "undefined"){
		document.getElementsByClassName("editUser")[0].addEventListener("click", function(){
			let editid = parseInt(document.getElementsByClassName("editUser")[0].getAttribute("data-editid"));
			let firstname = (typeof document.getElementsByClassName("firstname")[0] !== "undefined") ? document.getElementsByClassName("firstname")[0].value : '';
			let lastname = (typeof document.getElementsByClassName("lastname")[0] !== "undefined") ? document.getElementsByClassName("lastname")[0].value : '';
			let username = (typeof document.getElementsByClassName("username")[0] !== "undefined") ? document.getElementsByClassName("username")[0].value : '';
			let contact_email = (typeof document.getElementsByClassName("contact_email")[0] !== "undefined") ? document.getElementsByClassName("contact_email")[0].value : '';
			let contact_phone = (typeof document.getElementsByClassName("contact_phone")[0] !== "undefined") ? document.getElementsByClassName("contact_phone")[0].value : '';
			let user_type = (typeof document.querySelector("input[name='user_type']:checked") !== "undefined") ? document.querySelector("input[name='user_type']:checked").value : '';

			var companyCheckbox = document.getElementsByClassName("companyCheckbox");
			var permission_company = new Array();
			for(var i = 0; i < companyCheckbox.length; i++){
				if(companyCheckbox[i].checked){
					let v = companyCheckbox[i].value;
					permission_company.push(v);
				}
			}

			var buildingCheckbox = document.getElementsByClassName("buildingCheckbox");
			var permission_buldings = new Array();
			for(var i = 0; i < buildingCheckbox.length; i++){
				if(buildingCheckbox[i].checked){
					let v = buildingCheckbox[i].value;
					permission_buldings.push(v);
				}
			}

			var entranceCheckbox = document.getElementsByClassName("entranceCheckbox");
			var permission_entrance = new Array();
			for(var i = 0; i < entranceCheckbox.length; i++){
				if(entranceCheckbox[i].checked){
					let v = entranceCheckbox[i].value;
					permission_entrance.push(v);
				}
			}

			var floorCheckbox = document.getElementsByClassName("floorCheckbox");
			var permission_floor = new Array();
			for(var i = 0; i < floorCheckbox.length; i++){
				if(floorCheckbox[i].checked){
					let v = floorCheckbox[i].value;
					permission_floor.push(v);
				}
			}

			var roomCheckbox = document.getElementsByClassName("roomCheckbox");
			var permission_room = new Array();
			for(var i = 0; i < roomCheckbox.length; i++){
				if(roomCheckbox[i].checked){
					let v = roomCheckbox[i].value;
					permission_room.push(v);
				}
			}

			var own_company = new Array();
			var companies = document.getElementsByClassName("companiesOwned");
			for(var i = 0; i<companies.length; i++){
				if(companies[i].checked){
					own_company.push(companies[i].value);
				}
			}

			var xhttp = ajax("ajax_users", "type=editUser&editid="+editid+"&firstname="+firstname+"&lastname="+lastname+"&username="+username+"&contact_email="+contact_email+"&contact_phone="+contact_phone+"&user_type="+user_type+"&permission_company="+permission_company.join()+"&permission_buldings="+permission_buldings.join()+"&permission_entrance="+permission_entrance.join()+"&permission_floor="+permission_floor.join()+"&permission_room="+permission_room.join()+"&own_company="+own_company.join());

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
							location.href = "/"+Config.language+"/users/edit/"+editid;
						},1500);
					}

					document.getElementsByClassName("userFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
					window.scrollTo(0, 0);
				}
			};
		});
	}

	if(typeof document.getElementsByClassName("editUserPassword")[0] !== "undefined"){
		document.getElementsByClassName("editUserPassword")[0].addEventListener("click", function(){
			let editid = parseInt(document.getElementsByClassName("editUserPassword")[0].getAttribute("data-editid"));
			let newpassword = (typeof document.getElementsByClassName("newpassword")[0] !== "undefined") ? document.getElementsByClassName("newpassword")[0].value : '';
			
			var xhttp = ajax("ajax_users", "type=editUserPassword&editid="+editid+"&newpassword="+newpassword);

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
							location.href = "/"+Config.language+"/users/edit/"+editid;
						},1500);
					}

					document.getElementsByClassName("userFormPasswordMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
					window.scrollTo(0, 0);
				}
			};
		});
	}
})();