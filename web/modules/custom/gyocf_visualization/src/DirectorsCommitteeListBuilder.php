<?php

namespace Drupal\gyocf_visualization;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the directors committee entity type.
 */
class DirectorsCommitteeListBuilder extends EntityListBuilder {

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

    $build['summary']['#markup'] = $this->t('Total directors committees: @total', ['@total' => $total]);
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('ID');
    $header['remote_id'] = $this->t('Remote ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\gyocf_visualization\Entity\DirectorsCommittee $entity */
    $row['id'] = $entity->toLink();
    $row['remote_id'] = $entity->remote_id->value;
    $row['name'] = $entity->name->value;
    return $row + parent::buildRow($entity);
  }

}
