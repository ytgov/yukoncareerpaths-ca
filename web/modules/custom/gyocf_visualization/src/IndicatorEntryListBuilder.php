<?php

namespace Drupal\gyocf_visualization;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the indicator entry entity type.
 */
class IndicatorEntryListBuilder extends EntityListBuilder {

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

    $build['summary']['#markup'] = $this->t('Total indicator entries: @total', ['@total' => $total]);
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['startDate'] = $this->t('Start Date');
    $header['endDate'] = $this->t('End Date');
    $header['value'] = $this->t('Value');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\gyocf_visualization\entity\IndicatorEntry $entity */
    $start = new DrupalDateTime($entity->startDate->value);
    $end = new DrupalDateTime($entity->endDate->value);
    $row['id'] = $entity->toLink();
    $row['startDate'] = $start->format('Y-m-d H:i:s');
    $row['endDate'] = $end->format('Y-m-d H:i:s');
    $row['value'] = $entity->value->value;
    return $row + parent::buildRow($entity);
  }

}
