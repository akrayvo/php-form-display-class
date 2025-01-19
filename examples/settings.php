<?php

// include the class file and create a new object.
require_once('../FormHelper.php');

$form = new FormDisplay();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>HTML Form Example - Basic</title>
    <link rel="stylesheet" href="./style.css?x=2">
    <style>
    .php-code {
        background-color: #DFF;
        display: block;
        padding: 4px 10px;
        color: #000;
        margin: 2px 0 6px 0;
        border-left: 4px solid #088;
        line-height: 20px;
        font-family: Courier New, Courier, Lucida Sans Typewriter, Lucida Typewriter, monospace;
    }

    .html-code {
        background-color: #FFD;
        display: block;
        padding: 4px 10px;
        color: #000;
        margin: 2px 0 6px 0;
        border-left: 4px solid #880;
        line-height: 20px;
        font-family: Courier New, Courier, Lucida Sans Typewriter, Lucida Typewriter, monospace;
    }

    .code-label {
        padding: 10px 0 2px 0;
        color: #444;
    }

    ul {
        list-style-position: inside;
        margin: 0 0 8px 0;
        padding: 0;
    }
    </style>
</head>

<body>
    <h1>HTML Form Example - Basic</h1>
    <div><a href="./">&laquo; back to All Examples</a></div><br><br>

    <?php 
    $form->formStart();
    ?>

    <!----------------------------------------------------
    setDoAddIdAttributeFromName()
    ----------------------------------------------------->

    <h2>setDoAddIdAttributeFromName()</h2>
    <ul>
        <li>automatically add an <b>id</b> attribute with the same value as <b>name</b></li>
        <li>does not affect <b>radio</b> inputs because they can have multiple elements with the same <b>name</b></li>
        <li>if set to <b>false</b>, <b>id</b> can be by added with the <b>$moreAttributes</b> parameter</li>
        <li>if set to <b>true</b>, <b>id</b> can be by overridden with the <b>$moreAttributes</b> parameter</li>
        <li>true or false (boolean); default = <b>false</b></li>
    </ul>

    <div class="text-label">doAddIdAttributeFromName is set to <b>true</b>. The id is automatically set to the same
        value as name (parameter 1).</div>
    <div><?php 
        $form->setDoAddIdAttributeFromName(true);
        $form->text("full_name_1", "", ["placeholder"=>"Full Name 1"]);
        // output: <input type="text" name="full_name_1" value="" placeholder="Full Name 1" id="full_name_1">
    ?></div>

    <div class="code-label">doAddIdAttributeFromName is still to <b>true</b>. But an id is passed through the
        $moreAttributes parameter, overwriting the automatic value.</div>
    <div><?php 
        $form->text("full_name_2", "", ["placeholder"=>"Full Name 2", "id"=>"name2"]);
        // output: <input type="text" name="full_name_2" value="" placeholder="Full Name 2" id="name2">
    ?></div>

    <div class="code-label">doAddIdAttributeFromName is set to <b>false</b>. id is not passed. no id attribute will be
        on the tag.</div>
    <div><?php
        $form->setDoAddIdAttributeFromName(false);
        $form->text("full_name_3", "", ["placeholder"=>"Full Name 3"]);
        // output: <input type="text" name="full_name_3" value="" placeholder="Full Name 3">
    ?></div>


    <br><br><br>


    <!----------------------------------------------------
    setDoReturnHtml()
    ----------------------------------------------------->

    <h2>setDoReturnHtml()</h2>
    <ul>
        <li>return the HTML elements as a string</li>
        <li>if not set, output is written to the screen</li>
        <li>true or false (boolean); default = <b>false</b></li>
    </ul>
    <div class="code-label">doReturnHtml is set to <b>true</b>. The HTML input field is returned rather than
        outputted. The PHP <b>echo</b> command must be used to output.</div>
    <div><?php 
        $form->setDoReturnHtml(true);
        $fieldHtml = $form->text("full_name_1", "", ["placeholder"=>"Full Name 1"]);
        echo $fieldHtml;
        // output: <input type="text" name="full_name_1" value="" placeholder="Full Name 1">
    ?></div>

    <div class="code-label">doReturnHtml is set to <b>false</b>. The HTML input is returned rather than output. No
        <b>echo</b> command is necessary.
    </div>
    <div><?php
        $form->setDoReturnHtml(false);
        $form->text("full_name_2", "", ["placeholder"=>"Full Name 2"]);
        // output: <input type="text" name="full_name_2" value="" placeholder="Full Name 2">
    ?></div>


    <br><br><br>


    <!----------------------------------------------------
    setIsXhtml()
    ----------------------------------------------------->

    <h2>setIsXhtml()</h2>
    <ul>
        <li>close tag elements, ex: <?php echo htmlentities('<input type="input" name="name" />'); ?> vs
            <?php echo htmlentities('<input type="input" name="name">'); ?>
        <li>boolean attributes will have values, ex:
            <?php echo htmlentities('<option value="1" selected="selected">'); ?> vs.
            <?php echo htmlentities('<option value="1" selected>'); ?></li>
            <li>true or false (boolean); default = <b>false</b></li>
    </ul>
    <div class="code-label">setIsXhtml is set to <b>true</b>. There is a forward slash in the end of the input tag and
        readonly has a value of "readonly".</div>
    <div><?php 
        $form->setIsXhtml(true);
        $form->text("full_name_1", "", ["placeholder"=>"Full Name 1", "readonly"]);
        // output: <input type="text" name="full_name_1" value="" placeholder="Full Name 1" readonly="readonly" />
    ?></div>

    <div class="code-label">setIsXhtml is set to <b>false</b>. There is no forward slash in the input tag and readonly
        has no value.</div>
    <div><?php
        $form->setIsXhtml(false);
        $fieldHtml = $form->text("full_name_2", "", ["placeholder"=>"Full Name 2", "readonly"]);
        // output: <input type="text" name="full_name_2" value="" placeholder="Full Name 2" readonly>
    ?></div>



    <br><br><br>


    <!----------------------------------------------------
    setDoPassedStringCleanup()
    ----------------------------------------------------->

    <h2>setDoPassedStringCleanup()</h2>
    <ul>
        <li>string cleanup of passed variables
        <li>removes HTML tags (strip_tags)</li>
        <li>strips whitespace from the beginning and end of a string (trim)</li>
        <li>used in `getPost()`, `getGet()`, and `getPassed()` functions</li>
        <li>true or false (boolean); default = b>true</b></li>
    </ul>

    <div><b>* submit the form to preview/test.</b></div>

    <div class="code-label">setDoPassedStringCleanup is set to <b>false</b>. Beginning whitespace, ending whitespace,
        and html tags will remain.</div>
    <div><?php
    $form->setDoPassedStringCleanup(false);
    $full_name_no_cleanup = $form->getPassed("full_name_no_cleanup");
    $form->text("full_name_no_cleanup", $full_name_no_cleanup, ["placeholder"=>"Full Name No Cleanup"]);
    // if input: " <b>Joe</b> <li>Smith</i> ", then output: <input type="text" name="full_name_no_cleanup" value=" &lt;b&gt;Joe&lt;/b&gt; &lt;li&gt;Smith&lt;/i&gt; " placeholder="Full Name No Cleanup">
    // * note that attribute values are HTML encoded in HTML code, the input box will display " <b>Joe</b> <li>Smith</i> " in the browser
    echo "<div>value=\"".htmlentities($full_name_no_cleanup)."\"</div>";
    ?></div>

    <div class="code-label">setDoPassedStringCleanup is set to <b>true</b>. Beginning whitespace, ending whitespace, and
        html tags will be removed.</div>
    <div><?php
    $form->setDoPassedStringCleanup(true);
    $full_name_cleanup = $form->getPassed("full_name_cleanup");
    $form->text("full_name_cleanup", $full_name_cleanup, ["placeholder"=>"Full Name Cleanup"]);
    
    // if input = " <b>Joe</b> <li>Smith</i> ", then output: <input type="text" name="full_name_cleanup" value="Joe Smith" placeholder="Full Name Cleanup">
    echo "<div>value=\"".htmlentities($full_name_cleanup)."\"</div>";
    ?></div>



    <br><br><br>



    <h2>setDoSelectOptionValueEqualsText()</h2>
    <ul>
        <li>when an array of data is passed for the options of a dropdown menu (select),
            this determines if the value for each option is the array item key or 
            the array item value (same as the display)</li>
        <li>if this is set, select option value and display text will both be set 
            to the options array item value. so [2=>'a', => 3=>'b'] will output
            <?php echo htmlentities('<option value="a">a</option><option value="b">b</option>'); ?></li>
        <li>if not set, select option value will be the array key and the display 
            text will be the array value. so [2=>'a', => 3=>'b'] will output
            <?php echo htmlentities('<option value="2">a</option><option value="3">b</option>'); ?></li>
        <li>true or false (boolean); default = <b>false</b></li>
    </ul>
    <?php
    // set data for both dropdown menus (select)
    $selectOptions = [''=>'-no answer-', 'day'=>'Daytime', 'night'=>'Nighttime'];
    ?>
    <div class="code-label">doSelectOptionValueEqualsText is set to <b>true</b>. Option values will be array item keys.</div>
    <div><?php 
        $form->setDoSelectOptionValueEqualsText(true);
        $form->select("time_of_day", $selectOptions, "");
        // output: <select name="time_of_day"><option value="-no answer-">-no answer-</option><option value="Daytime">Daytime</option><option value="Nighttime">Nighttime</option></select>
    ?></div>

    <div class="code-label">doSelectOptionValueEqualsText is set to <b>false</b>. Option values will be array item values (same as display).</div>
    <div><?php
        $form->setDoSelectOptionValueEqualsText(false);
        $form->select("time_of_day", $selectOptions, "");
        // output: <select name="time_of_day"><option value="">-no answer-</option><option value="day">Daytime</option><option value="night">Nighttime</option></select>
    ?></div>









    <br><br><br>

    <div><?php $form->submit('Submit the form'); ?></div>

    <?php $form->formEnd(); ?>

</body>

</html>