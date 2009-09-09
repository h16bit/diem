<?php

class dmConfigForm extends dmForm
{

  public function configure()
  {
  }
  
  public function addSettings(array $settings)
  {
    foreach($settings as $setting)
    {
      $this->addSetting($setting);
    }
  }
  
  public function addSetting(DmSetting $setting)
  {
    $settingName = $setting->get('name');
    
    $this->widgetSchema[$settingName] = $this->getSettingWidget($setting);
    
    $this->widgetSchema[$settingName]->setDefault($setting->get('value'));
    
    $this->widgetSchema->setHelp($settingName, htmlentities($setting->get('description')));
    
    $this->validatorSchema[$settingName] = $this->getSettingValidator($setting);
    $this->validatorSchema[$settingName]->setOption('required', false);
  }
  
  public function removeSetting($settingName)
  {
    unset($this[$settingName]);
  }
  
  public function getSettingWidget(DmSetting $setting)
  {
    $method = 'get'.dmString::camelize($setting->type).'SettingWidget';
    
    return $this->$method($setting);
  }

  public function getSettingValidator(DmSetting $setting)
  {
    $method = 'get'.dmString::camelize($setting->type).'SettingValidator';
    
    return $this->$method($setting);
  }

  //Type Textarea
  protected function getTextSettingWidget(DmSetting $setting)
  {
    return new sfWidgetFormInputText(array(), $setting->getOptionsArray());
  }
  protected function getTextSettingValidator(DmSetting $setting)
  {
    return new sfValidatorString();
  }

  //Type Textarea
  protected function getTextareaSettingWidget(DmSetting $setting)
  {
    return new sfWidgetFormTextarea(array(), $setting->getOptionsArray());
  }
  protected function getTextareaSettingValidator(DmSetting $setting)
  {
    return new sfValidatorString();
  }

  // Type Number
  protected function getNumberSettingWidget(DmSetting $setting)
  {
    return new sfWidgetFormInputText(array(), $setting->getOptionsArray());
  }
  protected function getNumberSettingValidator(DmSetting $setting)
  {
    return new sfValidatorNumber();
  }

  // Type Boolean
  protected function getBooleanSettingWidget(DmSetting $setting)
  {
    return new sfWidgetFormInputCheckbox(array(), $setting->getOptionsArray());
  }
  protected function getBooleanSettingValidator(DmSetting $setting)
  {
    return new sfValidatorBoolean();
  }

  //Type Select List
  protected function getSelectSettingWidget(DmSetting $setting)
  {
    return new sfWidgetFormSelect(array('choices' => $setting->getOptionsArray()));
  }
  protected function getSelectSettingValidator(DmSetting $setting)
  {
    return new sfValidatorChoice(array('choices' => array_keys($setting->getOptionsArray())));
  }

}