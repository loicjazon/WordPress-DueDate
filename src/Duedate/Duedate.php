<?php namespace Duedate;

if (!defined('ABSPATH')) exit;

use Duedate\Models\HooksAdminInterface;
use Duedate\Models\HooksFrontInterface;
use Duedate\Models\HooksInterface;

class Duedate implements HooksInterface
{
    protected $actions = [];

    /**
     * @param array $actions
     */
    public function __construct($actions = [])
    {
        $this->actions = $actions;
    }

    /**
     * @return boolean
     */
    protected function canBeLoaded()
    {
        return true;
    }

    /**
     * Execute plugin
     */
    public function execute()
    {
        if ($this->canBeLoaded()) {
            add_action('plugins_loaded', [$this, 'hooks'], 0);
        }
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Implements hooks from HooksInterface
     *
     * @see Todolist\Models\HooksInterface
     * @return void
     */
    public function hooks()
    {
        foreach ($this->getActions() as $key => $action) {
            switch (true) {  // Cela m'évite de faire un if / else if
                case $action instanceof HooksAdminInterface:
                    if (is_admin()) {
                        $action->hooks();
                    }
                    break;
                case $action instanceof HooksFrontInterface:
                    if (!is_admin()) {
                        $action->hooks();
                    }
                    break;
                case $action instanceof HooksInterface:
                    $action->hooks();
                    break;
            }
        }
    }
}