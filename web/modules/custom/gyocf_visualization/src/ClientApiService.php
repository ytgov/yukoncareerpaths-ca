<?php

namespace Drupal\gyocf_visualization;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Http\RequestStack;
use Drupal\Component\Datetime\TimeInterface;
use GuzzleHttp\ClientInterface;
use Drupal\Core\Http\ClientFactory;
use Drupal\Core\Logger\LoggerChannelTrait;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\TempStore\SharedTempStoreFactory;

/**
 * Communicate with the client api service.
 */
class ClientApiService implements ClientApiServiceInterface {
  use LoggerChannelTrait;
  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Http\RequestStack definition.
   *
   * @var \Drupal\Core\Http\RequestStack
   */
  protected $requestStack;

  /**
   * Drupal\Component\Datetime\TimeInterface definition.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $datetimeTime;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * GuzzleHttp\ClientInterface definition.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Gyocf httpclient attribute.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $gyocfClient;

  /**
   * Uniqid set for logger.
   *
   * @var int
   */
  private $uniqid;

  /**
   * Drupal\Core\TempStore\SharedTempStoreFactory definition.
   *
   * @var \Drupal\Core\TempStore\SharedTempStoreFactory
   */
  protected $tempStore;


  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  /**
   * Api request url.
   *
   * @var string
   */
  protected $requestUrl;

  /**
   * Constructs a new ClientApiService object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, RequestStack $request_stack, TimeInterface $datetime_time, ClientInterface $http_client, ClientFactory $http_client_factory, ConfigFactoryInterface $config_factory, SharedTempStoreFactory $temp_store_factory) {
    $this->entityTypeManager = $entity_type_manager;
    $this->requestStack = $request_stack;
    $this->datetimeTime = $datetime_time;
    $this->httpClient = $http_client;
    $this->configFactory = $config_factory;
    $this->tempStore = $temp_store_factory->get('gyocf_batch');
    $this->config = $this->configFactory->get('gyocf_visualization.settings');
    $this->requestUrl = $this->config->get('request_url');

    // Utilise retry middleware to retry 3 times, base on timeout of 30sec.
    $newStack = HandlerStack::create();
    $newStack->push(Middleware::retry($this->retryDecider(), $this->retryDelay()));
    $this->gyocfClient = $http_client_factory->fromOptions([
      'handler' => $newStack,
      'timeout' => 20,
    ]);

    $this->uniqid = uniqid();
  }

  /**
   * {@inheritdoc}
   */
  public function apiRequest($type, $method, array $data = [], $retry = FALSE) {
    $apiKey = $this->config->get('api_key');
    // The gyocfClient will automatically retry 3 times if request fails.
    $client = $retry ? $this->gyocfClient : $this->httpClient;
    switch ($method) {
      case "POST":
        break;

      case "GET":
        $result = $client->request('GET', $this->requestUrl . $type, [
          'query' => $data,
          'headers' => [
            'Accept'     => 'application/json',
            'Ocp-Apim-Subscription-Key' => $apiKey,
          ],
        ]
        );
        break;

      case "PATCH":
        break;
    }

    $apiRequest = $result->getBody()->getContents();

    return json_decode($apiRequest);
  }

  /**
   * {@inheritDoc}
   */
  public function getAllIndictors() {
    return $this->apiRequest('/api/v1/indicators', 'GET');
  }

  /**
   * {@inheritDoc}
   */
  public function getIndictor($id) {
    return $this->apiRequest("/api/v1/indicators/{$id}", 'GET');
  }

  /**
   * {@inheritDoc}
   */
  public function getAllActions() {
    return $this->apiRequest('/api/v1/actions', 'GET');
  }

  /**
   * {@inheritDoc}
   */
  public function getAction($id) {
    return $this->apiRequest("/api/v1/actions/{$id}", 'GET');
  }

  /**
   * {@inheritDoc}
   */
  public function getAllAreas() {
    return $this->apiRequest('/api/v1/areas', 'GET');
  }

  /**
   * {@inheritDoc}
   */
  public function getArea($id) {
    return $this->apiRequest("/api/v1/areas/{$id}", 'GET');
  }

