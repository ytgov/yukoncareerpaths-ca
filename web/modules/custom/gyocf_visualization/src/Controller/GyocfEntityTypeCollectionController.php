<?php

namespace Drupal\gyocf_visualization\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Url;
use Drupal\Core\Utility\LinkGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Returns responses for GYOCF Visualization routes.
 */
class GyocfEntityTypeCollectionController extends ControllerBase {

  /**
   * The link generator.
   *
   * @var \Drupal\Core\Utility\LinkGeneratorInterface
   */
  protected $linkGenerator;

  /**
   * The render service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The controller constructor.
   *
   * @param \Drupal\Core\Utility\LinkGeneratorInterface $link_generator
   *   The link generator service.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The render service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(LinkGeneratorInterface $link_generator, RendererInterface $renderer, EntityTypeManagerInterface $entity_type_manager) {
    $this->linkGenerator = $link_generator;
    $this->renderer = $renderer;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('link_generator'),
      $container->get('renderer'),
      $container->get('entity_type.manager'),
    );
  }

  /**
   * Builds the response.
   */
  public function build() {

    $entityType = [
      'gyocf_indicator' => $this->t('indicator'),
      'gyocf_action' => $this->t('Action'),
      'gyocf_area' => $this->t('Area'),
      'gyocf_goal' => $this->t('Goal'),
      'gyocf_directors_committee' => $this->t('Directors Committee'),
      'gyocf_indicator_entry' => $this->t('Indicator Entry'),
      'gyocf_lead' => $this->t('Lead'),
      'gyocf_objective' => $this->t('Objective'),
    ];

    $header = [
      'title' => $this->t('Title'),
      'Operation' => $this->t('Operation'),
    ];

    $rows = [];

    foreach ($entityType as $entityId => $label) {
      $operation = [
        '#type' => 'dropbutton',
        '#dropbutton_type' => 'small',
        '#links' => [
          'edit_entity_type' => [
            'title' => $this->t('Edit'),
            'url' => Url::fromRoute("entity.${entityId}.settings"),
          ],
          'edit_manage_field' => [
            'title' => $this->t('Manage fields'),
            'url' => Url::fromRoute("entity.${entityId}.field_ui_fields"),
          ],
          'edit_manage_form_display' => [
            'title' => $this->t('Manage form display'),
            'url' => Url::fromRoute("entity.entity_form_display.${entityId}.default"),
          ],
          'edit_manage_view_display' => [
            'title' => $this->t('Manage display'),
            'url' => Url::fromRoute("entity.entity_view_display.${entityId}.default"),
          ],
        ],
      ];
      $operationBtn = $this->renderer->render($operation);
      $rows[] = [$label, Markup::create($operationBtn)];
    }

    $build['summary']['#markup'] = $this->t('All the Gyocf Entity Type');
    $build['content'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];

    return $build;
  }

}
