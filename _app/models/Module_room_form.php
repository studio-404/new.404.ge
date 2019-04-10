<?php 

class Module_room_form
{
	public $type;
	public $language;
	public $building_id = 0;
	public $entrance_id = 0;
	public $floor_id = 0;
	public $editId = 0;
	public $out = '';

	public function __construct()
	{
		
	}

	private function input($label, $className, $value, $readonly = false, $cols = 6, $display = false)
	{
		$display = ($display) ? ' style="display:none"' : '';
		$out = sprintf("<div class=\"col-md-%d\"%s>", $cols, $display); 
		$out .= "<div class=\"form-group\">"; 
		$out .= sprintf("<label>%s</label>", $label); 
		$readonly = ($readonly) ? ' readonly="readonly"' : '';
		$out .= sprintf(
			"<input type=\"text\" class=\"form-control %s\" value=\"%s\" autocomplete=\"off\"%s />",
			$className,
			htmlentities($value),
			$readonly
		); 
		$out .= "</div>"; 
		$out .= "</div>"; 
		return $out;
	}

	private function checkbox($className, $checked, $name, $val = 1)
	{
		$out = "<div class=\"col-md-4\">";
		$out .= "<div class=\"form-check\">";
        $out .= "<label class=\"form-check-label\">";

        $checked = ($checked) ? 'checked="checked"' : '';
        $out .= sprintf("<input class=\"form-check-input additional_info\" data-column=\"%s\" type=\"checkbox\" %s value=\"%s\">", $className, $checked, $val);
        $out .= sprintf("%s <span class=\"form-check-sign\"></span>", $name);

        $out .= "</label>";
        $out .= "</div>";        
        $out .= "</div>";        

        return $out;
	}

	private function radio($radioName, $value, $text, $checked = false)
	{
		$out = "<div class=\"form-check-radio\">";
       	$out .= "<label class=\"form-check-label\">";
        
        $checked = ($checked) ? 'checked="checked"' : '';
        $out .= sprintf(
        	"<input class=\"form-check-input %s\" type=\"radio\" name=\"%s\" value=\"%s\" %s/> %s",
        	$radioName,
        	$radioName,
        	$value,
        	$checked,
        	$text
        );

        $out .= "<span class=\"form-check-sign\"></span>";
        $out .= "</label>";
        $out .= "</div>";

        return $out;
	}

	private function input_select($selectedName, $id, $list, $selected=0, $col=6)
	{
		$out = sprintf("<div class=\"col-md-%d\">", $col); 
		$out .= "<div class=\"form-group\">"; 
		$out .= sprintf("<label>%s</label>", $selectedName); 
		$out .= sprintf("<select class=\"form-control %s\" style=\"padding:0 10px\">", $id);
		foreach($list as $v):
		$selected_ = ($v["val"]==$selected) ? ' selected="selected"' : '';
		$out .= sprintf(
			"<option value=\"%s\"%s>%s</option>",
			$v["val"],
			$selected_,
			$v["title"]
		);
		endforeach;		
		$out .= "</select>";
		$out .= "</div>";
		$out .= "</div>";

		return $out;
	}

