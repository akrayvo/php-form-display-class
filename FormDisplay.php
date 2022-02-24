<?php
/**
 * Class FormDisplay - static class to display from elements in HTML
 */

class FormDisplay
{
    /**
     * automatically add an "id" attribute with the same value as "name"
     * does not affect radio inputs because they can have 
     *      multiple elements with the same name
     * if set to false, id's can be by added with the $moreAttributeAr parameter
     * if set to true, id's can be by overridden with the $moreAttributeAr parameter
     */
    private $doAddIdAttributeFromName = false;

    /**
     * return the html elements as a string
     * if not set, output is written to the screen
     */
    private $doReturnHtml = false;

    /**
     * close tag elements, ex: <input type="input" name="name"  />
     *      vs <input type="input" name="name">
     * boolean attributes will have values, ex:
     *      <option value="1" selected="selected"> vs.
     *      <option value="1" "selected">
     */
    private $isXhtml = false;
    

    /**
     * determine whether to output or return the html based on the
     *      optional parameter and the default class value
     */
    private function htmlOutputOrReturn($html)
    {       
        if ($this->doReturnHtml) {
            return $html;
        }

        echo $html;
        return '';
    }

    public function htmlEscape($string)
    {
        return htmlspecialchars($string);
    }

    private function attributeArrayToString($attributes)
    {
        if (empty($attributes) || !is_array($attributes)) {
            return '';
        }

        $attributeString = '';
        foreach ($attributes as $name => $value) {
            if (is_int($name)) {
                $attributeString .= ' ' . $this->htmlEscape($value);
            } else {
                $attributeString .= ' ' .
                    $this->htmlEscape($name) . 
                    '="' .$this->htmlEscape($value) . '"';
            }
        }
        return $attributeString;
    }

    /**
     * finds if the "id" attribute should be automatically added
     * requirements:
     *      $doAddIdAttributeFromName must be true
     *      "name" attribute must be set
     *      "id" attribute must NOT be set
     *      "type" attribute must NOT be "radio". (radios will
     *          likely have multiple elements with the same name)
     */
    private function checkAddIdAttributeFromName($attributes)
    {
        if (!$this->doAddIdAttributeFromName) {
            // auto add id setting is off
            return false;
        }

        if (empty($attributes['name'])) {
            // name is not set
            return false;
        }

        if (!empty($attributes['id'])) {
            // id is already set
            return false;
        }

        if (!empty($attributes['type'])) {
            if ($attributes['type'] === 'radio') {
                return false;
            }
        }

        return true;
    }

    /**
     * combines the attributes created in this class with ones passed as parameters
     * adds the id attribute if needed
     */
    private function combineAttributes($mainAttributes, $moreAttributes = [])
    {
        $attributes = [];

        // attributes created in the class are first and can be overwritten
        if (is_array($mainAttributes)) {
            foreach ($mainAttributes as $name => $value) {
                if (is_int($name)) {
                    $attributes[] = $value;
                } else {
                    $name = trim(strtolower($name));
                    $attributes[$name] = $value;
                }
            }
        }

        // attributes passed as parameters are last and can overwrite values
        if (is_array($moreAttributes)) {
            foreach ($moreAttributes as $name => $value) {
                if (is_int($name)) {
                    $attributes[] = $value;
                } else {
                    $name = trim(strtolower($name));
                    $attributes[$name] = $value;
                }
            }
        }

        if ($this->checkAddIdAttributeFromName($attributes)) {
            $attributes['id'] = $attributes['name'];
        }

        return $attributes;
    }

    /**
     * start form <form>
     */
    public function formStart($action = '', $method = '', $moreAttributes = array())
    {
        $attributes = [];

        if (empty($action)) {
            // default action to the current script
            $action = $_SERVER['SCRIPT_NAME'];
        }
        $attributes['action'] = $action;
        
        // if the method is "get" or "g" then set the method to get. otherwise default to post.
        if (strtolower($method) === 'get') {
            $method = 'get';
        } else {
            $method = 'post';
        }
        $attributes['method'] = $method;

        $attributes = $this->combineAttributes($attributes, $moreAttributes);

        $html = '<form' . $this->attributeArrayToString($attributes) . '>';

        return $this->htmlOutputOrReturn($html);
    }

