<?php

/**
 * @file
 * Contains \Drupal\hck_migrate\Plugin\migrate\source\ProposalUser.
 */

namespace Drupal\custom_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for users.
 *
 * @MigrateSource(
 *   id = "cm_users"
 * )
 */
class CMUsers extends SqlBase {

    /**
     * {@inheritdoc}
     */
    public function query() {
        $query = $this->select('users', 'u')
            ->fields('u', [
                'uid',
                'name',
                'mail',
                'status',
                'created',
                'login',
            ])
          ->condition("u.name", "admin", "<>")
          ->condition("u.name", "", "<>");
        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function fields() {
        $fields = [
            'uid' => $this->t("User ID"),
            'name' => $this->t("Username"),
            'mail' => $this->t("User's email"),
            'status' => $this->t("User is active or blocked"),
            'created' => $this->t("Creation date"),
            'login' => $this->t("Last login from user"),
        ];

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function getIds() {
        return [
            'uid' => [
                'type' => 'string',
                'alias' => 'u',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function prepareRow(Row $row) {
        return parent::prepareRow($row);
    }
}