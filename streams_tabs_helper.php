<?php defined('BASEPATH') or exit('No direct script access allowed');

function build_tabs($tabs, $stream, $namespace = null, $default = 'general')
{
    $fields = ci()->streams->streams->get_assignments($stream, $namespace);

    foreach ($fields as $field) $tabs[$default]['fields'][$field->field_slug] = $field->field_slug;

    foreach ($tabs as $key => $tab) {

        if ($key == $default) continue;

        foreach ($fields as $field) {

            if (in_array($field->field_slug, $tab['fields'])) {

                unset($tabs[$default]['fields'][$field->field_slug]);

            }

        }
    }

    return $tabs;
}
