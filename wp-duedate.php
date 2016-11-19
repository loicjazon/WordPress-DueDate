<?php

/**
 * Plugin Name: Due Date
 * Description: Extension pour contact form 7. Ajout un nouveau champs : deadline
 * Version: 1.0.0
 * Author: Loïc Jazon
 */

require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

use Duedate\Duedate;
use Duedate\Wordpress\Shortcode\Deadline;
use Duedate\Wordpress\Validator\DeadlineValidator;

$actions = [
    new Deadline(new DeadlineValidator()),
];

$duedate = new Duedate($actions);
$duedate->execute();