<?php

class ConditionalRecipientUserDefinedFormExtension extends DataExtension {
	
	public function updateFilteredEmailRecipients(ArrayList $recipients, $data, $form) {
		foreach( $recipients as $recipient ) {
			// check if condition set
			if (($field = $recipient->ConditionField()) && $field->ID) {
				// get field name
				$fieldName = $field->Name;
				// get condition value
				$conditionValue = $recipient->ConditionFieldValue;
				// get field value
				$fieldValue = "";
				if($field->hasMethod('getValueFromData')) {
					$fieldValue = $field->getValueFromData($data);
				} else {
					if(isset($data[$fieldName])) {
						$fieldValue = $data[$fieldName];
					}
				}
				// remove recipient if values don't match
				if( trim($fieldValue) != trim($conditionValue) ) {
					$recipients->remove($recipient);
				}
			}
		}
	}
	
}