<?php

/**
 * This file is part of MetaModels/attribute_translatedlongtext.
 *
 * (c) 2012-2024 The MetaModels team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    MetaModels/attribute_translatedlongtext
 * @author     Ingolf Steinhardt <info@e-spin.de>
 * @copyright  2012-2024 The MetaModels team.
 * @license    https://github.com/MetaModels/attribute_translatedlongtext/blob/master/LICENSE LGPL-3.0-or-later
 * @filesource
 */

namespace MetaModels\AttributeTranslatedLongtextBundle\FileUsage;

use Contao\CoreBundle\Csrf\ContaoCsrfTokenManager;
use ContaoCommunityAlliance\DcGeneral\Data\ModelId;
use InspiredMinds\ContaoFileUsage\Provider\FileUsageProviderInterface;
use InspiredMinds\ContaoFileUsage\Result\ResultInterface;
use InspiredMinds\ContaoFileUsage\Result\ResultsCollection;
use MetaModels\AttributeTranslatedLongtextBundle\Attribute\TranslatedLongtext;
use MetaModels\CoreBundle\FileUsage\MetaModelsTranslatedSingleResult;
use MetaModels\IFactory;
use MetaModels\IMetaModel;
use MetaModels\ITranslatedMetaModel;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * This class supports the Contao extension 'file usage'.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class FileUsageProvider implements FileUsageProviderInterface
{
    // phpcs:disable
    private const INSERT_TAG_PATTERN = '~{{(file|picture|figure)::([a-f0-9]{8}-[a-f0-9]{4}-1[a-f0-9]{3}-[89ab][a-f0-9]{3}-[a-f0-9]{12})(([|?])[^}]+)?}}~';
    // phpcs:enable

    private string $refererId = '';

    public function __construct(
        private readonly IFactory $factory,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly RequestStack $requestStack,
        private readonly ContaoCsrfTokenManager $csrfTokenManager,
        private readonly string $csrfTokenName,
    ) {
    }

    public function find(): ResultsCollection
    {
        $this->refererId = $this->requestStack->getCurrentRequest()?->attributes->get('_contao_referer_id') ?? '';

        $collection = new ResultsCollection();
        foreach ($this->factory->collectNames() as $tableName) {
            $collection->mergeCollection($this->processTable($tableName));
        }

        return $collection;
    }

    private function processTable(string $table): ResultsCollection
    {
        $collection = new ResultsCollection();
        $metaModel  = $this->factory->getMetaModel($table);
        assert($metaModel instanceof IMetaModel);

        $attributes = [];
        foreach ($metaModel->getAttributes() as $attribute) {
            if (!$attribute instanceof TranslatedLongtext) {
                continue;
            }
            $attributes[] = $attribute;
        }

        $allIds = $metaModel->getIdsFromFilter($metaModel->getEmptyFilter());
        foreach ($this->getLanguagesForMetaModel($metaModel) as $language) {
            foreach ($attributes as $attribute) {
                $values = $attribute->getTranslatedDataFor($allIds, $language);
                $attributeColumn = $attribute->getColName();
                foreach ($values as $itemId => $value) {
                    \preg_match_all(self::INSERT_TAG_PATTERN, $value['value'], $matches);
                    foreach ($matches[2] ?? [] as $uuid) {
                        $collection->addResult(
                            $uuid,
                            $this->createFileResult($table, $attributeColumn, $itemId, $language)
                        );
                    }
                }
            }
        }

        return $collection;
    }

    /** @return iterable<int, string> */
    private function getLanguagesForMetaModel(IMetaModel $metaModel): iterable
    {
        if ($metaModel instanceof ITranslatedMetaModel) {
            foreach ($metaModel->getLanguages() as $language) {
                yield $language;
            }
            return;
        }
        /**
         * @psalm-suppress DeprecatedMethod
         * @psalm-suppress TooManyArguments
         */
        if ($metaModel->isTranslated(false)) {
            foreach ($metaModel->getAvailableLanguages() ?? [] as $language) {
                yield $language;
            }
        }
    }

    private function createFileResult(
        string $tableName,
        string $attributeName,
        string $itemId,
        string $language
    ): ResultInterface {
        return new MetaModelsTranslatedSingleResult(
            $tableName,
            $attributeName,
            $itemId,
            $language,
            $this->urlGenerator->generate(
                'metamodels.metamodel',
                [
                    'tableName' => $tableName,
                    'act'       => 'edit',
                    'id'        => ModelId::fromValues($tableName, $itemId)->getSerialized(),
                    'language'  => $language,
                    'ref'       => $this->refererId,
                    'rt'        => $this->csrfTokenManager->getToken($this->csrfTokenName)->getValue(),
                ]
            )
        );
    }
}
