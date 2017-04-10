<?php
/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */
require_once('./Modules/DataCollection/classes/Fields/Text/class.ilDclTextFieldRepresentation.php');
require_once('./Customizing/global/plugins/Services/Cron/CronHook/DclContentImporter/classes/Helper/class.srDclContentImporterMultiLineInputGUI.php');
require_once('./Customizing/global/plugins/Services/Cron/CronHook/DclContentImporter/classes/class.ilDclContentImporterPlugin.php');
require_once('./Services/Form/classes/class.ilNumberInputGUI.php');
require_once('class.ilPHBernMultiTextPlugin.php');

/**
 * Class ilPHBernMultiTextFieldRepresentation
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class ilPHBernMultiTextFieldRepresentation extends ilDclTextFieldRepresentation  {

	/**
	 * @var ilDclFieldTypePlugin
	 */
	protected $pl;

	/**
	 * ilPHBernConditionalReferenceFieldRepresentation constructor.
	 *
	 * @param ilDclBaseFieldModel $field
	 */
	public function __construct(ilDclBaseFieldModel $field) {
		$this->pl = ilPHBernMultiTextPlugin::getInstance();

		parent::__construct($field);
	}

	public function getInputField(ilPropertyFormGUI $form, $record_id = 0) {
		$multi_line = new srDclContentImporterMultiLineInputGUI($this->getField()->getTitle(), 'field_' . $this->getField()->getId());
		$multi_line->setTemplateDir(ilDclContentImporterPlugin::getInstance()->getDirectory());

		$limit = $this->getField()->getProperty(ilPHBernMultiTextFieldModel::PROP_MAX_SELECTABLE);

		if ($limit) {
			$multi_line->setLimit($limit);
			$multi_line->setInfo(sprintf($this->pl->txt('max'), $limit));
		}

		$input = new ilDclTextInputGUI($this->getField()->getTitle(), 'text');

		if ($this->getField()->hasProperty(ilDclBaseFieldModel::PROP_LENGTH)) {
			if (!$this->getField()->getProperty(ilDclBaseFieldModel::PROP_TEXTAREA)) {
				$input->setMaxLength($this->getField()->getProperty(ilDclBaseFieldModel::PROP_LENGTH));
			}
		}

		$multi_line->addInput($input);
		return $multi_line;
	}


	public function buildFieldCreationInput(ilObjDataCollection $dcl, $mode = 'create') {
		$opt = ilDclBaseFieldRepresentation::buildFieldCreationInput($dcl, $mode);

		$prop_length = new ilNumberInputGUI($this->lng->txt('dcl_length'), $this->getPropertyInputFieldId(ilDclBaseFieldModel::PROP_LENGTH));
		$prop_length->setSize(5);
		$prop_length->setMaxValue(4000);
		$prop_length->setInfo($this->lng->txt('dcl_length_info'));

		$opt->addSubItem($prop_length);

		$mandatory_fields = new ilNumberInputGUI($this->pl->txt('mandatory_fields'), 'prop_' .ilPHBernMultiRefFieldModel::PROP_MANDATORY_FIELDS);
		$opt->addSubItem($mandatory_fields);

		$max_selectable = new ilNumberInputGUI($this->pl->txt('max_selectable'), 'prop_' .ilPHBernMultiRefFieldModel::PROP_MAX_SELECTABLE);
		$opt->addSubItem($max_selectable);

		return $opt;
	}
}