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

	if(typeof document.getElementsByClassName("editEntrance")[0] !== "undefined"){
		document.getElementsByClassName("editEntrance")[0].addEventListener("click", function(){
			let editid = parseInt(document.getElementsByClassName("editEntrance")[0].getAttribute("data-editid"));
			let building = parseInt(document.getElementsByClassName("editEntrance")[0].getAttribute("data-building"));
			let title = (typeof document.getElementsByClassName("title")[0] !== "undefined") ? document.getElementsByClassName("title")[0].value : '';
			
			var xhttp = ajax("ajax_entrance", "type=editEntrance&editid="+editid+"&title="+title+"&building="+building);

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
							location.href = "/"+Config.language+"/entrance/edit/"+building+"/"+editid;
						},1500);
					}

					document.getElementsByClassName("entranceFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
					window.scrollTo(0, 0);
				}
			};
		});
	}

	if(typeof document.getElementsByClassName("removeEntrance") !== "undefined"){
		var removeEntrance = document.getElementsByClassName("removeEntrance");
		for(var i = 0; i < removeEntrance.length; i++){
			removeEntrance[i].addEventListener("click", function(){
				let modalTitle = this.getAttribute("data-modalTitle");
				let modalBody = this.getAttribute("data-modalBody");
				let yesText = this.getAttribute("data-yesText");
				let noText = this.getAttribute("data-noText");
				let id = this.getAttribute("data-id");

				var modalFooter = "<button type=\"button\" class=\"btn btn-primary btn-round deleteEntrance\" data-id=\""+id+"\">"+yesText+"</button>";
			    modalFooter += "<button type=\"button\" class=\"btn btn-secondary btn-round\" data-dismiss=\"modal\">"+noText+"</button>";
			      
				bootModal(modalTitle, modalBody, modalFooter);


				if(typeof document.getElementsByClassName("deleteEntrance")[0] !== "undefined"){
					document.getElementsByClassName("deleteEntrance")[0].addEventListener("click", function(){
						let id = document.getElementsByClassName("deleteEntrance")[0].getAttribute("data-id");

						var xhttp = ajax("ajax_entrance", "type=deleteEntrance&id="+id);

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

	if(typeof document.getElementsByClassName("addEntrance")[0] !== "undefined"){
		document.getElementsByClassName("addEntrance")[0].addEventListener("click", function(){
			let title = (typeof document.getElementsByClassName("title")[0] !== "undefined") ? document.getElementsByClassName("title")[0].value : '';
			let building = document.getElementsByClassName("addEntrance")[0].getAttribute("data-building");
			
			var xhttp = ajax("ajax_entrance", "type=addEntrance&title="+title+"&building="+building);

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
							location.href = "/"+Config.language+"/entrance/index/"+building;
						},1500);
					}

					document.getElementsByClassName("entranceFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
				}
			};
		});
	}

})();