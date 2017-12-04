<?php

/**
 * This file is part of MetaModels/attribute_translatedlongtext.
 *
 * (c) 2012-2017 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels
 * @subpackage AttributeTranslatedLongtext
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2012-2017 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_longtext/blob/master/LICENSE LGPL-3.0
 * @filesource
 */

namespace MetaModels\AttributeTranslatedLongtextBundle\Test;

use MetaModels\AttributeTranslatedLongtextBundle\Attribute\AttributeTypeFactory;
use MetaModels\AttributeTranslatedLongtextBundle\Attribute\TranslatedLongtext;
use PHPUnit\Framework\TestCase;

/**
 * This class tests if the deprecated autoloader works.
 *
 * @package MetaModels\AttributeTranslatedLongtextBundle\Test
 */
class DeprecatedAutoloaderTest extends TestCase
{
    /**
     * TranslatedLongtextes of old classes to the new one.
     *
     * @var array
     */
    private static $classes = [
        'MetaModels\Attribute\TranslatedLongtext\TranslatedLongtext'       => TranslatedLongtext::class,
        'MetaModels\Attribute\TranslatedLongtext\AttributeTypeFactory' => AttributeTypeFactory::class
    ];

    /**
     * Provide the longtext class map.
     *
     * @return array
     */
    public function provideLongtextClassMap()
    {
        $values = [];

        foreach (static::$classes as $translatedLongtext => $class) {
            $values[] = [$translatedLongtext, $class];
        }

        return $values;
    }

    /**
     * Test if the deprecated classes are longtexted to the new one.
     *
     * @param string $oldClass Old class name.
     * @param string $newClass New class name.
     *
     * @dataProvider provideLongtextClassMap
     */
    public function testDeprecatedClassesAreLongtexted($oldClass, $newClass)
    {
        $this->assertTrue(class_exists($oldClass), sprintf('Class TranslatedLongtext "%s" is not found.', $oldClass));

        $oldClassReflection = new \ReflectionClass($oldClass);
        $newClassReflection = new \ReflectionClass($newClass);

        $this->assertSame($newClassReflection->getFileName(), $oldClassReflection->getFileName());
    }
}
