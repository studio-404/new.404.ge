<?php 

class Module_flat_view
{
	public $language;
	public $data;
	private $out = '';

	public function index()
	{	
		// $this->out .= print_r($this->data, true);
		
		$this->out .= "<div class=\"table-responsive table-upgrade\">";
		$this->out .= "<table class=\"table\">";
		$this->out .= "<thead>";
		$this->out .= "<tr>";
		$this->out .= "<th>მონაცემები</th>";
		$this->out .= "<th></th>";
		$this->out .= "</tr>";
		$this->out .= "</thead>";
		$this->out .= "<tbody>";
		
		$this->out .= "<tr>";
		$this->out .= "<td>ს.კ.</td>";
		$this->out .= sprintf("<td>%d</td>", $this->data["id"]);
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>დასახლება</td>";
		$this->out .= sprintf("<td>%s</td>", $this->data["title"]);
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>მშენებლობა</td>";
		$this->out .= sprintf("<td>%s</td>", $this->data["building_title"]);
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>სადარბაზო</td>";
		$this->out .= sprintf("<td>%s</td>", $this->data["entrance_title"]);
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>სართული</td>";
		$this->out .= sprintf("<td>%s</td>", $this->data["floor_title"]);
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>ოთახები</td>";
		$this->out .= sprintf("<td>%s</td>", $this->data["rooms"]);
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>საძინებელი</td>";
		$this->out .= sprintf("<td>%s</td>", $this->data["bedroom"]);
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>კვ.მ.</td>";
		$this->out .= sprintf("<td>%s</td>", $this->data["square"]);
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>ჭერის სიმაღლე</td>";
		$this->out .= sprintf("<td>%s</td>", $this->data["ceil_height"]);
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>ბუნებრივი გაზი</td>";
		$this->out .= ($this->data["natural_air"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>ცენტრალური გათბობა</td>";
		$this->out .= ($this->data["central_hitting"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>ტელევიზია</td>";
		$this->out .= ($this->data["tv_cable"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>ინტერნეტი</td>";
		$this->out .= ($this->data["internet"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>სარეცხი მანქანა</td>";
		$this->out .= ($this->data["washing_machine"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>ვერანდა</td>";
		$this->out .= ($this->data["verandah"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>ბალკონი</td>";
		$this->out .= ($this->data["balcony"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>ტელეფონი</td>";
		$this->out .= ($this->data["phone"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>ტელევიზორი</td>";
		$this->out .= ($this->data["tv"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>პარკინგი</td>";
		$this->out .= ($this->data["parking"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>რკინის კარი</td>";
		$this->out .= ($this->data["iron_door"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>სათავსო</td>";
		$this->out .= ($this->data["storeroom"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>სიგნალიზაცია</td>";
		$this->out .= ($this->data["alarms"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>ავეჯი</td>";
		$this->out .= ($this->data["furniture"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>მაცივარი</td>";
		$this->out .= ($this->data["fridge"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>ლიფტი</td>";
		$this->out .= ($this->data["elevator"]==1) ? "<td><i class=\"nc-icon nc-check-2 text-success\"></i></td>" : "<td><i class=\"nc-icon nc-simple-remove text-danger\"></i></td>";		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>სრული ღირებულება</td>";
		$this->out .= sprintf("<td>%s</td>", number_format($this->data["totalprice"], 2, ".", " "));		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>აღწერა</td>";
		$this->out .= sprintf("<td>%s</td>", $this->data["description"]);		
		$this->out .= "<tr>";

		$this->out .= "<tr>";
		$this->out .= "<td>სტატუსი</td>";
		$status = "";
		if($this->data["available_status"]=="internal_installment"){
			$status = "შიდა განვადება";
		}else if($this->data["available_status"]=="internal_installment"){
			$status = "შეძენილი";
		}

		$this->out .= sprintf("<td>%s</td>", $status);		
		$this->out .= "<tr>";

		$this->out .= "</tbody>";

		$this->out .= "</table>";
		$this->out .= "</div>";

		$db_photos = new Database("db_photos", array(
			"method"=>"selectByRoomId",
			"attach_id"=>$this->data["id"]
		));
		$photos = $db_photos->getter();
		
		$this->out .= "<div class=\"pictures_rooms row\" style=\"margin-bottom: 40px;\">";
		foreach ($photos as $v):
		$this->out .= "<div class=\"col-md-2\">";
		$this->out .= sprintf("<img src=\"%s\" width=\"%s\" />", $v["path"], "100%");
		$this->out .= "</div>";
		endforeach;
		$this->out .= "</div>";

		if($this->data["available_status"]=="internal_installment"){
			$this->out .= "<h4>განვადება</h4>";
			$this->out .= "<div class=\"table-responsive table-upgrade\">";

			$this->out .= "<table class=\"table\">";
			$this->out .= "<tbody>";
			$this->out .= "<tr>";
			$this->out .= "<td>ღირებულება</td>";
			$this->out .= sprintf("<td>%s</td>", number_format($this->data["totalprice"], 2, ".", " "));		
			$this->out .= "<tr>";

			$this->out .= "<tr>";
			$this->out .= "<td>წინასწარ გადახდილი თანხა</td>";
			$this->out .= sprintf("<td>%s</td>", number_format($this->data["pre_pay"], 2, ".", " "));
			$this->out .= "<tr>";

			$total_installment = (int)$this->data["totalprice"] - (int)$this->data["pre_pay"];
			$this->out .= "<td>სესხის ოდენობა</td>";
			$this->out .= sprintf("<td>%s</td>", number_format($total_installment, 2, ".", " "));
			$this->out .= "<tr>";

			$this->out .= "<td>თვეების რაოდენობა</td>";
			$this->out .= sprintf("<td>%s</td>", $this->data["installment_months"]);
			$this->out .= "<tr>";

			$this->out .= "<td>განვადების დაწყების თარიღი</td>";
			$this->out .= sprintf("<td>%s</td>", $this->data["paying_start_day"]);
			$this->out .= "<tr>";		
			$this->out .= "</tbody>";

			$this->out .= "</table>";
			$this->out .= "</div>";

			$this->out .= "<h4>გადახდის გრაფიკი</h4>";
			$this->out .= "<div class=\"table-responsive table-upgrade\">";

			$this->out .= "<table class=\"table\">";
			$this->out .= "<thead>";
			$this->out .= "<tr>";
			$this->out .= "<th class=\"text-left\">გადახდის თარიღი ( Y-m-d )</th>";
			$this->out .= "<th class=\"text-left\">გადასახადი თანხა</th>";
			$this->out .= "<th class=\"text-left\">დარჩენილი ძირი</th>";
			$this->out .= "<th class=\"text-left\">სტატუსი</th>";
			$this->out .= "</tr>";
			$this->out .= "</thead>";

			$this->out .= "<tbody class=\"installment_tbody\">";

			/*START*/
			$payed_months_array = explode(";", $this->data["payed_months"]);
			$payed = 0;		
			for ($i=1; $i <= (int)$this->data["installment_months"]; $i++):
				$date = new DateTime($this->data["paying_start_day"]);
				$modify = sprintf("+%d month", $i);
				$date->modify($modify);
				
				$monthPay = (int)$total_installment / (int)$this->data["installment_months"];
				$payed += $monthPay;
				$remaining = $total_installment - $payed;
				
				$payed_month = (in_array($date->format("Y-m-d"), $payed_months_array)) ? true : false;
				$this->out .= "<tr>";
				$this->out .= sprintf("<td class=\"text-left\">%s</td>", $date->format("Y-m-d"));
				$this->out .= sprintf("<td class=\"text-left\">%s</td>", number_format($monthPay, 2, ".", " "));
				$this->out .= sprintf("<td class=\"text-left\">%s</td>", number_format($remaining, 2, ".", " "));
				$this->out .= "<td class=\"text-left\">";
				
				if($payed_month){
					$this->out .= sprintf(
						"<btn class=\"btn btn-sm btn-outline-success btn-round btn-icon active\" data-status=\"on\" data-month=\"%s\">",
						$date->format("Y-m-d")
					);
					$this->out .= "<i class=\"fa fa-toggle-on\"></i>";
					$this->out .= "</btn>";
				}else{
					$this->out .= sprintf(
						"<btn class=\"btn btn-sm btn-outline-success btn-round btn-icon\" data-status=\"off\" data-month=\"%s\">",
						$date->format("Y-m-d")
					);
					$this->out .= "<i class=\"fa fa-toggle-off\"></i>";
					$this->out .= "</btn>";
				}
				$this->out .= "</td>";
				$this->out .= "</tr>";
			endfor;
			/*END*/

			$this->out .= "</tbody>";

			$this->out .= "</table>";
			$this->out .= "</div>";

		}



		return $this->out;
	}
}