    /**
     * end form </form>
     */
    public function formEnd()
    {
        $html = '</form>';
        return $this->htmlOutputOrReturn($html);
    }

    /**
     * input elements <input type="text">, <input type="checkbox">, etc
     */
    private function input($type, $name, $value = '', $moreAttributes = [])
    {
        $attributes = [ 
            'type' => $type,
            'name' => $name,
            'value' => $value
        ];
        
        $attributes = $this->combineAttributes($attributes, $moreAttributes);

        $closingSlash = '';
        if (!empty($this->isXhtml)) {
            $closingSlash = ' /';
        }

        $html = '<input' . $this->attributeArrayToString($attributes) . $closingSlash. '>';

        return $this->htmlOutputOrReturn($html);
    }

    /**
     * text input <input type="hidden">
     */
    public function hidden($name, $value = '', $moreAttributes = [])
    {
        return $this->input('hidden', $name, $value, $moreAttributes);
    }

    /**
     * text input <input type="text">
     */
    public function text($name, $value = '', $moreAttributes = [])
    {
        return $this->input('text', $name, $value, $moreAttributes);
    }

    /**
     * text input <input type="search">
     */
    public function search($name, $value = '', $moreAttributes = [])
    {
        return $this->input('search', $name, $value, $moreAttributes);
    }

    /**
     * validate hex, 3 or 6 digit, with or without #
     */
    private function returnValidHex($hex)
    {
        if (empty($hex)) {
            return '';
        }

        $hex = strtolower( trim($hex, '#') );

        $length = strlen($hex);
        if ($length != 3 && $length != 6 ) {
            return '';
        }

        // only valid hex digits
        if (!ctype_xdigit($hex)) {
            return '';
        }

        if ($length == 3) {
            // 3 digit, repeat each. ex 48B becomes 4488BB
            $hex = str_repeat( substr($hex, 0, 1), 2) .
                str_repeat( substr($hex, 1, 1), 2) .
                str_repeat( substr($hex, 2, 1), 2);
        }

        return '#' . $hex;
    }

    /**
     * text input <input type="color">
     */
    public function color($name, $value = '', $moreAttributes = [])
    {
        $value = $this->returnValidHex($value);
        return $this->input('color', $name, $value, $moreAttributes);
    }

    /**
     * text input <input type="number">
     */
    public function number($name, $value = '', $moreAttributes = [])
    {
        if (is_string($value) && strlen($value) > 0) {
            $value = floatval($value);
        }
        return $this->input('number', $name, $value, $moreAttributes);
    }

    /**
     * range input <input type="range">
     */
    public function range($name, $min, $max, $value = '', $moreAttributes = [])
    {
        $min = intval($min);
        $max = intval($max);

        if (is_string($value) && strlen($value) > 0) {
            $value = intval($value);
        }
        return $this->input('range', $name, $value, $moreAttributes);
    }

    /**
     * text input <input type="number">
     */
    public function email($name, $value = '', $moreAttributes = [])
    {
        return $this->input('email', $name, $value, $moreAttributes);
    }

    /**
     * text input <input type="tel">
     */
    public function tel($name, $value = '', $moreAttributes = [])
    {
        return $this->input('tel', $name, $value, $moreAttributes);
    }
    
    /**
     * date input <input type="date">
     */
    public function date($name, $value = '', $moreAttributes = [])
    {
        if (empty($value)) {
            $value = '';
        } else {
            $unitTime = strtotime($value);
            if (empty($unitTime)) {
                $value = '';
            } else {
                $value = date('Y-m-d', $unitTime);
            }
        }
        return $this->input('date', $name, $value, $moreAttributes);
    }

    /**
     * password input <input type="password">
     * * unlike other functions, password has no $value
     */
    public function password($name, $moreAttributes = [])
    {
        return $this->input('password', $name, '', $moreAttributes);
    }

