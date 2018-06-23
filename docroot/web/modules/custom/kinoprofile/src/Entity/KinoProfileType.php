<?php

namespace Drupal\kinoprofile\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Kino profile type entity.
 *
 * @ConfigEntityType(
 *   id = "kino_profile_type",
 *   label = @Translation("Kino profile type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\kinoprofile\KinoProfileTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\kinoprofile\Form\KinoProfileTypeForm",
 *       "edit" = "Drupal\kinoprofile\Form\KinoProfileTypeForm",
 *       "delete" = "Drupal\kinoprofile\Form\KinoProfileTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\kinoprofile\KinoProfileTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "kino_profile_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "kino_profile",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/kino_profile_type/{kino_profile_type}",
 *     "add-form" = "/admin/structure/kino_profile_type/add",
 *     "edit-form" = "/admin/structure/kino_profile_type/{kino_profile_type}/edit",
 *     "delete-form" = "/admin/structure/kino_profile_type/{kino_profile_type}/delete",
 *     "collection" = "/admin/structure/kino_profile_type"
 *   }
 * )
 */
class KinoProfileType extends ConfigEntityBundleBase implements KinoProfileTypeInterface {

  /**
   * The Kino profile type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Kino profile type label.
   *
   * @var string
   */
  protected $label;

}
