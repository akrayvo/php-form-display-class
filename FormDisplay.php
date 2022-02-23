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
            $attributeString .= ' ' .
                $this->htmlEscape($name) . 
                '="' .$this->htmlEscape($value) . '"';
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
    private function combineAttributes($mainAttributes, $moreAttributes)
    {
        $attributes = [];

        // attributes created in the class are first and can be overwritten
        foreach ($mainAttributes as $name => $value) {
            $name = trim(strtolower($name));
            $attributes[$name] = $value;
        }

        // attributes passed as parameters are last and can overwrite values
        foreach ($moreAttributes as $name => $value) {
            $name = trim(strtolower($name));
            $attributes[$name] = $value;
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

        $html = '<form' . self::attributeArrayToString($attributes) . '>';

        return self::htmlOutputOrReturn($html);
    }

    /**
     * end form </form>
     */
    public function formEnd()
    {
        $html = '</form>';
        return self::htmlOutputOrReturn($html);
    }
}