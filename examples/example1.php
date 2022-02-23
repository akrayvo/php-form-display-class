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
		<?php
		if (!empty($_POST)) {
			echo '<pre>';
			var_dump($POST);
			echo '</pre>';
		}
		if (!empty($_GET)) {
			echo '<pre>';
			var_dump($_GET);
			echo '</pre>';
		}
		?>
        <?php $form->formStart(null, 'get', ['name'=>'myform']); ?>
		<?php $form->hidden('hiddenvar', 'hiddenval'); ?>
		<?php $form->text('textvar', 'textval'); ?><br /><br />
		<?php $form->textArea('tavar', 'taval'); ?><br /><br />
		<?php $form->submit(); ?><br /><br />
		<?php $form->reset(); ?><br /><br />
        <?php $form->formEnd(); ?>
	</body>
</html>