<?php

namespace Drupal\kinoprofile;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\kinoprofile\Entity\KinoProfileInterface;

/**
 * Defines the storage handler class for Kino profile entities.
 *
 * This extends the base storage class, adding required special handling for
 * Kino profile entities.
 *
 * @ingroup kinoprofile
 */
class KinoProfileStorage extends SqlContentEntityStorage implements KinoProfileStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(KinoProfileInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {kino_profile_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {kino_profile_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(KinoProfileInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {kino_profile_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('kino_profile_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
