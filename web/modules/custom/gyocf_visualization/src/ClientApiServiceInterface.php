<?php

namespace Drupal\gyocf_visualization;

/**
 * Interface of communicate with the client api service.
 */
interface ClientApiServiceInterface {

  /**
   * Request the information from GYOCF API.
   *
   * @param string $type
   *   The request type of the GYOCF API.
   * @param string $method
   *   The http method: POST or GET;.
   * @param array $data
   *   The request query data.
   * @param bool $retry
   *   Boolean option, TRUE will make use of custom Client with retry.
   *   Defaults to FALSE.
   *
   * @return object
   *   The request object.
   */
  public function apiRequest($type, $method, array $data = [], bool $retry = FALSE);

  /**
   * Request for all the indicators.
   *
   * @return object
   *   The request object.
   */
  public function getAllIndictors();

  /**
   * Request the indicator.
   *
   * @param string $id
   *   The indicator id.
   *
   * @return object
   *   The request object.
   */
  public function getIndictor($id);

  /**
   * Request for all the actions.
   *
   * @return object
   *   The request object.
   */
  public function getAllActions();

  /**
   * Request the action.
   *
   * @param string $id
   *   The action id.
   *
   * @return object
   *   The request object.
   */
  public function getAction($id);

  /**
   * Request for all the areas.
   *
   * @return object
   *   The request object.
   */
  public function getAllAreas();

  /**
   * Request the area.
   *
   * @param string $id
   *   The area id.
   *
   * @return object
   *   The request object.
   */
  public function getArea($id);

  /**
   * Create an indicator entity with give id.
   *
   * @param string $id
   *   The indicator id.
   */
  public function createIndicator($id);

  /**
   * Create an action entity with give id.
   *
   * @param string $id
   *   The action id.
   */
  public function createAction($id);

  /**
   * Create an area entity with give id.
   *
   * @param string $id
   *   The area id.
   */
  public function createArea($id);

  /**
   * Helper function to get the entityId with given action id.
   *
   * @param string $id
   *   The action id.
   */
  public function getActionEntityId($id);

}
