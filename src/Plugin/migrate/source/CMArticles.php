<?php

/**
 * @file
 * Contains \Drupal\custom_migration\Plugin\migrate\source\CMArticles.
 */

namespace Drupal\custom_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for beer content.
 *
 * @MigrateSource(
 *   id = "cm_articles"
 * )
 */
class CMArticles extends SqlBase {

  private $min;
  private $max;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, \Drupal\migrate\Plugin\MigrationInterface $migration, \Drupal\Core\State\StateInterface $state) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration, $state);
    $this->min = $configuration['min'] ?: NULL;
    $this->max = $configuration['max'] ?: NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('node', 'n')
      ->fields('n', [
        'nid',
        'uid',
        'title',
        'created',
        'changed',
      ])
      ->condition("n.type", "article");

    if (!is_null($this->min) ){
      $query->condition("n.nid", $this->min, ">=");
    }
    if (!is_null($this->max) ){
      $query->condition("n.nid", $this->max, "<=");
    }
    $query->addJoin("INNER", "field_data_body", "fdb", "n.nid=fdb.entity_id");
    $query->fields("fdb", ['body_value']);

    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'nid' => $this->t("Article ID"),
      'uid' => $this->t("User ID"),
      'title' => $this->t("Article title"),
      'created' => $this->t("Proposal created date"),
      'changed' => $this->t("Proposal updated date"),
      'body_value' => $this->t("File proposal ID"),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'nid' => [
        'type' => 'integer',
        'alias' => 'n',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $status = (int) $row->getSourceProperty('closed');
    $row->setSourceProperty('closed', $status + 1);
    return parent::prepareRow($row);
  }

}