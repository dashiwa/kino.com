<?php

namespace Drupal\kinoprofile\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Kino profile entities.
 */
class KinoProfileViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
