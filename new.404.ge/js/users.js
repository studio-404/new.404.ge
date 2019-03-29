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

	document.getElementsByClassName("addUser")[0].addEventListener("click", function(){
		let firstname = (typeof document.getElementsByClassName("firstname")[0] !== "undefind") ? document.getElementsByClassName("firstname")[0].value : '';
		let lastname = (typeof document.getElementsByClassName("lastname")[0] !== "undefind") ? document.getElementsByClassName("lastname")[0].value : '';
		let username = (typeof document.getElementsByClassName("username")[0] !== "undefind") ? document.getElementsByClassName("username")[0].value : '';
		let password = (typeof document.getElementsByClassName("password")[0] !== "undefind") ? document.getElementsByClassName("password")[0].value : '';
		let contact_email = (typeof document.getElementsByClassName("contact_email")[0] !== "undefind") ? document.getElementsByClassName("contact_email")[0].value : '';
		let contact_phone = (typeof document.getElementsByClassName("contact_phone")[0] !== "undefind") ? document.getElementsByClassName("contact_phone")[0].value : '';
		let user_type = (typeof document.querySelector("input[name='user_type']:checked") !== "undefind") ? document.querySelector("input[name='user_type']:checked").value : '';

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


		var xhttp = ajax("ajax_users", "type=addUser&firstname="+firstname+"&lastname="+lastname+"&username="+username+"&password="+password+"&contact_email="+contact_email+"&contact_phone="+contact_phone+"&user_type="+user_type+"&permission_company="+permission_company.join()+"&permission_buldings="+permission_buldings.join()+"&permission_entrance="+permission_entrance.join()+"&permission_floor="+permission_floor.join()+"&permission_room="+permission_room.join());

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
			}
		};
	});

})();