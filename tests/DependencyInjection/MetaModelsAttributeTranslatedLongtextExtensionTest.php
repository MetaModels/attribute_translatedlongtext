<?php

/**
 * This file is part of MetaModels/attribute_translatedlongtext.
 *
 * (c) 2012-2025 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels/attribute_translatedlongtext
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @author     Ingolf Steinhardt <info@e-spin.de>
 * @copyright  2012-2025 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_translatedlongtext/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

namespace MetaModels\AttributeTranslatedLongtextBundle\Test\DependencyInjection;

use InspiredMinds\ContaoFileUsage\ContaoFileUsageBundle;
use MetaModels\AttributeTranslatedLongtextBundle\DependencyInjection\MetaModelsAttributeTranslatedLongtextExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * This test case test the extension.
 *
 * @covers \MetaModels\AttributeTranslatedLongtextBundle\DependencyInjection\MetaModelsAttributeRatingExtension
 *
 * @SuppressWarnings(PHPMD.LongClassName)
 */
class MetaModelsAttributeTranslatedLongtextExtensionTest extends TestCase
{
    public function testInstantiation(): void
    {
        $extension = new MetaModelsAttributeTranslatedLongtextExtension();

        $this->assertInstanceOf(MetaModelsAttributeTranslatedLongtextExtension::class, $extension);
        $this->assertInstanceOf(ExtensionInterface::class, $extension);
    }

    public function testFactoryIsRegistered(): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles', [ContaoFileUsageBundle::class]);

        $extension = new MetaModelsAttributeTranslatedLongtextExtension();
        $extension->load([], $container);

        self::assertTrue($container->hasDefinition('metamodels.attribute_translatedlongtext.factory'));
        $definition = $container->getDefinition('metamodels.attribute_translatedlongtext.factory');
        self::assertCount(1, $definition->getTag('metamodels.attribute_factory'));
    }
}
