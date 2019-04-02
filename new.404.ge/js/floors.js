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

	if(typeof document.getElementsByClassName("addFloor")[0] !== "undefined"){
		document.getElementsByClassName("addFloor")[0].addEventListener("click", function(){
			let title = (typeof document.getElementsByClassName("title")[0] !== "undefined") ? document.getElementsByClassName("title")[0].value : '';
			let building_id = parseInt(document.getElementsByClassName("addFloor")[0].getAttribute("data-building"));
			let entrance_id = parseInt(document.getElementsByClassName("addFloor")[0].getAttribute("data-entrance"));
			
			var xhttp = ajax("ajax_floors", "type=addFloor&title="+title+"&building_id="+building_id+"&entrance_id="+entrance_id);

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
							location.href = "/"+Config.language+"/floors/index/"+building_id+"/"+entrance_id;
						},1500);
					}

					document.getElementsByClassName("floorFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
				}
			};
		});
	}

	if(typeof document.getElementsByClassName("editFloor")[0] !== "undefined"){
		document.getElementsByClassName("editFloor")[0].addEventListener("click", function(){
			let editid = parseInt(document.getElementsByClassName("editFloor")[0].getAttribute("data-editid"));
			let building_id = parseInt(document.getElementsByClassName("editFloor")[0].getAttribute("data-building"));
			let entrance_id = parseInt(document.getElementsByClassName("editFloor")[0].getAttribute("data-entrance"));
			let title = (typeof document.getElementsByClassName("title")[0] !== "undefined") ? document.getElementsByClassName("title")[0].value : '';
			
			var xhttp = ajax("ajax_floors", "type=editFloor&editid="+editid+"&title="+title+"&building_id="+building_id+"&entrance_id="+entrance_id);

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
							location.href = "/"+Config.language+"/floors/edit/"+building_id+"/"+entrance_id+"/"+editid;
						},1500);
					}

					document.getElementsByClassName("floorFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
					window.scrollTo(0, 0);
				}
			};
		});
	}

	if(typeof document.getElementsByClassName("removeFloor") !== "undefined"){
		var removeFloor = document.getElementsByClassName("removeFloor");
		for(var i = 0; i < removeFloor.length; i++){
			removeFloor[i].addEventListener("click", function(){
				let modalTitle = this.getAttribute("data-modalTitle");
				let modalBody = this.getAttribute("data-modalBody");
				let yesText = this.getAttribute("data-yesText");
				let noText = this.getAttribute("data-noText");
				let id = this.getAttribute("data-id");

				var modalFooter = "<button type=\"button\" class=\"btn btn-primary btn-round deleteFloor\" data-id=\""+id+"\">"+yesText+"</button>";
			    modalFooter += "<button type=\"button\" class=\"btn btn-secondary btn-round\" data-dismiss=\"modal\">"+noText+"</button>";
			      
				bootModal(modalTitle, modalBody, modalFooter);


				if(typeof document.getElementsByClassName("deleteFloor")[0] !== "undefined"){
					document.getElementsByClassName("deleteFloor")[0].addEventListener("click", function(){
						let id = document.getElementsByClassName("deleteFloor")[0].getAttribute("data-id");

						var xhttp = ajax("ajax_floors", "type=deleteFloor&id="+id);

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
	}

})();