<?php

declare(strict_types=1);

/*
 * This file is part of the KimaiQuickbooksBundle for Kimai 2.
 * All rights reserved by Matt Barclay (matt@cascadia-aero.com).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\KimaiQuickbooksBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version202107100000 extends AbstractMigration
{
    public const QB_CUSTOMER_MAPPINGS_TABLE_NAME = 'kimai2_quickbooks_customer_mappings';

    public function getDescription(): string
    {
        return 'Create tables for quickbooks integration';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->hasTable(self::QB_CUSTOMER_MAPPINGS_TABLE_NAME)) {
            $table = $schema->createTable(self::QB_CUSTOMER_MAPPINGS_TABLE_NAME);
            $table->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'notnull' => true]);
            $table->addColumn('customer_id', Types::INTEGER, ['notnull' => true]);
            $table->addColumn('qb_id', Types::INTEGER, ['notnull' => true]);
            $table->addColumn('display_name', Types::STRING, ['length' => 255, 'notnull' => true]);

            $table->setPrimaryKey(['id']);
            $table->addIndex(['qb_id', 'customer_id']);
            $table->addIndex(['display_name']);
            $table->addForeignKeyConstraint(
                'kimai2_projects',
                ['customer_id'],
                ['id'],
                [
                    'onUpdate' => 'CASCADE',
                    'onDelete' => 'CASCADE',
                ]
            );
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable(self::QB_CUSTOMER_MAPPINGS_TABLE_NAME)) {
            $schema->dropTable(self::QB_CUSTOMER_MAPPINGS_TABLE_NAME);
        }
    }
}
