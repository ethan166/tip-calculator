<?php
	$percent_words = array("10%", "15%", "20%");
	$percentages = array(0.1, 0.15, 0.2);
	$wrongInput = false;
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$bill = $_POST["bill"];
		$tip_percent = $_POST["tip_percent"];
		if($bill == "" OR !is_numeric($bill) OR $bill < 0) {
			$wrongInput = true;
		}

		if($wrongInput == false)
		{
			$calculated_tip = $bill * $tip_percent;
		}

		if(isset($calculated_tip)) {
			$total = $calculated_tip + $bill;

		$output ="";
		$output .= "Tip: $" . $calculated_tip ."\n";
		$output .= "Total: $" . $total;
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
		input[type=submit] {
			width: 80px;
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
		#input_field {
			width: 70px;
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
				<form method="post" action="index.php">
					<label  <?php if($wrongInput) echo "style='color:red'" ?> for="bill">Bill subtotal $:</label>
					<input id="input_field" <?php if($wrongInput) echo "style='border-color:red'" ?> type="text" id="bill" name="bill" value=<?php if (isset($bill)) echo $bill;?> >
					
					<br><br>
					<label for="tip_percent">Tip percentage : </label><br>
					<br>
					<?php for($i = 0; $i < 3; $i++) { ?>
					 <input type="radio" name="tip_percent" <?php if (isset($tip_percent) && $tip_percent==$percentages[$i]) { echo "checked"; } ?> value=<?php echo $percentages[$i]; ?> />
					 <?php echo $percent_words[$i]; ?>
					<?php } ?>

					<div class="button_box"><input type="submit" value="Submit" /></div>	
				
				<?php if(isset($calculated_tip)) { ?>
				<div class="tip_output"> <pre><?php if (isset($output)) {echo $output;} ?></pre></div>
				<?php } ?>
			</div>
		</div>
</div>
</body>
</html>


