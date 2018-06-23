<?php

namespace Drupal\kinoprofile\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class KinoProfileTypeForm.
 */
class KinoProfileTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $kino_profile_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $kino_profile_type->label(),
      '#description' => $this->t("Label for the Kino profile type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $kino_profile_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\kinoprofile\Entity\KinoProfileType::load',
      ],
      '#disabled' => !$kino_profile_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $kino_profile_type = $this->entity;
    $status = $kino_profile_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Kino profile type.', [
          '%label' => $kino_profile_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Kino profile type.', [
          '%label' => $kino_profile_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($kino_profile_type->toUrl('collection'));
  }

}
