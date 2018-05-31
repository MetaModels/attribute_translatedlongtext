<?php

/**
 * This file is part of MetaModels/attribute_translatedlongtext.
 *
 * (c) 2012-2018 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * @package     MetaModels
 * @subpackage  AttributeTranslatedLongtext
 * @author      Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author      Andreas Isaak <info@andreas-isaak.de>
 * @author      Christopher Boelter <christopher@boelter.eu>
 * @author      David Maack <maack@men-at-work.de>
 * @author      Sven Baumann <baumann.sv@gmail.com>
 * @copyright   2012-2018 The MetaModels team.
 * @license     https://github.com/MetaModels/attribute_translatedlongtext/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

/**
 * Table tl_metamodel_attribute
 */

/**
 * Add palette configuration.
 */
$GLOBALS['TL_DCA']['tl_metamodel_attribute']['metapalettes']['translatedlongtext extends _complexattribute_'] = [];

/**
 * Add data provider.
 */
$GLOBALS['TL_DCA']['tl_metamodel_attribute']['dca_config']['data_provider']['tl_metamodel_translatedlongtext'] = [
    'source' => 'tl_metamodel_translatedlongtext'
];

/**
 * Add child condition.
 */
$GLOBALS['TL_DCA']['tl_metamodel_attribute']['dca_config']['childCondition'][] = [
    'from'   => 'tl_metamodel_attribute',
    'to'     => 'tl_metamodel_translatedlongtext',
    'setOn'  => [
        [
            'to_field'   => 'att_id',
            'from_field' => 'id',
        ],
    ],
    'filter' => [
        [
            'local'     => 'att_id',
            'remote'    => 'id',
            'operation' => '=',
        ],
    ]
];
