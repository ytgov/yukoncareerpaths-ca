<?php

namespace Drupal\gyocf_visualization\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the indicator entry entity class.
 *
 * @ContentEntityType(
 *   id = "gyocf_indicator_entry",
 *   label = @Translation("Indicator Entry"),
 *   label_collection = @Translation("Indicator Entries"),
 *   label_singular = @Translation("indicator entry"),
 *   label_plural = @Translation("indicator entries"),
 *   label_count = @PluralTranslation(
 *     singular = "@count indicator entries",
 *     plural = "@count indicator entries",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\gyocf_visualization\IndicatorEntryListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\gyocf_visualization\Form\IndicatorEntryForm",
 *       "edit" = "Drupal\gyocf_visualization\Form\IndicatorEntryForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "gyocf_indicator_entry",
 *   admin_permission = "administer gyocf indicator entry",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/gyocf-indicator-entry",
 *     "add-form" = "/gyocf/indicator-entry/add",
 *     "canonical" = "/gyocf/indicator-entry/{gyocf_indicator_entry}",
 *     "edit-form" = "/gyocf/indicator-entry/{gyocf_indicator_entry}/edit",
 *     "delete-form" = "/gyocf/indicator-entry/{gyocf_indicator_entry}/delete",
 *   },
 *   field_ui_base_route = "entity.gyocf_indicator_entry.settings",
 * )
 */
class IndicatorEntry extends ContentEntityBase {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['startDate'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Start Date'))
      ->setDisplayOptions('form', [
        'type' => 'datetime_default',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'datetime_default',
        'settings' => [
          'format_type' => 'medium',
        ],
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['endDate'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('End Date'))
      ->setDisplayOptions('form', [
        'type' => 'datetime_default',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'datetime_default',
        'settings' => [
          'format_type' => 'medium',
        ],
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['value'] = BaseFieldDefinition::create('float')
      ->setLabel(t('value'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number_decimal',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['note'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Note'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', FALSE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'above',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['lastUpdatedBy'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Last Updated By'))
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

    return $fields;
  }

}
