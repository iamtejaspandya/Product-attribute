<?php
namespace Tejas\ProductAttr\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Api\Data\AttributeOptionInterface;
use Magento\Eav\Api\Data\AttributeOptionInterfaceFactory;
use Magento\Eav\Api\AttributeOptionManagementInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class DropdownOptions implements DataPatchInterface
{
    private $moduleDataSetup;
    private $attributeOptionInterfaceFactory;
    private $attributeOptionManagement;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        AttributeOptionInterfaceFactory $attributeOptionInterfaceFactory,
        AttributeOptionManagementInterface $attributeOptionManagement
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->attributeOptionInterfaceFactory = $attributeOptionInterfaceFactory;
        $this->attributeOptionManagement = $attributeOptionManagement;
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $attributeCode = 'custom_dropdown_attribute';
        $attributeOptions = [
            ['label' => 'Task', 'value' => 'task'],
            ['label' => 'Done', 'value' => 'done'],        
        ];

        foreach ($attributeOptions as $option) {
            $optionData = $this->attributeOptionInterfaceFactory->create();
            $optionData->setLabel($option['label']);
            $optionData->setValue($option['value']);

            $this->attributeOptionManagement->add(Product::ENTITY, $attributeCode, $optionData);
        }

        $this->moduleDataSetup->endSetup();
    }

    public static function getDependencies()
    {
        return [
            DropdownAttribute::class
        ];
    }

    public function getAliases()
    {
        return [];
    }
}
