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
 * @package    MetaModels
 * @subpackage AttributeTranslatedLongtext
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2012-2018 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_translatedlongtext/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

/**
 * Table tl_metamodel_translatedlongtext
 */
$GLOBALS['TL_DCA']['tl_metamodel_translatedlongtext'] = [
    // Config
    'config' => [
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'att_id,item_id,langcode' => 'index'
            ]
        ]
    ],
    // Fields
    'fields' => [
        'id'       => [
            'sql'                     => 'int(10) unsigned NOT NULL auto_increment'
        ],
        'tstamp'   => [
            'sql'                     => 'int(10) unsigned NOT NULL default \'0\''
        ],
        'att_id'   => [
            'sql'                     => 'int(10) unsigned NOT NULL default \'0\''
        ],
        'item_id'  => [
            'sql'                     => 'int(10) unsigned NOT NULL default \'0\''
        ],
        'langcode' => [
            'sql'                     => 'varchar(5) NOT NULL default \'\''
        ],
        'value'    => [
            'sql'                     => 'text NULL'
        ]
    ]
];
