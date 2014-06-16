<?php

/**
 * A custom timestamp function
 * @param DateTime $timestamp The timestamp to work with
 * @param string $default This is shown when the date isn't set
 * @param string $format The date format. Defaults to d-m-Y
 * @return string
 */
if(!function_exists('timestamp'))
{
	function timestamp($timestamp, $default = null, $format = 'd-m-Y')
	{
		if(!is_null($timestamp))
		{
			return (new DateTime($timestamp, new DateTimeZone('Europe/Amsterdam')))->format($format);
		}

		return $default;
	}
}

/**
 * A custom array walking function, this returns an Laravel result object as a string
 * Optionally shows only one field
 * @param array $input The input array to split
 * @param mixed $field The field to optionally filter for
 * @param string $divider The divider between fields, can be anything you want
 * @return string
 */
if(!function_exists('print_array'))
{
	function print_array(array $input = array(), $field = null, $divider = ',')
	{
		$output = '';

		foreach($input as $single)
		{
			if(!is_null($field) && array_key_exists($field, $single))
			{
				$output .= $single[$field] . $divider . ' ';
			}
			else
			{
				$output .= $single . $divider . ' ';
			}
		}

		return rtrim(rtrim($output), $divider);
	}
}

/**
 * A custom wrapper around Laravel's Sesion::flash() method to create a custom message
 * @param string $message The message to set
 * @param string $type The type of message to set.
 * @return void
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */
if(!function_exists('flash'))
{
	function flash($message, $type = 'info')
	{
		$types = array('success', 'info', 'warning', 'danger');
		$type = in_array($type, $types) ? $type : 'info';

		Session::flash('message-type', $type);
		Session::flash('message', $message);
	}
}

/**
 * A simple function that prints a variable ($var) it it's set, otherwise it prints $message
 * @param string $var The variable to check and print it it's set
 * @param string $message The fallback message
 * @return string
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */
if(!function_exists('nill'))
{
	function nill($var, $message)
	{
		print isset($var) ? $var : $message;
	}
}

if(!function_exists('pr'))
{
	function pr($what)
	{
		return '<pre>' . print_r($what, true) . '</pre>';
	}
}