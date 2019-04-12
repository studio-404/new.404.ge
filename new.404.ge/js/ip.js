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
	if(typeof document.getElementsByClassName("addIP")[0] !== "undefined"){
		document.getElementsByClassName("addIP")[0].addEventListener("click", function(){
			let name = (typeof document.getElementsByClassName("name")[0] !== "undefined") ? document.getElementsByClassName("name")[0].value : '';
			let ip = (typeof document.getElementsByClassName("ip")[0] !== "undefined") ? document.getElementsByClassName("ip")[0].value : '';
			
			var xhttp = ajax("ajax_ip", "type=addIP&name="+name+"&ip="+ip);

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
							location.href = "/"+Config.language+"/ip/index";
						},1500);
					}

					document.getElementsByClassName("ipFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
					window.scrollTo(0, 0);
				}
			};
		});
	};

	if(typeof document.getElementsByClassName("removeIp") !== "undefined"){
		var removeIp = document.getElementsByClassName("removeIp");
		for(var i = 0; i < removeIp.length; i++){
			removeIp[i].addEventListener("click", function(){
				let modalTitle = this.getAttribute("data-modalTitle");
				let modalBody = this.getAttribute("data-modalBody");
				let yesText = this.getAttribute("data-yesText");
				let noText = this.getAttribute("data-noText");
				let id = this.getAttribute("data-id");

				var modalFooter = "<button type=\"button\" class=\"btn btn-primary btn-round deleteIP\" data-id=\""+id+"\">"+yesText+"</button>";
			    modalFooter += "<button type=\"button\" class=\"btn btn-secondary btn-round\" data-dismiss=\"modal\">"+noText+"</button>";
			      
				bootModal(modalTitle, modalBody, modalFooter);


				if(typeof document.getElementsByClassName("deleteIP")[0] !== "undefined"){
					document.getElementsByClassName("deleteIP")[0].addEventListener("click", function(){
						let id = document.getElementsByClassName("deleteIP")[0].getAttribute("data-id");

						var xhttp = ajax("ajax_ip", "type=deleteIP&id="+id);

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

	if(typeof document.getElementsByClassName("editIP")[0] !== "undefined"){
		document.getElementsByClassName("editIP")[0].addEventListener("click", function(){
			let editid = parseInt(document.getElementsByClassName("editIP")[0].getAttribute("data-editid"));
			let name = (typeof document.getElementsByClassName("name")[0] !== "undefined") ? document.getElementsByClassName("name")[0].value : '';
			let ip = (typeof document.getElementsByClassName("ip")[0] !== "undefined") ? document.getElementsByClassName("ip")[0].value : '';
			
			var xhttp = ajax("ajax_ip", "type=editIP&editid="+editid+"&name="+name+"&ip="+ip);

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
							location.href = "/"+Config.language+"/ip/edit/"+editid;
						},1500);
					}

					document.getElementsByClassName("ipFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
					window.scrollTo(0, 0);
				}
			};
		});
	}

})();