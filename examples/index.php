
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>HTML Form Examples</title>
	<link rel="stylesheet" href="./style.css">

	<!-- optional javacript -->
	<script>
		function updateFormRating() {
			var form_rating = document.getElementById('form_rating').value;
			document.getElementById('from_rating_display').innerHTML = form_rating;
		}

		function toggleInfo() {
			var elems = document.getElementsByClassName('formInfo');
			for (var i = 0; i < elems.length; i++) {
				elems[i].classList.toggle('isHidden');
			}
		}
	</script>

</head>

<body>

	<h1>Examples</h1>

    <table>
        <tr>
            <td style="white-space:nowrap;"><a href="./basic.php">basic.php</a></td>
            <td>A simple of example of how to add form fields to a PHP form.</td>
        </tr>
        <tr>
            <td style="white-space:nowrap;"><a href="./all-fields.php">all-fields.php</a></td>
            <td>An example that shows all available HTML input types: hidden, text, color, number, range, email, tel (telephone), date,
                password, checkbox, radio (radio button), textarea (large input box), submit (form submit), button (form submit button),
                and reset (reset button)
		    </td>
        </tr>
		<tr>
            <td style="white-space:nowrap;"><a href="./settings.php">settings.php</a></td>
            <td>An example that shows all available HTML input types: hidden, text, color, number, range, email, tel (telephone), date,
                password, checkbox, radio (radio button), textarea (large input box), submit (form submit), button (form submit button),
                and reset (reset button)
		    </td>
        </tr>
</body>

</html>