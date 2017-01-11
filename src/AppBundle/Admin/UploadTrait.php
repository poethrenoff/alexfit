<?php
namespace AppBundle\Admin;

use AppBundle\Lib\Transliterator;

trait UploadTrait
{
    private $uploadFields = array();
    
    abstract public function configureUploadFields();
    
    public function addUploadField($fieldName, array $fieldDescription) {
        $this->uploadFields[$fieldName] = $fieldDescription;
        
        return $this;
    }
    
    public function prePersist($object)
    {
        parent::prePersist($object);
                
        $this->manageFileUpload($object);
    }

    public function preUpdate($object)
    {
        parent::preUpdate($object);
        
        $this->manageFileUpload($object);
    }

    public function manageFileUpload($object)
    {
        $this->configureUploadFields();
        
        foreach ($this->uploadFields as $field) {
            $methodGetFileField = 'get' . $field['file_field'];
            $methodSetFileField = 'set' . $field['file_field'];
            $methodSetTargetField = 'set' . $field['target_field'];
            
            $upload_directory = $field['upload_directory'];
            $upload_alias = $field['upload_alias'];
            
            if (!is_null($object->$methodGetFileField())) {
                $newFileName = Transliterator::transliterate(
                    $object->$methodGetFileField()->getClientOriginalName()
                );
                
                $object->$methodGetFileField()->move($upload_directory, $newFileName);

                $object->$methodSetTargetField($upload_alias . $newFileName);

                $object->$methodSetFileField(null);
            }
        }
    }
}
