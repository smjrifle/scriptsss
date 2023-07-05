<?php
require("feed/includes/classes.php");
class Smjrifle_Magento2Amazon_SettingsController extends Mage_Adminhtml_Controller_Action {
    //globalVars
    public $disabledCategories = array();
    public $feedStatus = array();
    public $messages = array();

    //IndexAction
    public function indexAction()
    {
        $params = $this->getRequest()->getParams();
        if($params[0] != null) {
            $this->messages['message'] = $params[0];
        }
        $this->setup();
        $this->loadLayout();
        $this->syncAction();
        die();
        $this->_addContent($this->getLayout()->createBlock('adminhtml/template')->setTemplate('smjrifle/magento2amazon/index.phtml'));
        $this->getdisabledAction();
        $feedStatus = $this->getfeedstatusAction();
        $fstatus = array();
        foreach ($feedStatus as $status) {
            $fstatus['id'] = $status['FeedSubmissionId'];
            $fstatus['type'] = $status['FeedType'];
            $fstatus['data'] = $status['SubmittedDate'];
            $fstatus['status'] = $status['FeedProcessingStatus'];
            array_push($this->feedStatus, $fstatus);
        }
        Mage::register('feedstatus', $this->feedStatus);
        Mage::register('disabledCategories', $this->disabledCategories);
        Mage::register('messages', $this->messages);
        $this->renderLayout();
    }	

    //Initial Setup
    public function setup() {
        $query = Mage::getSingleton('core/resource')->getConnection('core_read');
        $result = $query->query("SELECT config_value FROM `smjrifle_magento2amazon_config`");
        $row = $result->fetch();
        if(count($row) >= 0) {
            if($row['config_value'] == 1) {
                return;
            }
            //Initially setup all category to be uploaded
            $cat = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('*');
            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $i = 0;
            foreach ($cat as $category) {
                $write->query("Insert into smjrifle_magento2amazon  values(null," . $category->entity_id . " , 'never', 1)");
                $i++;
            }
            $write->query("Update smjrifle_magento2amazon_config set config_value = 1");
            $this->messages['message'] = $i . " categories added";
        }
        else {
            $this->messages['message'] = "Please setup the plugin first by running feed";
        }
    }

    //remove From Sync
    public function removeAction(){
        $params = $this->getRequest()->getParams();
        $cat = Mage::getResourceModel('catalog/category_collection')->addFieldToFilter('name', $params['category']);
        if(count($cat) >= 1) {
            $categoryId = $cat->getFirstItem()->getEntityId();
            echo "Found " . $categoryId;
            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $write->query("Update smjrifle_magento2amazon set enabled = 0 where cat = " . $categoryId);
            $this->messages['message'] = "Category " . $params['category'] . " has been removed from sync!!!";
        }
        else {
            $this->messages['message'] = "Category " . $params['category'] . " not found!!!";
        }
        $this->_redirect('magento2amazon/settings/index', array($this->messages['message']));
    }

    //Reenable To Sync
    public function addAction(){
        $params = $this->getRequest()->getParams();
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $write->query("Update smjrifle_magento2amazon set enabled = 1 where cat = " . $params[1]);
        $this->messages['message'] = "Category " . $params['category'] . " has been added back to sync!!!";
        $this->_redirect('magento2amazon/settings/index', array($this->messages['message']));
    }

    //Get Disabled Items
    public function getdisabledAction(){
        $cats = array();
        $query = Mage::getSingleton('core/resource')->getConnection('core_read');
        $result = $query->query("Select * from smjrifle_magento2amazon where enabled = 0");
        while($row = $result->fetch()) {
            $cat =  Mage::getModel('catalog/category')->load($row['cat']);
            $cats['entity_id'] = $row['cat'];
            $cats['name'] = $cat->getName();
            array_push($this->disabledCategories, $cats);
        }
    }

