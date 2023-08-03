<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS extension "form_consent".
 *
 * Copyright (C) 2023 Elias Häußler <elias@haeussler.dev>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace EliasHaeussler\Typo3FormConsent\Tests\Unit\Configuration;

use EliasHaeussler\Typo3FormConsent\Configuration\Icon;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * IconTest
 *
 * @author Elias Häußler <elias@haeussler.dev>
 * @license GPL-2.0-or-later
 */
#[CoversClass(Icon::class)]
final class IconTest extends UnitTestCase
{
    #[Test]
    #[DataProvider('invalidIdentifierDataProvider')]
    public function forTableThrowsExceptionIfNoTableNameIsGiven(string $tableName): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1580308459);

        Icon::forTable($tableName);
    }

    #[Test]
    #[DataProvider('forTableReturnsCorrectFileNameDataProvider')]
    public function forTableReturnsCorrectFileName(?string $type, string $expected): void
    {
        if ($type !== null) {
            self::assertSame($expected, Icon::forTable('dummy', $type));
        } else {
            self::assertSame($expected, Icon::forTable('dummy'));
        }
    }

    #[Test]
    #[DataProvider('forPluginReturnsCorrectFileNameDataProvider')]
    public function forPluginReturnsCorrectFileName(?string $type, string $expected): void
    {
        if ($type !== null) {
            self::assertSame($expected, Icon::forPlugin('dummy', $type));
        } else {
            self::assertSame($expected, Icon::forPlugin('dummy'));
        }
    }

    #[Test]
    #[DataProvider('invalidIdentifierDataProvider')]
    public function forPluginIdentifierThrowsExceptionIfPluginIdentifierIsInvalid(string $pluginName): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1587655457);

        Icon::forPluginIdentifier($pluginName);
    }

    #[Test]
    #[DataProvider('forPluginIdentifierReturnsCorrectPluginIdentifierDataProvider')]
    public function forPluginIdentifierReturnsCorrectPluginIdentifier(string $pluginName, string $expected): void
    {
        self::assertSame($expected, Icon::forPluginIdentifier($pluginName));
    }

    #[Test]
    #[DataProvider('forWidgetReturnsCorrectFileNameDataProvider')]
    public function forWidgetReturnsCorrectFileName(?string $type, string $expected): void
    {
        if ($type !== null) {
            self::assertSame($expected, Icon::forWidget('dummy', $type));
        } else {
            self::assertSame($expected, Icon::forWidget('dummy'));
        }
    }

    #[Test]
    #[DataProvider('invalidIdentifierDataProvider')]
    public function forWidgetIdentifierThrowsExceptionIfWidgetIdentifierIsInvalid(string $widgetName): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1632850400);

        Icon::forWidgetIdentifier($widgetName);
    }

    #[Test]
    #[DataProvider('forWidgetIdentifierReturnsCorrectWidgetIdentifierDataProvider')]
    public function forWidgetIdentifierReturnsCorrectWidgetIdentifier(string $widgetName, string $expected): void
    {
        self::assertSame($expected, Icon::forWidgetIdentifier($widgetName));
    }

    /**
     * @return \Generator<string, array{string}>
     */
    public static function invalidIdentifierDataProvider(): \Generator
    {
        yield 'empty string' => [''];
        yield 'whitespaces' => ['    '];
        yield 'line break' => [PHP_EOL];
    }

    /**
     * @return \Generator<string, array{string|null, string}>
     */
    public static function forTableReturnsCorrectFileNameDataProvider(): \Generator
    {
        yield 'no type' => [null, 'EXT:form_consent/Resources/Public/Icons/dummy.svg'];
        yield 'custom type' => ['jpg', 'EXT:form_consent/Resources/Public/Icons/dummy.jpg'];
        yield 'non-trimmed type' => ['   svg  ', 'EXT:form_consent/Resources/Public/Icons/dummy.svg'];
        yield 'case-sensitive type' => ['jpEG', 'EXT:form_consent/Resources/Public/Icons/dummy.jpEG'];
    }

    /**
     * @return \Generator<string, array{string|null, string}>
     */
    public static function forPluginReturnsCorrectFileNameDataProvider(): \Generator
    {
        yield 'no type' => [null, 'EXT:form_consent/Resources/Public/Icons/plugin.dummy.svg'];
        yield 'custom type' => ['jpg', 'EXT:form_consent/Resources/Public/Icons/plugin.dummy.jpg'];
        yield 'non-trimmed type' => ['   svg  ', 'EXT:form_consent/Resources/Public/Icons/plugin.dummy.svg'];
        yield 'case-sensitive type' => ['jpEG', 'EXT:form_consent/Resources/Public/Icons/plugin.dummy.jpEG'];
    }

    /**
     * @return \Generator<string, array{string, string}>
     */
    public static function forPluginIdentifierReturnsCorrectPluginIdentifierDataProvider(): \Generator
    {
        yield 'valid plugin name' => ['foo', 'content-plugin-foo'];
        yield 'plugin name with whitespaces' => [' foo   ', 'content-plugin-foo'];
        yield 'plugin name in upper camelcase' => ['FooBaz', 'content-plugin-foo-baz'];
    }

    /**
     * @return \Generator<string, array{string|null, string}>
     */
    public static function forWidgetReturnsCorrectFileNameDataProvider(): \Generator
    {
        yield 'no type' => [null, 'EXT:form_consent/Resources/Public/Icons/widget.dummy.svg'];
        yield 'custom type' => ['jpg', 'EXT:form_consent/Resources/Public/Icons/widget.dummy.jpg'];
        yield 'non-trimmed type' => ['   svg  ', 'EXT:form_consent/Resources/Public/Icons/widget.dummy.svg'];
        yield 'case-sensitive type' => ['jpEG', 'EXT:form_consent/Resources/Public/Icons/widget.dummy.jpEG'];
    }

    /**
     * @return \Generator<string, array{string, string}>
     */
    public static function forWidgetIdentifierReturnsCorrectWidgetIdentifierDataProvider(): \Generator
    {
        yield 'valid widget name' => ['foo', 'content-widget-foo'];
        yield 'widget name with whitespaces' => [' foo   ', 'content-widget-foo'];
        yield 'widget name in upper camelcase' => ['FooBaz', 'content-widget-foo-baz'];
    }
}
