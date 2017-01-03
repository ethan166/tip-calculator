<?php
	
	$percent_words = array("10%", "15%", "20%", "Custom:");
	$percentages = array(0.1, 0.15, 0.2, "custom");
	$wrongInput = false;
	$wrong_tip_input = false;
	$wrong_split_input = false;

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// accepting post requests
		$bill = $_POST["bill"];
		$tip_percent = $_POST["tip_percent"];
		$custom_tip = $_POST["custom"];
		$split_bill = $_POST["split_bill"];

		// checking input text number validation
		if($bill == "" OR !is_numeric($bill) OR $bill < 0) {
			$wrongInput = true;
		}

		if($tip_percent == "custom")
		{
			if($custom_tip == "" OR !is_numeric($custom_tip) OR $custom_tip <= 0 )
			{
				$wrong_tip_input = true;
			}
		}

		if(isset($split_bill))
		{
			if($split_bill == "" OR !is_numeric($split_bill) OR $split_bill <= 0) {
				$wrong_split_input = true;
			} 
		}

		// converting the percentages into decimals for custom tip
		if($tip_percent == "custom" && isset($custom_tip) && $wrong_tip_input == false)
		{
		     $calculated_custom_tip = $custom_tip / 100;

		}

		// tip calculation 
		if($wrongInput == false && $wrong_tip_input == false && $wrong_split_input == false)
		{	

			if(isset($calculated_custom_tip))
			{	
				$calculated_tip = $bill * $calculated_custom_tip;	
			} else {
				$calculated_tip = $bill * $tip_percent;	
			}	
		}

		
		// showing the output
		if(isset($calculated_tip)) {
			$total = $calculated_tip + $bill;

		$output ="";
		$output .= "Tip: $" . $calculated_tip ."\n";
		$output .= "Total: $" . $total;

		// splitting the tip and the total
		if(isset($split_bill) && $split_bill > 1 && $wrong_split_input == false)
		{
			$each_tip = $calculated_tip / $split_bill;
			$each_total = $total / $split_bill;
			$output .= "\nTip each: $ " . $each_tip;
			$output .= "\nTotal each: $" . $each_total;
		}
		
		}
		
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<style>
		body {
			font-family: Arial, Helvetica, sans-serif;
		}
		button[type=submit] {
			width: 70px;
		    margin: 12px 0;
		}
		.topbar {
			width:350px;
			height:30px;
			background-color: grey;
			text-align: center;
			padding-top:4px;
			
		}
		.topbar h5 {
			margin-top:5px;
		}
		.mybackground
		{
			background-color: #E3E86E;
			width:350px;
			text-align: center;
			padding-bottom: 5px;
		}
		.myborder {
		 border-style: solid;
		 background-color: white;
		 width:280px;
		 text-align: left;
		 margin:23px;
		 padding:10px;
		}
		.myborder h2 {
			font-family: Lobster;
			text-align: center;
		}
		.button_box {
			text-align: center;
			padding:5px;
		}
		.tip_output {
			width:240px;
			margin-left: 18px;
			margin-bottom: 10px;
			border-style:solid;
			border-width: 1px;
			color:#41B3F4;
			text-align: center;

		}
		input[type=text] {
			width: 80px;
		}

		.error_input
		{
			border-color:red;
			color:red;
		}
		
		
	</style>
<title>Tip Calculator</title>
</head>
<body>
<div class="mybackground">
	<div class="topbar"><h5>Tip Calculator</h5></div>
		<div class="mybackground">
			<div class="myborder">
			<h2>Tip Calculator</h2>
			<br>
				<!-- beginning of form -->
				<form method="post" action="index.php">
					<label  <?php if($wrongInput) echo "class='error_input'" ?> for="bill">Bill subtotal $:</label>
					<input  <?php if($wrongInput) echo "class='error_input'" ?> type="text" id="bill" name="bill" value=<?php if (isset($bill)) echo $bill;?> >
					
					<br><br>
					<label <?php if($wrong_tip_input) echo "class='error_input'" ?> for="tip_percent">Tip percentage : </label><br>
					<?php for($i = 0; $i < 4; $i++) { ?>
					 	<label <?php if($wrong_tip_input) echo "class='error_input'" ?> ><br><input <?php if($wrong_tip_input) echo "class='error_input'" ?> type="radio" name="tip_percent" <?php if (isset($tip_percent) && $tip_percent==$percentages[$i]) { echo "checked"; } ?> value=<?php echo $percentages[$i]; ?> />
						 
						<?php if($i == 3) { ?>
					 	  <label <?php if($wrong_tip_input) echo "class='error_input'" ?> for='custom'><?php  echo $percent_words[$i];  ?>
					 	  <input <?php if($wrong_tip_input) echo "class='error_input'" ?> type='text' id='custom' name='custom' value=<?php if (isset($custom_tip)) echo $custom_tip; ?> > % </label>
					 	
					 	<?php  } else { 
					 		echo $percent_words[$i];
					      } ?>  
					</label>
					<?php } ?>
					<br><br>
					<label <?php if($wrong_split_input) echo "class='error_input'" ?> for="split_bill">Split: <input type='text' name="split_bill" value=<?php if (isset($split_bill)) echo $split_bill; else echo "1"; ?> > person(s)</label>

					<div class="button_box"><button type="submit" />Submit</button></div>	
				</form>
				<!-- end of form -->

				<!-- output div -->
				<?php if(isset($calculated_tip)) { ?>
				<div class="tip_output"> <pre><?php if (isset($output)) {echo $output;} ?></pre></div>
				<?php } ?>
			</div>
		</div>
</div>
</body>
</html>


