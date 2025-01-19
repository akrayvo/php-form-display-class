<?php

// include the class file and create a new object.
require_once('../FormHelper.php');
$form = new FormDisplay();

// get the value passed to the page. check both $_POST and $_GET
$name = $form->getPassed('name');
$color = $form->getPassed('color');
$comments = $form->getPassed('comments');

// options for select (dropdown menu)
$colors = [
    '' => '- select a color -',
    'blue' => 'Blue',
    'green' => 'Green',
    'lightBlue' => 'Light Blue',
    'red' => 'Red'
];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>HTML Form Example - Basic</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <h1>HTML Form Example - Basic</h1>
    <div><a href="./">&laquo; back to All Examples</a></div><br><br>
    
    <?php $form->formStart(); ?>

        <div>Name</div>
        <?php $form->text('name', $name); ?><br><br>

        <div>Favorite Color</div>
        <?php $form->select('color', $colors, $color); ?><br><br>

        <div>Comments</div>
        <?php $form->textarea('comments', $comments); ?><br><br>

        <?php $form->submit('Save Info') ?>

    <?php $form->formEnd(); ?>

</body>

</html>
