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