<?php

namespace Drupal\gyocf_visualization;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the action entity type.
 */
class ActionListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build['table'] = parent::render();

    $total = $this->getStorage()
      ->getQuery()
      ->accessCheck(FALSE)
      ->count()
      ->execute();

    $build['summary']['#markup'] = $this->t('Total actions: @total', ['@total' => $total]);
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['remote_id'] = $this->t('Remote Id');
    $header['number'] = $this->t('Number');
    $header['title'] = $this->t('Title');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\gyocf_visualization\entity\Action $entity */
    $row['id'] = $entity->toLink();
    $row['remote_id'] = $entity->remote_id->value;
    $row['number'] = $entity->number->value;
    $row['title'] = $entity->title->value;
    return $row + parent::buildRow($entity);
  }

}
