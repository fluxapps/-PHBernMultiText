<?php
/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */
require_once('./Modules/DataCollection/classes/Fields/Text/class.ilDclTextRecordFieldModel.php');

/**
 * Class ilPHBernMultiTextRecordFieldModel
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class ilPHBernMultiTextRecordFieldModel extends ilDclTextRecordFieldModel {

	/**
	 * filter out empty entries
	 *
	 * @param ilPropertyFormGUI $form
	 */
	public function setValueFromForm($form) {
		$value = $form->getInput("field_" . $this->getField()->getId());
		foreach ($value as $k => $v) {
			$value[$k] = array_filter($v);
		}
		$value = array_values(array_filter($value));
		$this->setValue($value);
	}


}