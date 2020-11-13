<?php

namespace Jellygnite\Elements\Model;

use Colymba\BulkUpload\BulkUploader;
use DNADesign\Elemental\Models\BaseElement;
use Jellygnite\Elements\Model\FileListObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\ORM\FieldType\DBField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class ElementFileList extends BaseElement
{
    /**
     * @var string
     */
    private static $icon = 'font-icon-block-file-list';

    /**
     * @var string
     */
    private static $table_name = 'ElementFileList';

    /**
     * @var array
     */
    private static $has_many = [
        'Files' => FileListObject::class,
    ];

    /**
     * @var array
     */
    private static $owns = [
        'Files',
    ];

    /**
     * @var bool
     */
    private static $inline_editable = false;

    /**
     * @param bool $includerelations
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        $labels['Files'] = _t(__CLASS__.'.FilesLabel', 'Files');

        return $labels;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            if ($this->ID) {
                $field = $fields->dataFieldByName('Files');
                $fields->removeByName('Files');

                $config = $field->getConfig();
                $config
                    ->addComponents([
                        new GridFieldOrderableRows('SortOrder')
                    ])
                    ->removeComponentsByType([
                        GridFieldAddExistingAutocompleter::class,
                        GridFieldDeleteAction::class
                    ]);
                if (class_exists(BulkUploader::class)) {
                    $config->addComponents([
                        new BulkUploader()
                    ]);
                    $config->getComponentByType(BulkUploader::class)
                        ->setUfSetup('setFolderName', 'uploads/filelist/');
                }
                $fields->addFieldToTab('Root.Main', $field);
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        if ($this->Files()->count() == 1) {
            $label = ' file';
        } else {
            $label = ' files';
        }
        return DBField::create_field('HTMLText', $this->Files()->count() . $label)->Summary(20);
    }

    /**
     * @return array
     */
    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getSummary();
        return $blockSchema;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return _t(__CLASS__.'.BlockType', 'File List');
    }
}
