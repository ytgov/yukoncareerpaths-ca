<?php

namespace Drupal\gyocf_visualization_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\gyocf_visualization\ClientApiServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for GYOCF Custom routes.
 */
class HighChartController extends ControllerBase {

  /**
   * The gyocf_visualization.default service.
   *
   * @var \Drupal\gyocf_visualization\ClientApiServiceInterface
   */
  protected $clientApi;

  /**
   * The controller constructor.
   *
   * @param \Drupal\gyocf_visualization\ClientApiServiceInterface $client_api
   *   The gyocf_visualization.default service.
   */
  public function __construct(ClientApiServiceInterface $client_api) {
    $this->clientApi = $client_api;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('gyocf_visualization.default')
    );
  }

  /**
   * Builds the response.
   */
  public function build() {
    // ID: 105; Yukon's total GHGs.
    $gasEmissions = $this->clientApi->getIndictor(105);

    // Emission source breakdowns.
    // ID: 48; GHGs from YG buildings
    // ID: 49; GHGs from electricity generation
    // ID: 65; GHGs from heating fuel
    // ID: 66; GHGs from waste
    // ID: 83; GHGs from YG operations
    // ID: 84; GHGs from YG transportation
    // ID: 85; GHGs from YG other sources
    // ID: 86; GHGs from corporations
    // ID: 87; GHGs from YEC
    // ID: 95; GHGs from on-road diesel
    // ID: 100; GHGs from mining
    // ID: 103; GHGs from non-mining off road diesel
    // ID: 104; GHGs from other sources
    // ID: 109; GHGs from aviation
    // ID: 110; GHGs from road transportation
    // ID: 111; GHGs from on-road gasoline.
    $emissionSourceIds = [48, 49, 65, 66, 83, 84, 85,
      86, 87, 95, 100, 103, 104, 109, 110, 111,
    ];

    $emissionSource = [];
    foreach ($emissionSourceIds as $id) {
      $emissionSource[] = $this->clientApi->getIndictor($id);
    }

    // ID: 102; Non-mining GHGs.
    $nonGhgsEmissions = $this->clientApi->getIndictor(102);

    // ID: 63; Rolling average of supply on the Yukon Integrated System.
    $rollingAvgRenewEleGen = $this->clientApi->getIndictor(63);
    // ID: 64; Renewable electricity supply on the Yukon Integrated System.
    $renewEleSupYukonItgSys = $this->clientApi->getIndictor(64);

    // ID: 47; GHGs per capita.
    $ghgsPerCapita = $this->clientApi->getIndictor(47);

    // ID: 46; GHGs per GDP.
    $ghgsPerGdp = $this->clientApi->getIndictor(46);

    $build['content'] = [
      '#theme' => 'highchart_example',
      '#attached' => [
        'library' => [
          'gyocf_visualization_example/highcharts',
        ],
        'drupalSettings' => [
          'gasEmissions' => $gasEmissions,
          'emissionSource' => $emissionSource,
          'nonGhgsEmissions' => $nonGhgsEmissions,
          'rollingAvgRenewEleGen' => $rollingAvgRenewEleGen,
          'renewEleSupYukonItgSys' => $renewEleSupYukonItgSys,
          'ghgsPerCapita' => $ghgsPerCapita,
          'ghgsPerGdp' => $ghgsPerGdp,
        ],
      ],
    ];

    return $build;
  }

}