    //Check Feed Status
    function getfeedstatusAction(){
    //autoload classes, not needed if composer is being used
        try {
            $amz=new AmazonFeedList("WBFooter");
        $amz->setTimeLimits('- 24 hours'); //limit time frame for feeds to any updated since the given time
        $amz->setFeedStatuses(array("_SUBMITTED_", "_IN_PROGRESS_", "_DONE_")); //exclude cancelled feeds
        $amz->fetchFeedSubmissions(); //this is what actually sends the request
        return $amz->getFeedList();
    } catch (Exception $ex) {
        echo 'There was a problem with the Amazon library. Error: '.$ex->getMessage();
    }
}


//Add Feed 
function syncAction() {
    $feed = '<?xml version="1.0" encoding="iso-8859-1"?>
    <AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
    <Header>
        <DocumentVersion>1.01</DocumentVersion>
        <MerchantIdentifier>ATVPDKIKX0DER</MerchantIdentifier>
    </Header>
    <MessageType>Product</MessageType>
    <PurgeAndReplace>false</PurgeAndReplace>';
    $productAry = array();
    $message = '';
    $query = Mage::getSingleton('core/resource')->getConnection('core_read');
    $k = 1;
    $result = $query->query("Select * from smjrifle_magento2amazon where enabled = 1");
    while($row = $result->fetch()) {
        // $cat =  Mage::getModel('catalog/category')->load($row['cat']);
        // $collection = $cat->getProductCollection()->addAttributeToSort('position');
        // // print_r($collection);die();
        // $collection = Mage::getModel('catalog/layer')->prepareProductCollection($collection);

        // foreach ($collection as $product) {
        //     print_r($product->getData());die();
            // if(!in_array($product->getName(), $productAry)) {
            //     print_r( $product->getName() );
            //     array_push($productAry, $product->getName);
            // }
        // }

        $products = Mage::getModel('catalog/category')->load($row['cat'])
        ->getProductCollection()
        ->addAttributeToSelect('*')
        // ->addAttributeToFilter('status', 1)
        ->setOrder('price', 'ASC');

        foreach ($products as $product) {
            if(!in_array($product->getUpc(), $productAry)) {
                if($product->getUpc() != null || $product->getUpc() != '') {
                    $message = $message . '<Message>
                    <MessageID>' . $k++ . '</MessageID>
                    <OperationType>Update</OperationType>
                    <Product>
                        <SKU>' . $product->getSku() . '</SKU>
                        <StandardProductID>
                            <Type>UPC</Type>
                            <Value>' . $product->getUpc() . '</Value>
                        </StandardProductID>
                        <ProductTaxCode>A_GEN_NOTAX</ProductTaxCode>
                        <DescriptionData>
                            <Title>' . $product->getName() . '</Title>
                            <Brand>' . $product->getBrand() . '</Brand>
                            <Description>' . $product->getDescription(). '</Description>
                            <BulletPoint>Example Bullet Point 123</BulletPoint>
                            <BulletPoint>Example Bullet Point 23</BulletPoint>
                            <MSRP currency="USD">' . $product->getPrice() . '</MSRP>
                            <Manufacturer>' . $product->getManufacture() . '</Manufacturer>
                            <ItemType>example-item-type ' . $k . '</ItemType>
                        </DescriptionData>
                    </Product>
                </Message>
                ';
            }
            array_push($productAry, $product->getUpc());
        }
    }
}

$feed = $feed . $message;
$feed = $feed . '</AmazonEnvelope>';
echo '<pre>' . $feed . '</pre>';
// print_r($this->sendInventoryFeed($feed));
}

public function sendInventoryFeed($feed) {
    try {
        $amz=new AmazonFeed("WBFooter"); //store name matches the array key in the config file
        $amz->setFeedType("_POST_PRODUCT_DATA_"); //feed types listed in documentation
        $amz->setFeedContent($feed); //can be either XML or CSV data; a file upload method is available as well
        $amz->submitFeed(); //this is what actually sends the request
        return $amz->getResponse();
    } catch (Exception $ex) {
        echo 'There was a problem with the Amazon library. Error: '.$ex->getMessage();
    }
}
}