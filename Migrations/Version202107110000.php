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

final class Version202107110000 extends AbstractMigration
{
    public const QB_CONNECTIONS_TABLE_NAME = 'kimai2_quickbooks_connections';

    public function getDescription(): string
    {
        return 'Create tables for quickbooks integration';
    }

    public function up(Schema $schema): void
    {
        if(!$schema->hasTable(self::QB_CONNECTIONS_TABLE_NAME)) {
            $table = $schema->createTable(self::QB_CONNECTIONS_TABLE_NAME);
            $table->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'notnull' => true]);
            $table->addColumn('company_id', Types::STRING, ['notnull' => true]);
            $table->addColumn('access_token', Types::TEXT, ['notnull' => true]);
            $table->addColumn('company_name', Types::STRING, ['length' => 255, 'notnull' => true]);

            $table->setPrimaryKey(['id']);
            $table->addUniqueIndex(['company_id']);
            $table->addIndex(['company_name']);
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable(self::QB_CONNECTIONS_TABLE_NAME)) {
            $schema->dropTable(self::QB_CONNECTIONS_TABLE_NAME);
        }
    }
}
