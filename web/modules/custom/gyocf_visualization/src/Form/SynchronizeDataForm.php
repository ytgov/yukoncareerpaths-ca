<?php

namespace Drupal\gyocf_visualization\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\gyocf_visualization\ClientApiServiceInterface;
use Drupal\Core\Url;
use Drupal\Core\TempStore\SharedTempStoreFactory;

/**
 * Provides a GYOCF Visualization form.
 */
class SynchronizeDataForm extends ConfirmFormBase {

  /**
   * Drupal\Core\Session\AccountInterface definition.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $account;

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\gyocf_visualization\ClientApiServiceInterface definition.
   *
   * @var \Drupal\gyocf_visualization\ClientApiServiceInterface
   */
  protected $clientApi;

  /**
   * Stores the shared tempstore.
   *
   * @var \Drupal\Core\TempStore\SharedTempStore
   */
  protected $tempStore;

  /**
   * The batch size.
   */
  const BATCH_SIZE = 1000;

  /**
   * Constructs a new SynchronizeDataForm object.
   */
  public function __construct(AccountInterface $account, EntityTypeManagerInterface $entity_type_manager, ClientApiServiceInterface $client_api, SharedTempStoreFactory $temp_store_factory) {
    $this->account = $account;
    $this->entityTypeManager = $entity_type_manager;
    $this->clientApi = $client_api;
    $this->tempStore = $temp_store_factory->get('gyocf_batch');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user'),
      $container->get('entity_type.manager'),
      $container->get('gyocf_visualization.default'),
      $container->get('tempstore.shared')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'gyocf_visualization_synchronize_data';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Do you really want to synchronize data?');
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->t('Warning: This process cannot be undone. Once started it must complete in order to ensure all data is synchronized.');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('gyocf_visualization.synchronize_data');
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->tempStore->delete('addCount');
    $this->tempStore->delete('deleteCount');

    $operations = [];

    $entityTypeList = ['gyocf_indicator', 'gyocf_lead', 'gyocf_goal',
      'gyocf_indicator_entry', 'gyocf_directors_committee',
      'gyocf_action', 'gyocf_area',
      'gyocf_objective',
    ];
    // Delete all the entities.
    foreach ($entityTypeList as $entityType) {

      $entityTypeHandler = $this->entityTypeManager->getStorage($entityType)->getQuery();
      $entityIds = $entityTypeHandler->execute();
      $totalCount = count($entityIds);
      // Delete current entity type entities.
      if ($totalCount) {
        foreach (array_chunk($entityIds, ceil($totalCount / $this::BATCH_SIZE)) as $chunk) {
          $data = [
            'ids' => $chunk,
            'entity_type' => $entityType,
            'action' => 'delete',
          ];
          $operations[] = [
            'Drupal\gyocf_visualization\Form\SynchronizeDataForm::batchProcess', [$data],
          ];
        }
      }
    }
    // Import Data from the Client's API.
    $importTypes = ['action', 'area', 'indicator'];
    foreach ($importTypes as $importType) {
      switch ($importType) {
        case 'action':
          $clientDataSet = $this->clientApi->getAllActions();
          break;

        case 'area':
          $clientDataSet = $this->clientApi->getAllAreas();
          break;

        case 'indicator':
          $clientDataSet = $this->clientApi->getAllIndictors();
          break;
      }
      foreach ($clientDataSet as $object) {
        $data = [
          'object' => $object,
          'type' => $importType,
          'action' => 'import',
        ];
        $operations[] = [
          'Drupal\gyocf_visualization\Form\SynchronizeDataForm::batchProcess', [$data],
        ];
      }
    }

    // Redirect to synchronize controller after finish batch job.
    $form_state->setRedirect('gyocf_visualization.synchronize_data');

    $batch = [
      'title' => $this->t("Start to synchronize data."),
      'init_message' => $this->t("Synchronize data is starting."),
      'operations' => $operations,
      'finished' => 'Drupal\gyocf_visualization\Form\SynchronizeDataForm::batchFinished',
    ];
    batch_set($batch);

  }

  /**
   * Batch process function.
   */
  public static function batchProcess($data, &$context) {
    $action = $data['action'];
    if ($action == "delete") {
      $entityType = $data['entity_type'];
      $ids = $data['ids'];
      $context['message'] = t('Delete @type data', ['@type' => $entityType]);
      $entities = \Drupal::entityTypeManager()->getStorage($entityType)->loadMultiple($ids);
      \Drupal::entityTypeManager()->getStorage($entityType)->delete($entities);
      \Drupal::service("gyocf_visualization.default")->tempStoreUpdate($entityType, "delete", count($ids));
    }
    elseif ($action == "import") {
      $type = $data['type'];
      if ($type == "indicator") {
        $indicator = $data['object'];
        $indicatorId = $indicator->id;
        $context['message'] = t('Create indicator data: @title', ['@title' => $indicator->title ?? ""]);
        \Drupal::service('gyocf_visualization.default')->createIndicator($indicatorId);
      }
      elseif ($type == "action") {
        $action = $data['object'];
        $actionId = $action->id;
        $context['message'] = t('Create action data: @title', ['@title' => $action->title ?? ""]);
        \Drupal::service('gyocf_visualization.default')->createAction($actionId);
      }
      elseif ($type == "area") {
        $area = $data['object'];
        $areaId = $area->id;
        $context['message'] = t('Create area data: @title', ['@title' => $action->title ?? ""]);
        \Drupal::service('gyocf_visualization.default')->createArea($areaId);
      }
    }
  }

  /**
   * Batch finished function.
   */
  public static function batchFinished($success, $results, $operations) {
    if ($success) {
      $deleteTempStore = \Drupal::service("tempstore.shared")->get('gyocf_batch')->get('deleteCount') ?? [];
      if ($deleteTempStore) {
        $msg = "";
        foreach ($deleteTempStore as $type => $value) {
          $msg = $msg . "Delete {$type}: {$value} entities. ";
        }
        \Drupal::service('messenger')->addStatus($msg);
      }
      $addTempStore = \Drupal::service("tempstore.shared")->get('gyocf_batch')->get('addCount') ?? [];
      if ($addTempStore) {
        $msg = "";
        foreach ($addTempStore as $type => $value) {
          $msg = $msg . "Add {$type}: {$value} entities. ";
        }
        \Drupal::service('messenger')->addStatus($msg);
      }
    }
    else {
      $error_operation = reset($operations);
      \Drupal::service('messenger')->addError(
        t('An error occurred while processing @operation with arguments : @args', [
          '@operation' => $error_operation[0],
          '@args' => print_r($error_operation[0], TRUE),
        ]));
    }

  }

}
