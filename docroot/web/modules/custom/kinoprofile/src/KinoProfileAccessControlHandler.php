<?php

namespace Drupal\kinoprofile;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Kino profile entity.
 *
 * @see \Drupal\kinoprofile\Entity\KinoProfile.
 */
class KinoProfileAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\kinoprofile\Entity\KinoProfileInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished kino profile entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published kino profile entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit kino profile entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete kino profile entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add kino profile entities');
  }

}
