<?php

class ConditionalRecipientUserDefinedFormRecipientExtension extends DataExtension {
	
	private static $db = array(
		'ConditionFieldValue' => 'Varchar(255)',
	);
	
	private static $has_one = array(
		'ConditionField' => 'EditableFormField',
	);
	
	private static $casting = array(
        'ConditionLabel' => 'Varchar'
    );
	
	private static $summary_fields = array(
		'ConditionLabel' => 'Condition',
	);
	
	public function updateCMSFields(FieldList $fields) {
		$formID = ($this->owner->FormID != 0) ? $this->owner->FormID : Session::get('CMSMain.currentPage');
		$formFields = EditableFormField::get()->filter('ParentID', (int)$formID);
		if ($formFields) {
			$source = $formFields->map('ID', 'Title');
			$fields->push(
				DropdownField::create('ConditionFieldID', 'Only send this email if the following field', $source)
					->setEmptyString('Select...')
			);
			$fields->push(TextField::create('ConditionFieldValue', '...has this value'));
		}
	}
	
	public function getConditionLabel() {
		$field = $this->owner->ConditionField();
		if( $field->ID ) {
			return "$field->Title equals '{$this->owner->ConditionFieldValue}'";
		}
	}
}