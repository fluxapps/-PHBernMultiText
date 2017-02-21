<?php
/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */
require_once('./Modules/DataCollection/classes/Fields/Text/class.ilDclTextRecordRepresentation.php');

/**
 * Class ilPHBernMultiTextRecordRepresentation
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class ilPHBernMultiTextRecordRepresentation extends ilDclTextRecordRepresentation  {

	public function getHTML($link = true) {
		$value = $this->getRecordField()->getValue();
		if (!is_array($value)) {
			return "";
		}

		$return = "";
		foreach ($value as $v) {
			$return .= '- ' . $v['text'] . '<br>';
		}
		$return = substr($return, 0, -4);
		return $return;
	}
}