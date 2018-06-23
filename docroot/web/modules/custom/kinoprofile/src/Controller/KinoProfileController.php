<?php

namespace Drupal\kinoprofile\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\kinoprofile\Entity\KinoProfileInterface;

/**
 * Class KinoProfileController.
 *
 *  Returns responses for Kino profile routes.
 */
class KinoProfileController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Kino profile  revision.
   *
   * @param int $kino_profile_revision
   *   The Kino profile  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($kino_profile_revision) {
    $kino_profile = $this->entityManager()->getStorage('kino_profile')->loadRevision($kino_profile_revision);
    $view_builder = $this->entityManager()->getViewBuilder('kino_profile');

    return $view_builder->view($kino_profile);
  }

  /**
   * Page title callback for a Kino profile  revision.
   *
   * @param int $kino_profile_revision
   *   The Kino profile  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($kino_profile_revision) {
    $kino_profile = $this->entityManager()->getStorage('kino_profile')->loadRevision($kino_profile_revision);
    return $this->t('Revision of %title from %date', ['%title' => $kino_profile->label(), '%date' => format_date($kino_profile->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Kino profile .
   *
   * @param \Drupal\kinoprofile\Entity\KinoProfileInterface $kino_profile
   *   A Kino profile  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(KinoProfileInterface $kino_profile) {
    $account = $this->currentUser();
    $langcode = $kino_profile->language()->getId();
    $langname = $kino_profile->language()->getName();
    $languages = $kino_profile->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $kino_profile_storage = $this->entityManager()->getStorage('kino_profile');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $kino_profile->label()]) : $this->t('Revisions for %title', ['%title' => $kino_profile->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all kino profile revisions") || $account->hasPermission('administer kino profile entities')));
    $delete_permission = (($account->hasPermission("delete all kino profile revisions") || $account->hasPermission('administer kino profile entities')));

    $rows = [];

    $vids = $kino_profile_storage->revisionIds($kino_profile);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\kinoprofile\KinoProfileInterface $revision */
      $revision = $kino_profile_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $kino_profile->getRevisionId()) {
          $link = $this->l($date, new Url('entity.kino_profile.revision', ['kino_profile' => $kino_profile->id(), 'kino_profile_revision' => $vid]));
        }
        else {
          $link = $kino_profile->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.kino_profile.translation_revert', ['kino_profile' => $kino_profile->id(), 'kino_profile_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.kino_profile.revision_revert', ['kino_profile' => $kino_profile->id(), 'kino_profile_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.kino_profile.revision_delete', ['kino_profile' => $kino_profile->id(), 'kino_profile_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['kino_profile_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
