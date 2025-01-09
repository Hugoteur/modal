<?php

if (!defined('_PS_VERSION_')) {
    exit;
}


class EvnContactForm extends Module
{
    public function __construct()
    {
        $this->name = 'evncontactform';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Your Name';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('EVN Contact Form');
        $this->description = $this->l('A simple test module.');
    }

    public function install()
	{
		return parent::install() && $this->registerHook('displayFooter');
	}
	
	public function hookDisplayFooter($params)
{
   $gdprContent = null;
if (Module::isInstalled('psgdpr') && Module::isEnabled('psgdpr')) {
    $gdprContent = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'psgdpr/views/templates/hook/displayGDPRConsent.tpl');
}

$this->context->smarty->assign([
    'ajaxUrl' => $this->context->link->getModuleLink('evncontactform', 'submit'),
    'displayGDPR' => $gdprContent,
]);

    return $this->display(__FILE__, 'views/templates/front/contactform.tpl');
}
}
