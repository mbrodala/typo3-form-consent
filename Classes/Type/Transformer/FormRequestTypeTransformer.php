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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace EliasHaeussler\Typo3FormConsent\Type\Transformer;

use EliasHaeussler\Typo3FormConsent\Type;
use JsonException;
use TYPO3\CMS\Core;
use TYPO3\CMS\Extbase;
use TYPO3\CMS\Form;

/**
 * FormRequestTypeTransformer
 *
 * @author Elias Häußler <elias@haeussler.dev>
 * @license GPL-2.0-or-later
 */
final class FormRequestTypeTransformer implements TypeTransformer
{
    public function __construct(
        private readonly Extbase\Security\Cryptography\HashService $hashService,
    ) {
    }

    /**
     * @return Type\JsonType<string, array<string, array<string, mixed>>>
     * @throws JsonException
     */
    public function transform(Form\Domain\Runtime\FormRuntime $formRuntime): Type\JsonType
    {
        $request = $formRuntime->getRequest();

        // Handle submitted form values
        $requestParameters = [];
        if (\is_array($request->getParsedBody())) {
            $requestParameters = $request->getParsedBody();
        }

        // Handle uploaded files
        $uploadedFiles = $request->getUploadedFiles();
        array_walk_recursive($uploadedFiles, function (&$value, string $elementIdentifier) use ($formRuntime): void {
            $file = $formRuntime[$elementIdentifier];
            if ($file instanceof Extbase\Domain\Model\FileReference || $file instanceof Core\Resource\FileReference) {
                $value = $this->transformUploadedFile($file);
            }
        });

        Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($requestParameters, $uploadedFiles);

        return Type\JsonType::fromArray($requestParameters);
    }

    /**
     * @return array{submittedFile: array{resourcePointer: string}}
     */
    private function transformUploadedFile(Core\Resource\FileReference|Extbase\Domain\Model\FileReference $file): array
    {
        if ($file instanceof Extbase\Domain\Model\FileReference) {
            $file = $file->getOriginalResource();
        }

        $file = $file->getOriginalFile();

        return [
            'submittedFile' => [
                'resourcePointer' => $this->hashService->appendHmac('file:' . $file->getUid()),
            ],
        ];
    }
}