    /**
     * input checkbox <input type="checkbox">
     * * unlike other functions, has $isChecked parameter before $value
     */
    public function checkbox($name, $isChecked = false, $value = 1, $moreAttributes = [])
	{
        if (!empty($isChecked)) {
            if ($this->isXhtml) {
                $moreAttributes['checked'] = 'checked';
            } else {
                $moreAttributes[] = 'checked';
            } 
        }

        $moreAttributes = $this->combineAttributes($moreAttributes);

        $this->input('checkbox', $name, $value, $moreAttributes);
	}

    /**
     * input radio <input type="radio">
     * if $value is equal to $selectedValue, the radio button will be selected. this
     *      way, when radio buttons are added in a loop, this function takes care of
     *      the evalutions
     */
    public function radio($name, $value = 1, $selectedValue = '', $moreAttributes = [])
	{
        if (!empty($value) && !empty($selectedValue) && $value == $selectedValue) {
            if ($this->isXhtml) {
                $moreAttributes['checked'] = 'checked';
            } else {
                $moreAttributes[] = 'checked';
            }
        }

        $moreAttributes = $this->combineAttributes($moreAttributes);

        $this->input('radio', 'hobbies', $value, $moreAttributes);
	}

    /**
     * submit input <input type="submit">
     * * unlike other functions, the $value parameter is after $name
     */
    public function submit($value = '', $name = '',  $moreAttributes = [])
    {
        // set default name, button input data is rarely processed, so
        //      the name can often use the default value
        if (empty($name)) {
            $name = 'submitInputButton';
        }

        if (empty($value)) {
            $value = 'Submit';
        }

        $moreAttributes = $this->combineAttributes($moreAttributes);

        return $this->input('submit', $name, $value, $moreAttributes);
    }

    /**
     * submit input <input type="reset">
     * * unlike other functions, the $value parameter is after $name
     */
    public function reset($value = '', $name = '',  $moreAttributes = [])
    {
        // set default name, button input data is rarely processed, so
        //      the name can often use the default value
        if (empty($name)) {
            $name = 'submitInputReset';
        }

        if (empty($value)) {
            $value = 'Reset';
        }

        $moreAttributes = $this->combineAttributes($moreAttributes);

        return $this->input('reset', $name, $value, $moreAttributes);
    }

    public function textArea($name, $value='', $moreAttributes = [])
    {
        $attributes = [ 
            'name' => $name
        ];

        $attributes = $this->combineAttributes($attributes, $moreAttributes);

        $html = '<textarea' . $this->attributeArrayToString($attributes) . '>' . 
            $this->htmlEscape($value) . 
            '</textarea>';
        
        return $this->htmlOutputOrReturn($html);
    }

    public function button($html = 'Submit', $moreAttributes = [])
    {
        // note that html is not escaped. this will allow images
        $html = '<button' . $this->attributeArrayToString($moreAttributes) . '>' . 
            $html . 
            '</button>';

        return $this->htmlOutputOrReturn($html);    
    }

    private function selectOption($display, $value, $selectedValue)
	{
        $attributes = [ 
            'value' => $value
        ];
        
        if (!empty($value) && !empty($selectedValue) && $value == $selectedValue) {
            if ($this->isXhtml) {
                $attributes['selected'] = 'selected';
            } else {
                $attributes[] = 'selected';
            }
        }

        $html = '<option' . 
            $this->attributeArrayToString($attributes) . 
            '>' . 
            $this->htmlEscape($display) . 
            '</option>';

        return $html;
    }

    public function select($name, $options, $value = null, $moreAttributes = [])
	{
        $attributes = [ 
            'name' => $name
        ];

        $html = '<select' . $this->attributeArrayToString($attributes) . '>';

        foreach ($options as $optionValue => $display)
		{
            if (is_array($display)) {
                $html .= '<optgroup ' . 
                    $this->attributeArrayToString(['label' => $optionValue]) . 
                    '>';
                foreach ($display as $groupOptionValue => $groupOptionDisplay) {
                    $html .= $this->selectOption(
                        $groupOptionDisplay, 
                        $groupOptionValue, 
                        $value);
                }
                $html .= '</optgroup>';
            } else {
                $html .= $this->selectOption($display, $optionValue, $value);
            }
		}

        $html .= '</select>';

        return $this->htmlOutputOrReturn($html);
	}
}