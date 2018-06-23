<?php

namespace Drupal\kinoprofile\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Kino profile entities.
 *
 * @ingroup kinoprofile
 */
interface KinoProfileInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Kino profile name.
   *
   * @return string
   *   Name of the Kino profile.
   */
  public function getName();

  /**
   * Sets the Kino profile name.
   *
   * @param string $name
   *   The Kino profile name.
   *
   * @return \Drupal\kinoprofile\Entity\KinoProfileInterface
   *   The called Kino profile entity.
   */
  public function setName($name);

  /**
   * Gets the Kino profile creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Kino profile.
   */
  public function getCreatedTime();

  /**
   * Sets the Kino profile creation timestamp.
   *
   * @param int $timestamp
   *   The Kino profile creation timestamp.
   *
   * @return \Drupal\kinoprofile\Entity\KinoProfileInterface
   *   The called Kino profile entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Kino profile published status indicator.
   *
   * Unpublished Kino profile are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Kino profile is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Kino profile.
   *
   * @param bool $published
   *   TRUE to set this Kino profile to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\kinoprofile\Entity\KinoProfileInterface
   *   The called Kino profile entity.
   */
  public function setPublished($published);

  /**
   * Gets the Kino profile revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Kino profile revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\kinoprofile\Entity\KinoProfileInterface
   *   The called Kino profile entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Kino profile revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Kino profile revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\kinoprofile\Entity\KinoProfileInterface
   *   The called Kino profile entity.
   */
  public function setRevisionUserId($uid);

}
