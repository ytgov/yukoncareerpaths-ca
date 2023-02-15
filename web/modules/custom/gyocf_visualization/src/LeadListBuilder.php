<?php

namespace Drupal\gyocf_visualization;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the lead entity type.
 */
class LeadListBuilder extends EntityListBuilder {

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

    $build['summary']['#markup'] = $this->t('Total leads: @total', ['@total' => $total]);
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['remote_id'] = $this->t('Remote Id');
    $header['organization'] = $this->t('Organization');
    $header['department'] = $this->t('Department');
    $header['branch'] = $this->t('Branch');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\gyocf_visualization\Entity\Lead $entity */
    $row['id'] = $entity->toLink();
    $row['remote_id'] = $entity->remote_id->value;
    $row['organization'] = $entity->organization->value;
    $row['department'] = $entity->department->value;
    $row['branch'] = $entity->branch->value;
    return $row + parent::buildRow($entity);
  }

}
