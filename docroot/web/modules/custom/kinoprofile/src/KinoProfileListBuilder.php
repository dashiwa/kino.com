<?php

namespace Drupal\kinoprofile;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Kino profile entities.
 *
 * @ingroup kinoprofile
 */
class KinoProfileListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Kino profile ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\kinoprofile\Entity\KinoProfile */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.kino_profile.edit_form',
      ['kino_profile' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