  /**
   * {@inheritDoc}
   */
  public function createIndicator($id) {
    $indicator = $this->getIndictor($id);
    $leadsIds = $this->createLeads($indicator->leads);
    $goalIds = $this->createGoals($indicator->goals);
    $entryIds = $this->createIndicatorEntries($indicator->entries);
    /** @var \Drupal\gyocf_visualization\Entity\GyocfData $indicatorEntity */
    $indicatorEntity = $this->entityTypeManager->getStorage('gyocf_indicator')->create([
      'title' => $indicator->title,
      'remote_id' => $indicator->id,
    ]);
    $indicatorEntity->set('description', [
      'value' => $indicator->description,
      'format' => 'basic_html',
    ]);
    $indicatorEntity->set('collectionInterval', $indicator->collectionInterval ?? 0);
    $indicatorEntity->set('dataType', $indicator->dataType);
    $indicatorEntity->set('unitOfMeasurementName', $indicator->unitOfMeasurementName);
    $indicatorEntity->set('unitOfMeasurementSymbol', $indicator->unitOfMeasurementSymbol);
    $indicatorEntity->set('parentType', $indicator->parentType ?? 0);
    $indicatorEntity->set('targetDescription', [
      'value' => $indicator->targetDescription ?? "",
      'format' => 'basic_html',
    ]);
    $indicatorEntity->set('targetValue', $indicator->targetValue ?? 0);
    $indicatorEntity->set('targetCompletionDate', $indicator->targetCompletionDate);
    $indicatorEntity->set('note', [
      'value' => $indicator->note ?? "",
      'format' => 'basic_html',
    ]);
    $indicatorEntity->set('leads', $leadsIds);
    $indicatorEntity->set('goals', $goalIds);
    $indicatorEntity->set('entries', $entryIds);
    if ($this->getActionEntityId($indicator->actionId)) {
      $indicatorEntity->set('action', $this->getActionEntityId($indicator->actionId));
    }
    $indicatorEntity->save();
    $this->tempStoreUpdate('gyocf_indicator');

  }

  /**
   * {@inheritDoc}
   */
  public function createAction($id) {
    $action = $this->getAction($id);
    $leadsIds = $this->createLeads($action->leads);
    $directorsCommitteeIds = $this->createDirectorsCommittee($action->directorsCommittees);
    /** @var \Drupal\gyocf_visualization\Entity\Action $actionEntity */
    $actionEntity = $this->entityTypeManager->getStorage('gyocf_action')->create([
      'remote_id' => $action->id,
      'title' => [
        'value' => $action->title,
        'format' => 'basic_html',
      ],
      'number' => $action->number,
      'publicExplanation' => $action->publicExplanation,
      'note' => [
        'value' => $action->note,
        'format' => 'basic_html',
      ],
      'internalStatus' => $action->internalStatus,
      'internalStatusLastUpdatedDateTime' => $action->internalStatusLastUpdatedDateTime ?? "",
      'externalStatus' => $action->externalStatus,
      'externalStatusLastUpdatedDateTime' => $action->externalStatusLastUpdatedDateTime ?? "",
      'startDate' => $action->startDate ?? "",
      'targetCompletionDate' => $action->targetCompletionDate ?? "",
      'actualOrAnticipatedCompletionDate' => $action->actualOrAnticipatedCompletionDate ?? "",
      'leads' => $leadsIds,
      'directorsCommittees' => $directorsCommitteeIds,
    ]);
    $actionEntity->save();
    $this->tempStoreUpdate('gyocf_action');
  }

  /**
   * {@inheritDoc}
   */
  public function createArea($id) {
    $area = $this->getArea($id);
    $objectiveIds = $this->createObjectives($area->objectives);
    /** @var \Drupal\gyocf_visualization\Entity\Area $areaEntity */
    $areaEntity = $this->entityTypeManager->getStorage('gyocf_area')->create([
      'remote_id' => $area->id,
      'title' => $area->title,
      'objectives' => $objectiveIds,
    ]);
    $areaEntity->save();
    $this->tempStoreUpdate('gyocf_area');
  }

