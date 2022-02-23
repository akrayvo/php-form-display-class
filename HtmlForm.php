<?php

namespace HtmlForm;

/**
 * Class HtmlForm - static class to display from elements in HTML
 */
class HtmlForm
{
    /**
     * automatically add an "id" attribute with the same value as "name"
     * does not work with radio and checkbox inputs because they have 
     *      multiple elements with the same name
     * if set to false, id's can be by added with the $moreAttributeAr parameter
     * if set to true, id's can be by overridden with the $moreAttributeAr parameter
     */
    private static $isAutoIdAttribute = false;

    /**
     * close tag elements, ex: <input type="input" name="name"  />
     *      vs <input type="input" name="name">
     * boolean attributes will have values, ex:
     *      <option value="1" selected="selected"> vs.
     *      <option value="1" "selected">
     */
    private static $isXhtml = false;

    /**
     * default to returning html rather than outputting
     * can be overridden with functin parameter
     */
    private static $isForceReturnHtml = false;

    private static function setIsAutoIdAttribute($isAutoIdAttribute)
    {
        if (!empty($isAutoIdAttribute)) {
            self::$isAutoIdAttribute = true;
        }
        
        self::$isAutoIdAttribute = false;
    }

    private static function setIsXhtml($isXhtml)
    {
        if (!empty($isXhtml)) {
            self::$isXhtml = true;
        }
        
        self::$isXhtml = false;
    }

    private static function setIsForceReturnHtml($isForceReturnHtml)
    {
        if (!empty($isForceReturnHtml)) {
            self::$isForceReturnHtml = true;
        }
        
        self::$isForceReturnHtml = false;
    }

    private static function htmlEscape($str)
    {
        return htmlspecialchars($str);
    }

    private static function getAddAutoIdAttribue($ar)
    {
        if (empty(self::$isAutoIdAttribute)) {
            return false;
        }

        $nameKey = $idKey = $type = '';
        foreach ($ar as $key => $val) {
            $key = strtolower($key);
            if ($key == 'name') {
                $nameKey = $key;
            } elseif ($key == 'id') {
                $idKey = $key;
            } elseif ($key == 'type') {
                $type = $val;
            }
        }

        if (empty($nameKey)) {
            return false;
        }

        if (!empty($idKey)) {
            return false;
        }

        if ($type === 'checkbox' || $type === 'radio') {
            return false;
        }

        return true;
    }

    private static function attributeArrayToString($ar)
    {
        if (empty($ar) || !is_array($ar)) {
            return '';
        }

        if (self::getAddAutoIdAttribue($ar)) {
            $ar['id'] = $ar['name'];
        }

        $str = '';
        //$separator = '';
        foreach ($ar as $key => $val) {
            $str .= ' ' .
                self::htmlEscape($key) . '="' .
                self::htmlEscape($val) . '"';
            //$separator = ' ';
        }
        return $str;
    }

    /**
     * determine whether to output or return the html based on the
     *      optional parameter and the default class value
     */
    private static function htmlProcess($html, $isForceReturnHtml = null)
    {
        if (!is_null($isForceReturnHtml)) {
            if (!empty($isForceReturnHtml)) {
                return $html;
            }

            echo $html;
            return '';
        }
        
        if (self::$isForceReturnHtml) {
            return $html;
        }

        echo $html;
        return '';
    }

    /**
     * get html for element end slash if $isXhtml is set
     */
    private static function getCloseTagSlash()
    {
        if (!empty(self::$isXhtml)) {
            return ' /';
        }
        
        return '';
    }

    /**
     * start form <form>
     */
    public static function formStart($action = '', $method = '', $moreAttributeAr = array(), $isForceReturnHtml = null)
    {
        $attributeAr = [];

        // default action to the current script
        if (empty($action)) {
            $action = $_SERVER['SCRIPT_NAME'];
        }
        $attributeAr['action'] = $action;

        // if the method is "get" or "g" then set the method to get. otherwise default to post.
        if (strtolower($method) === 'get' || strtolower($method) === 'g') {
            $attributeAr['method'] = 'get';
        } else {
            $attributeAr['method'] = 'post';
        }

        $attributeAr = $attributeAr + $moreAttributeAr;

        $html = '<form' . self::attributeArrayToString($attributeAr) . '>';

        return self::htmlProcess($html, $isForceReturnHtml);
    }

    /**
     * end form </form>
     */
    public static function formEnd()
    {
        $html = '</form>';

        return self::htmlProcess($html);
    }

