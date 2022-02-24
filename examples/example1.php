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

		$selectData = array(
			''=>'-- Select Option --',
			'movies'=>'Watching Movies',
			'tv'=>'Watching Television Shows',
			'music'=>'Listening To Music'
		);
		$checkboxData = array(
			'movies'=>'Watching Movies',
			'tv'=>'Watching Television Shows',
			'music'=>'Listening To Music'
		);
		?>
        <?php $form->formStart(null, 'get', ['name'=>'myform']); ?>
		<?php $form->hidden('hiddenvar', 'hiddenval'); ?>
		<?php $form->text('textvar', 'textval', ['readonly', 'style'=>'color:#080;']); ?><br /><br />
		<?php $form->color('colorvar', '0FF'); ?><br /><br />
		<?php $form->number('numbervar', '12.35bc'); ?><br /><br />
		<?php $form->password('numbervar'); ?><br /><br />
		<?php $form->date('datevar', 'jan 5, 2013'); ?><br /><br />
		<?php $form->email('emailvar', 'test@test.com'); ?><br /><br />
		<?php $form->tel('telvar', '123-456-7890'); ?><br /><br />
		<?php $form->search('searchvar', 'searchval'); ?><br /><br />
		<?php $form->textArea('tavar', 'taval'); ?><br /><br />
		<?php $form->select('hobby', $selectData, 'tv'); ?><br /><br />
		<?php 
		foreach ($checkboxData as $value => $display) {
			$isSelected = false;
			if ($value == 'tv') {
				$isSelected = true;
			}
			$form->checkbox($value, $isSelected, 1, ['id' => $value]);
			echo ' <label for="' . $value . '">' . $display . '</label><br />'; 
		}
		?><br /><br />

		<?php 
		foreach ($checkboxData as $value => $display) {
			$form->radio('hobbies', $value, 'music', ['id' => $value.'b']);
			echo ' <label for="' . $value . 'b">' . $display . '</label><br />'; 
		}
		?><br /><br />
		
		<?php $form->submit(); ?><br /><br />
		<?php $form->button(); ?><br /><br />
		<?php $form->reset(); ?><br /><br />
        <?php $form->formEnd(); ?>
	</body>
</html>