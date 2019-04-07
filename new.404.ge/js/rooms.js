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

var bootModal = (modalTitle, modalBody) => {
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
   	out += "</div>";
  	out += "</div>";
	out += "</div>";
	$("body").append(out);
	$(".modal").modal("show");
};
var filesCount = 1;

(function(){
	
	if(typeof document.getElementsByClassName("photo_upload")[0] !== "undefined"){
		document.getElementsByClassName("photo_upload")[0].addEventListener("click", function(){
			
			if(document.getElementsByClassName("files") !== "undefined"){
				document.getElementsByClassName("files")[0].click();

				document.getElementsByClassName("files")[0].addEventListener("change", function(e){
					filesCount++;
					document.getElementsByClassName("files")[0].classList.add("filed");
					document.getElementsByClassName("files")[0].classList.remove("files");
					
					var reader = new FileReader();
    				reader.onload = function(ex) {
    					var image = document.createElement('img');
    					image.src = ex.target.result;
    					image.style.cssText = "max-height: 90px";

    					var col = document.createElement("div");
    					var italic = document.createElement("i");
    					var span = document.createElement("span");
    					//filesCount
    					italic.className = "fa fa-window-close times";
    					italic.setAttribute("data-cls", "f"+filesCount);

    					italic.addEventListener("click",function(){
    						let clName = this.getAttribute("data-cls");
    						document.getElementsByClassName(clName)[0].value = "";
    						this.parentNode.remove();    						
    					});
    					
    					col.className = "col-md-2 f"+filesCount;
    					col.style.cssText ="margin-bottom:5px;";
    					
    					span.className = "photo_upload";
    					
    					col.appendChild(span);
    					col.appendChild(italic);
    					span.appendChild(image);

    					document.querySelector(".filex_photos .row").appendChild(col);
				    };

				    reader.readAsDataURL(this.files[0]);

					var input = document.createElement('input');
					input.type = "file";
					input.name = "files[]";
					input.className = "form-control files f"+filesCount;
					input.style.cssText = "height: 1px;";
					document.getElementsByClassName("filex_box")[0].appendChild(input);
				});
			};
		});
	};

	if(typeof document.getElementsByClassName("editRoom")[0] !== "undefined"){
		document.getElementsByClassName("editRoom")[0].addEventListener("click", function(){
			let editid = parseInt(document.getElementsByClassName("editRoom")[0].getAttribute("data-editid"));
			let building_id = parseInt(document.getElementsByClassName("editRoom")[0].getAttribute("data-building"));
			let entrance_id = parseInt(document.getElementsByClassName("editRoom")[0].getAttribute("data-entrance"));
			let floor_id = parseInt(document.getElementsByClassName("editRoom")[0].getAttribute("data-floor"));
			let title = (typeof document.getElementsByClassName("title")[0] !== "undefined") ? document.getElementsByClassName("title")[0].value : '';
			let rooms = (typeof document.getElementsByClassName("rooms")[0] !== "undefined") ? document.getElementsByClassName("rooms")[0].value : '';
			let bedroom = (typeof document.getElementsByClassName("bedroom")[0] !== "undefined") ? document.getElementsByClassName("bedroom")[0].value : '';
			let bathrooms = (typeof document.getElementsByClassName("bathrooms")[0] !== "undefined") ? document.getElementsByClassName("bathrooms")[0].value : '';
			let square = (typeof document.getElementsByClassName("square")[0] !== "undefined") ? document.getElementsByClassName("square")[0].value : '';
			let ceil_height = (typeof document.getElementsByClassName("ceil_height")[0] !== "undefined") ? document.getElementsByClassName("ceil_height")[0].value : '';

			let additional_info = (typeof document.getElementsByClassName("additional_info") !== "undefined") ? document.getElementsByClassName("additional_info") : [{}];
			let addInfo = new Array();
			for(var i = 0; i<additional_info.length; i++){
				if(additional_info[i].checked){
					var cols = additional_info[i].getAttribute("data-column");
					addInfo.push(cols);
				}
			}

			let description = (typeof document.getElementsByClassName("description")[0] !== "undefined") ? document.getElementsByClassName("description")[0].value : '';

			let data = 'type=editRoom';
			data += '&building_id='+building_id;
			data += '&entrance_id='+entrance_id;
			data += '&floor_id='+floor_id;
			data += '&title='+title;
			data += '&rooms='+rooms;
			data += '&bedroom='+bedroom;
			data += '&bathrooms='+bathrooms;
			data += '&square='+square;
			data += '&ceil_height='+ceil_height;
			data += '&addInfo='+addInfo.join();
			data += '&description='+description;
			data += '&id='+editid;

			var xhttp = ajax("ajax_rooms", data);

			xhttp.onreadystatechange = function() {
				if (this.readyState == 4) {
					var out = {
						status: this.status,
						response: JSON.parse(this.responseText)
					};
					
					var className = "danger";
					if(out.status==200){
						className = "success";
						var input = document.createElement("input");
						input.type = "hidden";
						input.name = "insertedId";
						input.value = out.response.insertedId;
						document.getElementById("roomsForm").appendChild(input);
						document.getElementById("roomsForm").submit();			
					}

					document.getElementsByClassName("roomFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
					window.scrollTo(0, 0);
				}
			};
		});
	};

	if(typeof document.getElementsByClassName("addRoom")[0] !== "undefined"){
		document.getElementsByClassName("addRoom")[0].addEventListener("click", function(){
			let building_id = parseInt(document.getElementsByClassName("addRoom")[0].getAttribute("data-building"));
			let entrance_id = parseInt(document.getElementsByClassName("addRoom")[0].getAttribute("data-entrance"));
			let floor_id = parseInt(document.getElementsByClassName("addRoom")[0].getAttribute("data-floor"));
			let title = (typeof document.getElementsByClassName("title")[0] !== "undefined") ? document.getElementsByClassName("title")[0].value : '';
			let rooms = (typeof document.getElementsByClassName("rooms")[0] !== "undefined") ? document.getElementsByClassName("rooms")[0].value : '';
			let bedroom = (typeof document.getElementsByClassName("bedroom")[0] !== "undefined") ? document.getElementsByClassName("bedroom")[0].value : '';
			let bathrooms = (typeof document.getElementsByClassName("bathrooms")[0] !== "undefined") ? document.getElementsByClassName("bathrooms")[0].value : '';
			let square = (typeof document.getElementsByClassName("square")[0] !== "undefined") ? document.getElementsByClassName("square")[0].value : '';
			let ceil_height = (typeof document.getElementsByClassName("ceil_height")[0] !== "undefined") ? document.getElementsByClassName("ceil_height")[0].value : '';

			let additional_info = (typeof document.getElementsByClassName("additional_info") !== "undefined") ? document.getElementsByClassName("additional_info") : [{}];
			let addInfo = new Array();
			for(var i = 0; i<additional_info.length; i++){
				if(additional_info[i].checked){
					var cols = additional_info[i].getAttribute("data-column");
					addInfo.push(cols);
				}
			}

			let description = (typeof document.getElementsByClassName("description")[0] !== "undefined") ? document.getElementsByClassName("description")[0].value : '';

			let data = 'type=addRoom';
			data += '&building_id='+building_id;
			data += '&entrance_id='+entrance_id;
			data += '&floor_id='+floor_id;
			data += '&title='+title;
			data += '&rooms='+rooms;
			data += '&bedroom='+bedroom;
			data += '&bathrooms='+bathrooms;
			data += '&square='+square;
			data += '&ceil_height='+ceil_height;
			data += '&addInfo='+addInfo.join();
			data += '&description='+description;

			var xhttp = ajax("ajax_rooms", data);

			xhttp.onreadystatechange = function() {
				if (this.readyState == 4) {
					var out = {
						status: this.status,
						response: JSON.parse(this.responseText)
					};
					
					var className = "danger";
					if(out.status==200){
						className = "success";
						var input = document.createElement("input");
						input.type = "hidden";
						input.name = "insertedId";
						input.value = out.response.insertedId;
						document.getElementById("roomsForm").appendChild(input);
						document.getElementById("roomsForm").submit();			
					}

					document.getElementsByClassName("roomFormMessageBox")[0].innerHTML = messageBox(className, out.status, out.response.message);
					window.scrollTo(0, 0);
				}
			};
		});
	};

	if(typeof document.getElementsByClassName("removePhoto")[0] !== "undefined"){
		var removePhoto = document.getElementsByClassName("removePhoto");

		for(var i = 0; i < removePhoto.length; i++){
			removePhoto[i].addEventListener("click", function(){
				var id = parseInt(this.getAttribute("data-id"));

				let data = 'type=removePhoto';
				data += '&id='+id;

				var xhttp = ajax("ajax_rooms", data);
				var that = this;
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4) {
						var out = {
							status: this.status,
							response: JSON.parse(this.responseText)
						};

						if(out.status==200){
							console.log("removed");		
							that.parentNode.remove();
						}else{
							bootModal("შეტყობინება", out.response.message);
						}
					}
				};				
			});
		}
	};

})();