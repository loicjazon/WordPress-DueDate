<?php namespace Duedate\Wordpress\Shortcode;

use Duedate\Models\HooksFrontInterface;
use Duedate\Wordpress\Validator\DeadlineValidator;

class Deadline implements HooksFrontInterface
{
    /**
     * @var DeadlineValidator
     */
    private $validator;

    public function __construct(DeadlineValidator $validator)
    {
        $this->validator = $validator;
    }
    /**
     * @return void
     */
    public function hooks()
    {
        add_action("wpcf7_init", [$this, 'init']);
        add_filter("wpcf7_validate", [$this->validator, 'validate'], 10, 2);
    }

    public function init()
    {
        wpcf7_add_shortcode('deadline', [$this, 'handler'], true);
    }

    public function handler($tag)
    {
        if (!is_array($tag)) return '';

        $html = $tag['content'];

        return $html;
    }
}