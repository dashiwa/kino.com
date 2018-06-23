<?php

namespace Drupal\kinoprofile;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface KinoProfileStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Kino profile revision IDs for a specific Kino profile.
   *
   * @param \Drupal\kinoprofile\Entity\KinoProfileInterface $entity
   *   The Kino profile entity.
   *
   * @return int[]
   *   Kino profile revision IDs (in ascending order).
   */
  public function revisionIds(KinoProfileInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Kino profile author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Kino profile revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\kinoprofile\Entity\KinoProfileInterface $entity
   *   The Kino profile entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(KinoProfileInterface $entity);

  /**
   * Unsets the language for all Kino profile with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
