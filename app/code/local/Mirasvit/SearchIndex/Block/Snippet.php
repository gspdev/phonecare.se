<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   Advanced Sphinx Search Pro
 * @version   2.3.25
 * @build     990
 * @copyright Copyright (C) 2017 Mirasvit (http://mirasvit.com/)
 */



class Mirasvit_SearchIndex_Block_Snippet extends Mage_Core_Block_Template
{
    public function getGoogleSitelinksSearch()
    {
        return Mage::getStoreConfig('searchsphinx/advanced/snippets');
    }
}