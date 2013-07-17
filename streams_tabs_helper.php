<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @package  PyroCMS
 * @subpackage Streams Tabs Helper
 * @author Chris Harvey <chris@chrisnharvey.com>
 * @license MIT
 */

/**
 * Build a tabs array for streams
 * 
 * @param  array  $tabs       Your associative tab array
 * @param  string $stream     Stream slug
 * @param  string $namespace  Stream namesapce
 * @param  string $default    The default tab where other fields will go if they have not been assigned to a tab
 * @return array              The tabs array ready to be passed into $this->streams->cp->entry_form()
 */
function build_tabs($tabs, $stream, $namespace = null, $default = 'general')
{
    $fields = ci()->streams->streams->get_assignments($stream, $namespace);

    foreach ($fields as $field) $tabs[$default]['fields'][$field->field_slug] = $field->field_slug;

    foreach ($tabs as $key => &$tab) {

        if ($key == $default) continue;

        foreach ($tab['fields'] as $field_key => $field) {
            if ( ! in_array($field, $tabs[$default]['fields'])) {
                unset($tab['fields'][$field_key]);
            }
        }

        foreach ($fields as $field) {

            if (in_array($field->field_slug, $tab['fields'])) {

                unset($tabs[$default]['fields'][$field->field_slug]);

            }

        }

        if (empty($tab['fields'])) unset($tabs[$key]);
    }

    if (empty($tabs[$default]['fields'])) unset($tabs[$default]);

    return $tabs;
}