<?php
namespace M12\Foundation\TypoScript;

/*                                                                        *
 * This script belongs to the M12.Foundation package                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\TYPO3CR\Domain\Model\Node;
use TYPO3\Neos\TypoScript\ContentCollectionImplementation as NeosContentCollectionImplementation;
use TYPO3\Flow\Annotations as Flow;

/**
 * Overrides Neos ContentCollections
 *
 * @todo This is an artifact after times when this implementation was
 *       removing wrapping div.content-collection. Now this functionality
 *       is moved to M12.Utils:WrapRemover.
 * @todo Method setDefaultProperties() should be removed to some more
 *       appropriate place (eg. triggered by event when node is initially inserted).
 */
class ContentCollectionImplementation extends NeosContentCollectionImplementation {

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * M12.FoundationGrid settings
	 *
	 * @param array $settings
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * Inside live workspace, it does NOT render extra DIV.content-collection.
	 *
	 * This is rather dirty/temporary hack as it breaks the rule, that rendered markup
	 * is the same in the Neos back-end and in the front-end.
	 *
	 * @return string
	 */
	public function evaluate() {
		$contentCollectionNode = $this->getContentCollectionNode();
		if ($contentCollectionNode === null) {
			return parent::evaluate();
		}

		$this->setDefaultProperties($contentCollectionNode);

		return parent::evaluate();
    }

	/**
	 * Set essential default properties on some nodes
	 *
	 * E.g. when Grid with 2 columns is inserted, it sets default size for each column,
	 * before user sets its own values.
	 *
	 * This is experimental, probably there's a better way to inject these properties.
	 *
	 * @param Node $contentCollectionNode
	 */
	protected function setDefaultProperties(Node $contentCollectionNode) {
		$parentNode = $contentCollectionNode->getParent();
		$parentNodeType = $parentNode->getNodeType()->getName();
		$nodeType = $contentCollectionNode->getNodeType()->getName();

		switch ($parentNodeType) {
			// Set 1st tab as active tab (otherwise all are hidden and it's hard to add any content there.
			case 'M12.Foundation:Tabs2':
			case 'M12.Foundation:Tabs3':
			case 'M12.Foundation:Tabs4':
			case 'M12.Foundation:Tabs5':
			case 'M12.Foundation:Tabs6':
				// already set?
				if ($contentCollectionNode->getProperty('activeTab'))
					break;

				// otherwise check if any child has it set
				/** @var Node[] $children */
				if (!($children = $parentNode->getChildNodes()))
					break;

				foreach ($children as $node) {
					if ($node->getProperty('activeTab'))
						break;
				}

				// pick up the 1st tab and mark it as active
				$node = array_shift($children);
				$node->setProperty('activeTab', true);
				$this->persistenceManager->persistAll();
				break;
		}

		switch ($nodeType) {
			case 'M12.Foundation:Column':
			case 'M12.Foundation:ColumnEnd':
				$gridSize = $this->settings['gridSize'];
				// extract num of columns from 'M12.Foundation:GridRowXCol' node type
				$columns = (int)substr($parentNodeType, strlen('M12.Foundation:GridRow'), 1);

				// In case M12.Foundation:Column has been placed as a child of element
				// different than M12.Foundation:GridColumnsX, make sure we do not divide by 0!
				$defaultColumns = $columns ? floor($gridSize / $columns) : $gridSize;

				$sizeSettings = array();
				foreach (array_keys($this->settings['devices']) as $device) {
					$name = 'class'.ucfirst($device).'Size';
					$sizeSettings[$name] = $contentCollectionNode->getProperty($name);
				}
				if (!array_filter($sizeSettings)) {
					$keys = array_keys($sizeSettings);
					$property = $keys[0];
					$contentCollectionNode->setProperty($property, 'small-'.$defaultColumns);
					$this->persistenceManager->persistAll();
				}
				break;
		}
	}
}
