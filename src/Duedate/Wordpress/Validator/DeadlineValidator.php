<?php namespace Duedate\Wordpress\Validator;

use Carbon\Carbon;
use WPCF7_Submission;

class DeadlineValidator
{
    public function validate($result, $tags)
    {
        // retrieve the posted email
        $form = WPCF7_Submission::get_instance();

        // si pas de deadline, on reste dans un formulaire classique
        $deadlines = $this->has_deadline_tag($tags);

        if (!$deadlines or empty($form->get_posted_data('date-demande'))) {
            return $result;
        }

        // date demandé par l'utilisateur
        $date_event = Carbon::createFromFormat('Y-m-d', $form->get_posted_data('date-demande'));

        // nombre de jours autorisé entre aujourd'hui et la demande
        $delta = $deadlines[0]['options'][0];

        if (!$this->validate_deadline($date_event, $delta)) {
            $result->invalidate('date-demande', "Votre demande doit être faite {$delta} jours à l'avance.");
        }

        return $result;
    }

    private function has_deadline_tag($tags)
    {
        return array_filter($tags, function ($tag) {
            return $tag['type'] == 'deadline';
        });
    }

    private function validate_deadline($date, $delta)
    {
        return $delta <= $date->diffInDays(Carbon::today());
    }
}