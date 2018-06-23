<?php

/**
 * @file
 * Contains kino_profile.page.inc.
 *
 * Page callback for Kino profile entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Kino profile templates.
 *
 * Default template: kino_profile.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_kino_profile(array &$variables) {
  // Fetch KinoProfile Entity Object.
  $kino_profile = $variables['elements']['#kino_profile'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
