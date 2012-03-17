<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Class Parser');

			t3lib_extMgm::addLLrefForTCAdescr('tx_classparser_domain_model_abstractobject', 'EXT:classparser/Resources/Private/Language/locallang_csh_tx_classparser_domain_model_abstractobject.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_classparser_domain_model_abstractobject');
			$TCA['tx_classparser_domain_model_abstractobject'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:classparser/Resources/Private/Language/locallang_db.xml:tx_classparser_domain_model_abstractobject',
					'label' => 'name',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/AbstractObject.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_classparser_domain_model_abstractobject.gif'
				),
			);

?>