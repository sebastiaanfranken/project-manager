#Projectplanner

This is my custom projectplanner built on top of Laravel 4. It'st still _work in progress_

##Custom functions

`nill( $var, $message )`

A simple function that prints `$var` if it's set, otherwise it prints `$message`.

`flash( $message, $type = 'info' )`

A wrapper around Laravel's `Session::flash( $message )` function to create a custom HTML message

`timestamp( $timestamp, $default = null, $format = 'd-m-Y' )`

A function that prints `$timestamp` in the format of `$format`, or if `$timestamp` is not set it prints `$default`.

`print_array( $input = array(), $field = null, $divider = ',' )`

Prints a single field (`$field`) from the input (`$input`), if there are multiple values with the same key in the arrey it'll return all of them divided by `$divider`.