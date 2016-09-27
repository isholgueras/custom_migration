<?php

/**
 * @file
 * Contains \Drupal\hck_migrate\Plugin\migrate\source\ProposalUser.
 */

namespace Drupal\hck_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for users.
 *
 * @MigrateSource(
 *   id = "cm_user"
 * )
 */
class ProposalUser extends SqlBase {

    /**
     * {@inheritdoc}
     */
    public function query() {
        $query = $this->select('users', 'u')
            ->fields('u', [
                'uid',
                'name',
                'mail',
                'active',
                'created',
                'last_login',
            ])
            ->condition("u.username", "admin", "<>");
        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function fields() {
        $fields = [
            'id' => $this->t("User ID"),
            'username' => $this->t("Username"),
            'email' => $this->t("User's email"),
            'active' => $this->t("User is active or blocked"),
            'created' => $this->t("Creation date"),
            'last_login' => $this->t("Last login from user"),
        ];

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function getIds() {
        return [
            'id' => [
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