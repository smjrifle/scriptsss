<html>
<head>
	<title>Calculation</title>
</head>
<body>
	<div class="wrapper">
		<b>Paper size = 12X18 inches</b><br/>
		Enter the Size:<br/>
		<input type="text" placeholder="X-Size" id="x2" />
		<input type="text" placeholder="Y-Size" id="y2" />
		<input type="text" placeholder="Quantity" id="qty" />
		<button onclick="Calculate()">Calculate</button>
		<div id="output"></div>
	</div>
</body>
<script type="text/javascript">
	function Calculate() {
		var x1 = 12, y1 = 18, gap = 0.15;
		var fit_x1, fit_y1, fit_x2, fit_y2;
		var fit1 = 0, fit2 = 0;
		var x2 = parseFloat(document.getElementById('x2').value);
		var y2 = parseFloat(document.getElementById('y2').value);
		var qty = parseFloat(document.getElementById('qty').value);
		var output = document.getElementById('output');
		if((x2 > (x1 - 1) || y2 > (y1 - 1)) && (x2 > (y1 - 1) || y2 > (x1 - 1))) {
			output.innerHTML = "The size doesn't seem to fit in paper"
		}
		else {
			x2 = x2 + gap;
			y2 = y2 + gap;
			fit_x1 = parseInt((x1 - 1) / (x2) + gap);
			fit_y1 = parseInt((y1 - 1) / (y2) + gap);
			fit_x2 = parseInt((y1 - 1) / (x2) + gap);
			fit_y2 = parseInt((x1 - 1) / (y2) + gap);
			var extra1 = 0, extra2 = 0;
			var rem1 = 0, rem2 = 0;
			//Can fit more in remaining part in potrait mode?
			if(((fit_x1 * x2 + y2) <= x1 - 1)) {
				rem1 = x1 - (fit_x1 * x2);
				extra1 = parseInt((y1 - 1) / (x2));
				console.log("Potrait_X:" + extra1);
			}
			else if(((fit_y1 * y2 + x2) <= y1 - 1)) {
				rem1 = y1 - (fit_y1 * y2);
				extra1 = parseInt((x1 - 1) / (y2));
				console.log("Potrait_Y:" + extra1);
			}
			//Can fit more in remaining part in landscape mode?
			if(((fit_x2 * x2 + y2) <= y1 - 1)) {
				rem2 = y1 - (fit_x2 * x2);
				extra2 = parseInt((x1 - 1) / (x2));
				console.log("Landscape_X:" + extra2);
			}
			else if(((fit_y2 * y2 + x2) <= x1 - 1)) {
				rem = x1 - (fit_y2 * y2);
				extra2 = parseInt((y1 - 1) / (y2));
				console.log("Landscape_Y:" + extra2);
			}

			//Amount that fit in potrait mode
			if(fit_x1 >= 1 && fit_y1 >= 1) {
				fit1 = parseInt((fit_x1 * fit_y1));
			}
			//Amount that fit in landscape mode
			if(fit_x2 >= 1 && fit_y2 >= 1) {
				fit2 = parseInt((fit_x2 * fit_y2));
			}

			//Calculate amount of papers required in potrait mode
			var num1 = qty / (fit1 + extra1);
			if(num1 != parseInt(num1)) num1 = parseInt(num1) + 1;
			//Calculate amount of papers required in landscape mode
			var num2 = qty / (fit1 + extra1);
			if(num2 != parseInt(num2)) num2 = parseInt(num2) + 1;
			//Print both value including the extras
			output.innerHTML = "Potrait Fit: " + (fit1 + extra1) + " Landscape Fit: " + (fit2 + extra2);
			output.innerHTML = output.innerHTML + "<br/>With " + extra1 + " rotated in potrait mode, and " + extra2  + " rotated in landscape mode";
			output.innerHTML = output.innerHTML + "<br/>In potrait mode " + num1 + " papers are required and " + num2 + " in landscape mode";
		}
	}
</script>
</html>