    /**
     * hidden input <input type="hidden" name="theName" value="theValue">
     */
    public static function hidden($name, $value = '', $moreAttributeAr = [], $isForceReturnHtml = null)
    {
        $attributeAr = [ 
            'type' => 'hidden',
            'name' => $name,
            'value' => $value
            ] + $moreAttributeAr;

        $html = '<input' . self::attributeArrayToString($attributeAr) . self::getCloseTagSlash(). '>';

        return self::htmlProcess($html, $isForceReturnHtml);
    }

    /**
     * hidden input <input type="text" name="theName" value="theValue">
     */
    public static function text($name, $value = '', $moreAttributeAr = [], $isForceReturnHtml = null)
    {
        $attributeAr = [ 
            'type' => 'text',
            'name' => $name,
            'value' => $value
            ] + $moreAttributeAr;

        $html = '<input' . self::attributeArrayToString($attributeAr) . self::getCloseTagSlash(). '>';

        return self::htmlProcess($html, $isForceReturnHtml);
    }

    public static function textArea($name, $value='', $moreAttributeAr = [], $isForceReturnHtml = null)
    {
        $attributeAr = [ 
            'name' => $name
            ] + $moreAttributeAr;

        $html = '<textarea'.self::attributeArrayToString($attributeAr).'>' . 
            self::htmlEscape($value) . 
            '</textarea>';
        
        return self::htmlProcess($html, $isForceReturnHtml);
    }

    public static function submit($name='submit', $value = 'Submit', $moreAttributeAr = [], $isForceReturnHtml = null)
    {
        $attributeAr = [ 
            'type' => 'submit',
            'name' => $name,
            'value' => $value
            ] + $moreAttributeAr;

        $html = '<input' . self::attributeArrayToString($attributeAr) . self::getCloseTagSlash(). '>';

        return self::htmlProcess($html, $isForceReturnHtml);
    }

    public static function button($html = 'Submit', $attributeAr = [], $isForceReturnHtml = null)
    {
        // note that html is not escaped. this will allow images
        $html = '<button'.self::attributeArrayToString($attributeAr).'>' . 
            $html . 
            '</button>';

        return self::htmlProcess($html, $isForceReturnHtml);    
    }
    
	public static function checkbox($name, $isSet = 0, $value = 1, $moreAttributeAr = [], $isForceReturnHtml = null)
	{
        $attributeAr = [ 
            'type' => 'checkbox',
            'name' => $name,
            'value' => $value
            ] + $moreAttributeAr;


        $checkedStr = '';
		if ($isSet) {
            if (self::$isXhtml) {
                $attributeAr['checked'] = 'checked';
            } else {
                $checkedStr = ' checked';
            }
		}

        $html = '<input' . self::attributeArrayToString($attributeAr) . $checkedStr . self::getCloseTagSlash(). '>';

        return self::htmlProcess($html, $isForceReturnHtml);
	}

    public static function radio($name, $value, $selectedValue = null, $moreAttributeAr = [], $isForceReturnHtml = null)
	{
        $attributeAr = [ 
            'type' => 'radio',
            'name' => $name,
            'value' => $value
            ] + $moreAttributeAr;


        $checkedStr = '';
		if ($selectedValue === $value) {
            if (self::$isXhtml) {
                $attributeAr['checked'] = 'checked';
            } else {
                $checkedStr = ' checked';
            }
		}

        $html = '<input' . self::attributeArrayToString($attributeAr) . $checkedStr . self::getCloseTagSlash(). '>';

        return self::htmlProcess($html, $isForceReturnHtml);
	}

    public static function dropdown($name, $options, $value = null, $moreAttributeAr = [], $isForceReturnHtml = null)
	{
        $attributeAr = [ 
            'type' => 'radio',
            'name' => $name,
            ] + $moreAttributeAr;

        $html = '<select' . self::attributeArrayToString($attributeAr) . '>';

        foreach ($options as $optionValue => $display)
		{
            $selectedStr = '';
            $optionAttributeAr = [ 'value' => $optionValue ];
			if (!empty($value) && !empty($optionValue) && $value == $optionValue) {
                if (self::$isXhtml) {
                    $optionAttributeAr['selected'] = 'selected';
                } else {
                    $selectedStr = ' selected';
                }
			}
			$html = $html . 
                '<option' . 
                self::attributeArrayToString($optionAttributeAr) . 
                $selectedStr . '>' . 
                self::htmlEscape($display) . 
                '</option>';
		}

        $html .= '</select>';

        return self::htmlProcess($html, $isForceReturnHtml);
	}
}