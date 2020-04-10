<?php

namespace Tools\ContactForm\Traits;

trait Contact
{
    private $requiredFieldMessage;
    private $minLengthFieldMessage;
    private $maxLengthFieldMessage;
    private $emailFieldMessage;
    private $phoneFieldMessage;
    private $minDateFieldMessage;
    private $maxDateFieldMessage;
    private $minChoiceFieldMessage;
    private $maxChoiceFieldMessage;
    private $filesizeFieldMessage;
    private $fillAllRequiredFieldMessage;
    private $formObject;

    public function __contruct()
    {
        $this->requiredFieldMessage = get_field('required_field_message', 'option');
        $this->minLengthFieldMessage = get_field('minlength_field_message', 'option');
        $this->maxLengthFieldMessage = get_field('maxlength_field_message', 'option');
        $this->emailFieldMessage = get_field('email_field_message', 'option');
        $this->phoneFieldMessage = get_field('phone_field_message', 'option');
        $this->minDateFieldMessage = get_field('min_date_field_message', 'option');
        $this->maxDateFieldMessage = get_field('max_date_field_message', 'option');
        $this->minChoiceFieldMessage = get_field('min_choice_field_message', 'option');
        $this->maxChoiceFieldMessage = get_field('max_choice_field_message', 'option');
        $this->filesizeFieldMessage = get_field('filesize_field_message', 'option');
        $this->fillAllRequiredFieldMessage = get_field('fill_all_required_fields', 'option');
        $this->formObject = get_field('contact_form');
    }

    public function requiredFieldMessage()
    {
        return $this->requiredFieldMessage;
    }

    public function minLengthFieldMessage()
    {
        return $this->minLengthFieldMessage;
    }

    public function maxLengthFieldMessage()
    {
        return $this->maxLengthFieldMessage;
    }

    public function emailFieldMessage()
    {
        return $this->emailFieldMessage;
    }

    public function phoneFieldMessage()
    {
        return $this->phoneFieldMessage;
    }

    public function minDateFieldMessage()
    {
        return $this->minDateFieldMessage;
    }

    public function maxDateFieldMessage()
    {
        return $this->maxDateFieldMessage;
    }

    public function minChoiceFieldMessage()
    {
        return $this->minChoiceFieldMessage;
    }

    public function maxChoiceFieldMessage()
    {
        return $this->maxChoiceFieldMessage;
    }

    public function filesizeFieldMessage()
    {
        return $this->filesizeFieldMessage;
    }

    public function fillAllRequiredFieldMessage()
    {
        return $this->fillAllRequiredFieldMessage;
    }

    public function formObject()
    {
        foreach ($this->formObject as $key => $value) {
            $this->formObject[$key]['name'] = $value['acf_fc_layout'] . '_' . $key;
        }

        return $this->formObject;
    }
}