	public function index()
	{
		if($this->type=="edit"){
			$Database = new Database("db_room", array(
				"method"=>"selectRoomById",
				"building_id"=>$this->building_id,
				"entrance_id"=>$this->entrance_id,
				"floor_id"=>$this->floor_id,
				"id"=>$this->editId
			));
			$fetch = $Database->getter();

			$title = $fetch["title"];
			$rooms = $fetch["rooms"];
			$bedroom = $fetch["bedroom"];
			$bathrooms = $fetch["bathrooms"];
			$square = $fetch["square"];
			$ceil_height = $fetch["ceil_height"];

			$natural_air = $fetch["natural_air"];
			$central_hitting = $fetch["central_hitting"];
			$tv_cable = $fetch["tv_cable"];
			$internet = $fetch["internet"];
			$washing_machine = $fetch["washing_machine"];
			$verandah = $fetch["verandah"];
			$balcony = $fetch["balcony"];
			$phone = $fetch["phone"];
			$tv = $fetch["tv"];
			$parking = $fetch["parking"];
			$iron_door = $fetch["iron_door"];
			$storeroom = $fetch["storeroom"];
			$alarms = $fetch["alarms"];
			$furniture = $fetch["furniture"];
			$fridge = $fetch["fridge"];
			$elevator = $fetch["elevator"];
			$description = $fetch["description"];
			$totalprice = $fetch["totalprice"];
			$pre_pay = $fetch["pre_pay"];
			$paying_start_day = $fetch["paying_start_day"];
			$payed_months = $fetch["payed_months"];
			$installment_months = $fetch["installment_months"];
			$available_status = $fetch["available_status"];

			$db_photos = new Database("db_photos", array(
				"method"=>"selectByRoomId",
				"attach_id"=>$this->editId
			));
			$photos = $db_photos->getter();

			$submitText = "რედაქტირება";
			$submitClass = "editRoom";			
		}else{
			$title = "";
			$rooms = "";
			$bedroom = "";
			$bathrooms = "";
			$square = "";
			$ceil_height = "";
			
			$natural_air = 0;
			$central_hitting = 0;
			$tv_cable = 0;
			$internet = 0;
			$washing_machine = 0;
			$verandah = 0;
			$balcony = 0;
			$phone = 0;
			$tv = 0;
			$parking = 0;
			$iron_door = 0;
			$storeroom = 0;
			$alarms = 0;
			$furniture = 0;
			$fridge = 0;
			$elevator = 0;
			$description = "";
			$totalprice = 0;
			$pre_pay = 0;
			$installment_months = 0;
			$paying_start_day = date("Y-m-d");
			$payed_months = "";
			$available_status = "avaliable";
			$photos = false;
			$submitText = "დამატება";
			$submitClass = "addRoom";			
		}
		$this->out .= "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" id=\"roomsForm\">";
		$this->out .= "<div class=\"row\">";
		
		$this->out .= "<div class=\"col-md-12\">";
		$this->out .= "<div class=\"roomFormMessageBox\">";
		$this->out .= "</div>";
		$this->out .= "</div>";
		
		$this->out .= $this->input("დასახელება", "title", htmlentities($title), false, 12);
		$this->out .= $this->input("ოთახი", "rooms", htmlentities($rooms), false, 4);
		$this->out .= $this->input("საძინებელი", "bedroom", htmlentities($bedroom), false, 4);
		$this->out .= $this->input("სააბაზანო", "bathrooms", htmlentities($bathrooms), false, 4);
		$this->out .= $this->input("კვ.მ.", "square", htmlentities($square), false, 6);
		$this->out .= $this->input("ჭერის სიმაღლე", "ceil_height", htmlentities($ceil_height), false, 6);
		
		$this->out .= "<div class=\"col-md-12\" style=\"margin: 25px 0 0 0\">";
		$this->out .= "<div class=\"typography-line\"><h6>დამატებითი ინფორმაცია</h6></div>";
		$this->out .= "</div>";
		$this->out .= $this->checkbox("natural_air", $natural_air, "ბუნებრივი აირი", 1);
		$this->out .= $this->checkbox("central_hitting", $central_hitting, "ცენტრალური გათბობა", 1);
		$this->out .= $this->checkbox("tv_cable", $tv_cable, "ტელევიზია", 1);
		$this->out .= $this->checkbox("internet", $internet, "ინტერნეტი", 1);
		$this->out .= $this->checkbox("washing_machine", $washing_machine, "სარეცხი მანქანა", 1);
		$this->out .= $this->checkbox("verandah", $verandah, "ვერანდა", 1);
		$this->out .= $this->checkbox("balcony", $balcony, "აივანი", 1);
		$this->out .= $this->checkbox("phone", $phone, "ტელეფონი", 1);
		$this->out .= $this->checkbox("tv", $tv, "ტელევიზორი", 1);
		$this->out .= $this->checkbox("parking", $parking, "პარკინგი", 1);
		$this->out .= $this->checkbox("iron_door", $iron_door, "რკინის კარი", 1);
		$this->out .= $this->checkbox("storeroom", $storeroom, "სათავსო", 1);
		$this->out .= $this->checkbox("alarms", $alarms, "სიგნალიზაცია", 1);
		$this->out .= $this->checkbox("furniture", $furniture, "ავეჯი", 1);
		$this->out .= $this->checkbox("fridge", $fridge, "მაცივარი", 1);
		$this->out .= $this->checkbox("elevator", $elevator, "ლიფტი", 1);

				
		$this->out .= "<div class=\"col-md-12\" style=\"margin: 25px 0 0 0\">";
		$this->out .= "<div class=\"form-group\">"; 
		$this->out .= "<label>ფოტო (jpg, png, gif, jpeg) <5mb</label>"; 
		
		$this->out .= "<div class=\"filex_box\">"; 
		$this->out .= "<input type=\"file\" name=\"files[]\" class=\"form-control files\" value=\"\" style=\"height:1px\" />"; 
		$this->out .= "</div>";

		
		$this->out .= "<div class=\"filex_photos\">";
		$this->out .= "<div class=\"row\">";
		
		$this->out .= "<div class=\"col-md-2\"><span class=\"photo_upload\">ატვირთვა</span></div>"; 
		
		if(count($photos) && is_array($photos)){
			foreach($photos as $v):				
				$this->out .= "<div class=\"col-md-2\" style=\"margin-bottom: 5px;\">";
				$this->out .= "<span class=\"photo_upload\">";
				$this->out .= "<img src=\"/".$v["path"]."\" style=\"max-height: 90px;\">";
				$this->out .= "</span>";
				$this->out .= sprintf(
					"<i class=\"fa fa-window-close removePhoto\" data-id=\"%d\"></i>",
					$v["id"]
				);
				$this->out .= "</div>";
			endforeach;
		}

		$this->out .= "</div>";
		$this->out .= "</div>";

		

		$this->out .= "</div>";
		$this->out .= "</div>";

		$this->out .= "<div class=\"col-md-12\" style=\"margin: 10px 0 0 0\">";	
		$this->out .= "&nbsp;";
		$this->out .= "</div>";

		$this->out .= "<div class=\"col-md-12\">";
		$this->out .= "<div class=\"typography-line\"><h6>სტატუსი</h6></div>";
		$this->out .= "</div>";

		$this->out .= "<div class=\"col-md-3\">";
		$this->out .= $this->radio("choose_status", "avaliable", "ხელმისაწვდომი", ($available_status=="avaliable") ? true : false);
		$this->out .= "</div>";

		$this->out .= "<div class=\"col-md-3\">";
		$this->out .= $this->radio("choose_status", "sold", "გაყიდული", ($available_status=="sold") ? true : false);
		$this->out .= "</div>";

		$this->out .= "<div class=\"col-md-3\">";
		$this->out .= $this->radio("choose_status", "internal_installment", "შიდა განვადება", ($available_status=="internal_installment") ? true : false);
		$this->out .= "</div>";

		$this->out .= "<div class=\"col-md-3\">";
		$this->out .= $this->radio("choose_status", "bank_installment", "ბანკის განვადება", ($available_status=="bank_installment") ? true : false);
		$this->out .= "</div>";
		

		$this->out .= "<div class=\"col-md-12\" style=\"margin: 10px 0 0 0\">";	
		$this->out .= "&nbsp;";
		$this->out .= "</div>";


		$this->out .= $this->input("სრული ღირებულება", "totalprice", htmlentities($totalprice), false, ($available_status=="internal_installment" || $available_status=="bank_installment") ? 3 : 12);
		
		$this->out .= $this->input("გადახდილი თანხა", "pre_pay", htmlentities($pre_pay), false, 3, ($available_status=="internal_installment" || $available_status=="bank_installment") ? false : true);

		$this->out .= $this->input("გადახდის საწყისი თარიღი", "paying_start_day datepicker", htmlentities($paying_start_day), false, 3, ($available_status=="internal_installment" || $available_status=="bank_installment") ? false : true);

		$this->out .= $this->input("განვადების თვეების რაოდენობა", "installment_months", htmlentities($installment_months), false, 3, ($available_status=="internal_installment" || $available_status=="bank_installment") ? false : true);

		
		$installment_list_display = ($available_status=="internal_installment" || $available_status=="bank_installment") ? "block" : "none";
		$total_installment = (int)$totalprice - (int)$pre_pay;
		$payed_months_array = explode(";", $payed_months);

		/* instalment start */
		$this->out .= "<div class=\"col-md-12\" style=\"margin: 10px 0 0 0\">";	
		$this->out .= "<ul class=\"nav nav-tabs\" id=\"myTab\" role=\"tablist\">";
		
		$this->out .= "<li class=\"nav-item\">";
		$this->out .= "<a class=\"nav-link active\" id=\"home-tab\" data-toggle=\"tab\" href=\"#home\" role=\"tab\" aria-controls=\"home\" aria-selected=\"true\">სესხი</a>";
		$this->out .= "</li>";

		$this->out .= "<li class=\"nav-item\">";
		$this->out .= "<a class=\"nav-link\" id=\"graphic-tab\" data-toggle=\"tab\" href=\"#graphic\" role=\"tab\" aria-controls=\"graphic\" aria-selected=\"false\">გრაფიკი</a>";
		$this->out .= "</li>";
		$this->out .= "</ul>";
		
		$this->out .= "<div class=\"tab-content\" id=\"myTabContent\">";
		
		$this->out .= "<div class=\"tab-pane fade show active\" id=\"home\" role=\"tabpanel\" aria-labelledby=\"home-tab\">";
		$this->out .= "<div style=\"padding: 10px;\">";
		$this->out .= "<p><strong>სესხის ოდენობა:</strong> ".number_format((int)$total_installment, 2, ".", " ")."</p>";
		$this->out .= "</div>";
		$this->out .= "</div>";

		$this->out .= "<div class=\"tab-pane fade\" id=\"graphic\" role=\"tabpanel\" aria-labelledby=\"graphic-tab\">";
		$this->out .= $this->instalment(
			$installment_list_display,
			$total_installment,
			$installment_months,
			$paying_start_day,
			$payed_months_array
		);
		$this->out .= "</div>";
		$this->out .= "</div>";

		$this->out .= "</div>";				
		/* instalment end */
	
		$this->out .= "<div class=\"col-md-12\">";
		$this->out .= "<div class=\"form-group\">"; 
		$this->out .= "<label>აღწერა</label>"; 
		$this->out .= sprintf(
			"<textarea name=\"description\" class=\"form-control description\">%s</textarea>",
			$description
		); 
		$this->out .= "</div>";
		$this->out .= "</div>";		
		

		$this->out .= "<div class=\"col-md-12\">"; 
		$this->out .= "<div class=\"form-group\">"; 
		$this->out .= sprintf("<div class=\"update ml-auto mr-auto\">
                      <button type=\"button\" class=\"btn btn-primary btn-round %s\" data-editid=\"%d\" data-building=\"%d\" data-entrance=\"%d\" data-floor=\"%d\">%s</button>
                    </div>", $submitClass, (int)$this->editId, (int)$this->building_id, (int)$this->entrance_id, (int)$this->floor_id, $submitText);
		$this->out .= "</div>";		
		$this->out .= "</div>";

		$this->out .= "</div>";
		$this->out .= "</form>";		
		return $this->out;
	}

	private function instalment(
		$installment_list_display,
		$total_installment,
		$installment_months,
		$paying_start_day,
		$payed_months_array
	){
		$out = sprintf(
			"<div class=\"col-md-12\" style=\"display:%s; margin-top:20px;\">",
			$installment_list_display
		);
		$out .= "<div class=\"typography-line\">";
		$out .= "<h6>გადახდის გრაფიკი</h6>";
		$out .= "</div>";
		$out .= "</div>";

		$out .= sprintf(
			"<div class=\"col-md-12 installment_list\" style=\"display:%s\">",
			$installment_list_display
		);
		
		$out .= "<div class=\"card card-plain\">";
        
        $out .= "<div class=\"card-body\" style=\"border:solid 1px #f2f2f2;\">";
		$out .= "<div class=\"table-responsive\">";
		
		$out .= "<table class=\"table\">";

		$out .= "<thead class=\"text-primary\">";
		$out .= "<tr>";
		$out .= "<th class=\"text-left\">გადახდის თარიღი ( Y-m-d )</th>";
		$out .= "<th class=\"text-left\">გადასახადი თანხა</th>";
		$out .= "<th class=\"text-left\">დარჩენილი ძირი</th>";
		$out .= "<th class=\"text-left\">სტატუსი</th>";
		$out .= "</tr>";
		$out .= "</thead>";
		$out .= "<tbody class=\"installment_tbody\">";

		
		// $out .= "<tr>";
		// $out .= sprintf(
		// 	"<td colspan=\"4\" style=\"border-top:0px; padding-bottom:20px;\"><strong>სესხის ოდენობა:</strong> %s</td>",
		// 	number_format((int)$total_installment, 2, ".", " ")
		// );
		// $out .= "</tr>";
		
		$payed = 0;		
		for ($i=1; $i <= (int)$installment_months; $i++):
			$date = new DateTime($paying_start_day);
			$modify = sprintf("+%d month", $i);
			$date->modify($modify);
			
			$monthPay = (int)$total_installment / (int)$installment_months;
			$payed += $monthPay;
			$remaining = $total_installment - $payed;
			
			$payed_month = (in_array($date->format("Y-m-d"), $payed_months_array)) ? true : false;
			$out .= "<tr>";
			$out .= sprintf("<td class=\"text-left\">%s</td>", $date->format("Y-m-d"));
			$out .= sprintf("<td class=\"text-left\">%s</td>", number_format($monthPay, 2, ".", " "));
			$out .= sprintf("<td class=\"text-left\">%s</td>", number_format($remaining, 2, ".", " "));
			$out .= "<td class=\"text-left\">";
			
			if($payed_month){
				$out .= sprintf(
					"<btn class=\"btn btn-sm btn-outline-success btn-round btn-icon gchangepaystatus active\" data-status=\"on\" data-month=\"%s\">",
					$date->format("Y-m-d")
				);
				$out .= "<i class=\"fa fa-toggle-on\"></i>";
				$out .= "</btn>";
			}else{
				$out .= sprintf(
					"<btn class=\"btn btn-sm btn-outline-success btn-round btn-icon gchangepaystatus\" data-status=\"off\" data-month=\"%s\">",
					$date->format("Y-m-d")
				);
				$out .= "<i class=\"fa fa-toggle-off\"></i>";
				$out .= "</btn>";
			}
			$out .= "</td>";
			$out .= "</tr>";
		endfor;
		
		$out .= "</tbody>";
		$out .= "</table>";

		$out .= "</div>";
		$out .= "</div>";
		$out .= "</div>";

		$out .= "</div>";
		return $out;
	}
}