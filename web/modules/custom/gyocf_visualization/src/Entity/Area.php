<?php

namespace Drupal\gyocf_visualization\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the area entity class.
 *
 * @ContentEntityType(
 *   id = "gyocf_area",
 *   label = @Translation("Area"),
 *   label_collection = @Translation("Areas"),
 *   label_singular = @Translation("area"),
 *   label_plural = @Translation("areas"),
 *   label_count = @PluralTranslation(
 *     singular = "@count areas",
 *     plural = "@count areas",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\gyocf_visualization\AreaListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\gyocf_visualization\Form\AreaForm",
 *       "edit" = "Drupal\gyocf_visualization\Form\AreaForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "gyocf_area",
 *   admin_permission = "administer gyocf area",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/gyocf-area",
 *     "add-form" = "/gyocf/area/add",
 *     "canonical" = "/gyocf/area/{gyocf_area}",
 *     "edit-form" = "/gyocf/area/{gyocf_area}/edit",
 *     "delete-form" = "/gyocf/area/{gyocf_area}/delete",
 *   },
 *   field_ui_base_route = "entity.gyocf_area.settings",
 * )
 */
class Area extends ContentEntityBase {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['remote_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Remote id'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number_integer',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('title'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['objectives'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Ojbectives'))
      ->setDescription(t('list of Ojbectives'))
      ->setSetting('target_type', 'gyocf_objective')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label'  => 'hidden',
        'type'   => 'string',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE)
      ->setDisplayOptions('form', [
        'type'     => 'entity_reference_autocomplete',
        'weight'   => 20,
        'settings' => [
          'match_operator'    => 'CONTAINS',
          'size'              => '60',
          'autocomplete_type' => 'tags',
          'placeholder'       => '',
        ],
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED);

    return $fields;
  }

}
