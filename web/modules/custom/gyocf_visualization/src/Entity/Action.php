<?php

namespace Drupal\gyocf_visualization\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the action entity class.
 *
 * @ContentEntityType(
 *   id = "gyocf_action",
 *   label = @Translation("Action"),
 *   label_collection = @Translation("Actions"),
 *   label_singular = @Translation("action"),
 *   label_plural = @Translation("actions"),
 *   label_count = @PluralTranslation(
 *     singular = "@count actions",
 *     plural = "@count actions",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\gyocf_visualization\ActionListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\gyocf_visualization\Form\ActionForm",
 *       "edit" = "Drupal\gyocf_visualization\Form\ActionForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "gyocf_action",
 *   admin_permission = "administer gyocf action",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/gyocf-action",
 *     "add-form" = "/gyocf/action/add",
 *     "canonical" = "/gyocf/action/{gyocf_action}",
 *     "edit-form" = "/gyocf/action/{gyocf_action}/edit",
 *     "delete-form" = "/gyocf/action/{gyocf_action}/delete",
 *   },
 *   field_ui_base_route = "entity.gyocf_action.settings",
 * )
 */
class Action extends ContentEntityBase {

  use EntityChangedTrait;

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

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the action was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the action was last edited.'));

    $fields['title'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Title'))
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

    $fields['number'] = BaseFieldDefinition::create('string')
      ->setLabel(t('number'))
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

    $fields['publicExplanation'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Public Explanation'))
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

    $fields['note'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('note'))
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

    $fields['internalStatus'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Internal Status'))
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
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['internalStatusLastUpdatedDateTime'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Internal Status Last Updated DateTime'))
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

    $fields['externalStatus'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('External Status'))
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
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', FALSE);

    $fields['externalStatusLastUpdatedDateTime'] = BaseFieldDefinition::create('string')
      ->setLabel(t('External Status Last Updated DateTime'))
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

    $fields['targetCompletionDate'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Target Completion Date'))
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

    $fields['actualOrAnticipatedCompletionDate'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Actual Or Anticipated Completion Date'))
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

    $fields['leads'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Leads'))
      ->setDescription(t('list of leads'))
      ->setSetting('target_type', 'gyocf_lead')
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

    $fields['directorsCommittees'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Directors Committees'))
      ->setDescription(t('list of directors committees'))
      ->setSetting('target_type', 'gyocf_directors_committee')
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
