<?php

/*
 * This file is part of the TYPO3 CMS extension "form_consent".
 *
 * Copyright (C) 2021-2024 Elias Häußler <elias@haeussler.dev>
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

\EliasHaeussler\Typo3FormConsent\Extension::registerFormEngineNode();
\EliasHaeussler\Typo3FormConsent\Extension::registerPageTsConfig();
\EliasHaeussler\Typo3FormConsent\Extension::registerPlugin();
\EliasHaeussler\Typo3FormConsent\Extension::registerIcons();
\EliasHaeussler\Typo3FormConsent\Extension::registerGarbageCollectionTask();
\EliasHaeussler\Typo3FormConsent\Extension::registerUpgradeWizards();
