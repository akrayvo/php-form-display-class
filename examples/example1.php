<?php
require_once('../FormDisplay.php');
$form = new FormDisplay();
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>PHP Form Display Class Example 1</title>
    </head>
	<body>
        <h1>Html Form Example 1</h1>
        <?php $form->formStart(null, 'get1', ['name'=>'myform']); ?>
        <?php $form->formEnd(); ?>
	</body>
</html>