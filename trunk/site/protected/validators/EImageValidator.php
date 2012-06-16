<?php
/**
 * Validates image file on upload.
 * 
 * Validates it as a file, @see CFileValidator.
 * Defaults the file types to: jpg, png, gif, jpeg
 * 
 * Added validation to the maximal image dimensions.
 * 
 * @author Nikolay D.
 * @version 1.0
 */
class EImageValidator extends CFileValidator
{
    /** @var integer */
    public $maxWidth = null;
    
    /** @var integer */
    public $maxHeight = null;
    
    public $tooWide = 'Width can be upto {value} pixels.';
    
    public $tooTall = 'Height can be upto {value} pixels.';
    
    public $types=array('jpg', 'jpeg', 'png', 'gif');
    
    public $wrongType = 'Pleas upload only files like: jpg, jpeg, gif, png!';
    
    /**
     * Internaly validates the image file object.
     * 
     * @param CActiveRecord $object
     * @param string $attribute
     * @param CUploadedFile $file 
     */
    protected function validateFile($object, $attribute, $file) 
    {
        parent::validateFile($object, $attribute, $file);
        if( $object->hasErrors($attribute) )
            return;
        
        if( null === $this->maxWidth && null === $this->maxHeight )
            return;
        
        $this->maxWidth = (int)$this->maxWidth;
        $this->maxHeight = (int)$this->maxHeight;
        
        list($width, $height) = getimagesize($file->getTempName());
        
        if($this->maxWidth > 0 && $this->maxWidth < $width)
            $this->addError($object, $attribute, $this->tooWide, array(
                '{value}'=>$this->maxWidth
            ));
        
        if( $this->maxHeight > 0 && $this->maxHeight < $height)
            $this->addError($object, $attribute, $this->tooTall, array(
                '{value}'=>$this->maxHeight
            ));
    }
}