  /**
   * {@inheritDoc}
   */
  public function getActionEntityId($id) {
    $actionHandler = $this->entityTypeManager->getStorage('gyocf_action')->getQuery();
    $actionIds = $actionHandler->condition('remote_id', $id)->execute();
    if ($actionIds) {
      $actionId = reset($actionIds);
    }
    return $actionId ?? "";
  }

  /**
   * Create leads array.
   *
   * @param array $leads
   *   The leads array comes from indicator.
   *
   * @return array
   *   The array of target_id.
   */
  private function createLeads(array $leads) {
    $ids = [];
    foreach ($leads as $lead) {
      $leadHandler = $this->entityTypeManager->getStorage('gyocf_lead')->getQuery();
      $id = $lead->id;
      $leadEntities = $leadHandler->condition('remote_id', $id)
        ->execute();
      if ($leadEntities) {
        $leadId = reset($leadEntities);
      }
      else {
        /** @var \Drupal\gyocf_visualization\Entity\Lead $leadEntity */
        $leadEntity = $this->entityTypeManager->getStorage('gyocf_lead')->create([
          'remote_id' => $id,
          'organization' => $lead->organization ?? "",
          'department' => $lead->department ?? "",
          'branch' => $lead->branch ?? "",
        ]);
        $leadEntity->save();
        $leadId = $leadEntity->id();
        $this->tempStoreUpdate('gyocf_lead');
      }

      $ids[] = ['target_id' => $leadId];
    }
    return $ids;
  }

  /**
   * Create goals array.
   *
   * @param array $goals
   *   The goals array comes from indicator.
   *
   * @return array
   *   The array of target_id.
   */
  private function createGoals(array $goals) {
    $ids = [];
    foreach ($goals as $goal) {
      $gyocfHandler = $this->entityTypeManager->getStorage('gyocf_goal')->getQuery();
      $id = $goal->id;
      $goalEntities = $gyocfHandler->condition('remote_id', $id)
        ->execute();
      if ($goalEntities) {
        $goalId = reset($goalEntities);
      }
      else {
        /** @var \Drupal\gyocf_visualization\Entity\Goal $goalEntity */
        $goalEntity = $this->entityTypeManager->getStorage('gyocf_goal')->create([
          'remote_id' => $id,
          'title' => $goal->title,
        ]);
        $goalEntity->save();
        $goalId = $goalEntity->id();
        $this->tempStoreUpdate('gyocf_goal');
      }

      $ids[] = ['target_id' => $goalId];
    }
    return $ids;
  }

  /**
   * Create gyocf_indicator_entry array.
   *
   * @param array $entries
   *   The entries array comes from indicator.
   *
   * @return array
   *   The array of target_id.
   */
  private function createIndicatorEntries(array $entries) {
    $ids = [];
    foreach ($entries as $entry) {
      /** @var \Drupal\gyocf_visualization\Entity\IndicatorEntry $indicator_entry */
      $indicator_entry = $this->entityTypeManager->getStorage('gyocf_indicator_entry')->create([
        'startDate' => $entry->startDate ?? "",
        'endDate' => $entry->endDate ?? "",
        'value' => $entry->value ?? 0,
        'lastUpdatedBy' => $entry->lastUpdatedBy ?? "",
      ]);
      $indicator_entry->set('note', [
        'value' => $entry->note ?? "",
        'format' => 'basic_html',
      ]);
      $indicator_entry->save();
      $entryId = $indicator_entry->id();
      $this->tempStoreUpdate('gyocf_indicator_entry');
      $ids[] = ['target_id' => $entryId];
    }
    return $ids;
  }

