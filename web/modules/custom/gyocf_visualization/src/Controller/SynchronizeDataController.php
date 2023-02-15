<?php

namespace Drupal\gyocf_visualization\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Returns responses for GYOCF Visualization routes.
 */
class SynchronizeDataController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $url = Url::fromRoute('gyocf_visualization.synchronize_data_confirm');
    $synchronizeComfirmLink = Link::fromTextAndUrl($this->t('Start Data Synchronization'), $url);
    $synchronizeComfirmLink = $synchronizeComfirmLink->toRenderable();
    $synchronizeComfirmLink['#attributes'] = ['class' => ['button']];

    return $synchronizeComfirmLink;
  }

}