  /**
   * Create directorsCommittees array.
   *
   * @param array $directorsCommittees
   *   The directorsCommittees array comes from indicator.
   *
   * @return array
   *   The array of target_id.
   */
  private function createDirectorsCommittee(array $directorsCommittees) {
    $ids = [];
    foreach ($directorsCommittees as $directorsCommittee) {
      $dcHandler = $this->entityTypeManager->getStorage('gyocf_directors_committee')->getQuery();
      $id = $directorsCommittee->id;
      $name = $directorsCommittee->name;
      $directorsCommitteeEntities = $dcHandler->condition('remote_id', $id)->execute();
      if ($directorsCommitteeEntities) {
        $directorsCommitteeId = reset($directorsCommitteeEntities);
      }
      else {
        /** @var \Drupal\gyocf_visualization\Entity\DirectorsCommittee $directorsCommitteeEntity */
        $directorsCommitteeEntity = $this->entityTypeManager->getStorage('gyocf_directors_committee')->create([
          'remote_id' => $id,
          'name' => $name,
        ]);
        $directorsCommitteeEntity->save();
        $directorsCommitteeId = $directorsCommitteeEntity->id();
        $this->tempStoreUpdate('gyocf_directors_committee');
      }

      $ids[] = ['target_id' => $directorsCommitteeId];
    }
    return $ids;
  }

  /**
   * Create objectives array.
   *
   * @param array $objectives
   *   The objectives array comes from area.
   */
  private function createObjectives(array $objectives) {
    $ids = [];
    foreach ($objectives as $objective) {
      $objHandler = $this->entityTypeManager->getStorage('gyocf_objective')->getQuery();
      $id = $objective->id;
      $objectiveEntities = $objHandler->condition('remote_id', $id)
        ->execute();
      if ($objectiveEntities) {
        $objectiveId = reset($objectiveEntities);
      }
      else {
        $goalIds = $this->createGoals($objective->goals);
        /** @var \Drupal\gyocf_visualization\Entity\Objective $objectiveEntity */
        $objectiveEntity = $this->entityTypeManager->getStorage('gyocf_objective')->create([
          'remote_id' => $id,
          'title' => $objective->title,
          'goals' => $goalIds,
        ]);
        $objectiveEntity->save();
        $objectiveId = $objectiveEntity->id();
        $this->tempStoreUpdate('gyocf_objective');
      }

      $ids[] = ['target_id' => $objectiveId];
    }
    return $ids;
  }

  /**
   * Boolean decider of retry attempts for Guzzle.
   */
  protected function retryDecider() {
    return function (
      $retries,
      Request $request,
      Response $response = NULL,
      RequestException $exception = NULL
   ) {
      if ((0 < $retries) && ($retries <= 2)) {
        $this->getLogger('gyocf_visualization')->info('%uniqid SystemAction retryDecider msg="Retrying %retries"', [
          '%uniqid' => $this->uniqid,
          '%retries' => $retries,
        ]);
      }
      // Limit the number of retries to 3.
      if ($retries >= 2) {
        $this->getLogger('gyocf_visualization')->info('%uniqid SystemAction retryDecider msg="Attempt on Retrying for Guzzle Client"', [
          '%uniqid' => $this->uniqid,
        ]);
        return FALSE;
      }

      // Retry connection exceptions.
      if ($exception instanceof ConnectException) {
        return TRUE;
      }

      if ($response) {
        // Retry on server errors.
        if ($response->getStatusCode() >= 500) {
          return TRUE;
        }
      }

      return FALSE;
    };
  }

  /**
   * Delay of each retries between request attempts.
   */
  protected function retryDelay() {
    return function ($numberOfRetries) {
      return 1000 * $numberOfRetries;
    };
  }

  /**
   * Update tempStore data.
   */
  public function tempStoreUpdate($type, $action = "add", $i = 1) {
    if ($action == "add") {
      $tempStore = $this->tempStore->get('addCount') ?? [];
      $tempStore[$type] = isset($tempStore[$type]) ? $tempStore[$type] + $i : $i;
      $this->tempStore->set('addCount', $tempStore);
    }
    elseif ($action == "delete") {
      $tempStore = $this->tempStore->get('deleteCount') ?? [];
      $tempStore[$type] = isset($tempStore[$type]) ? $tempStore[$type] + $i : $i;
      $this->tempStore->set('deleteCount', $tempStore);
    }
  }

}
