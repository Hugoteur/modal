<?php

class EvncontactformSubmitModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        if (Tools::isSubmit('ajax')) {
            // Log the incoming request for debugging
            error_log('AJAX Request Received: ' . print_r($_POST, true));

            // Gather inputs
            $email = Tools::getValue('contact_email');
            $message = Tools::getValue('contact_message');
            $gdprConsent = Tools::getValue('psgdpr_consent_checkbox');

            // Validate inputs
            if (!Validate::isEmail($email)) {
                $this->ajaxDie(json_encode(['success' => false, 'error' => 'Invalid email address.']));
            }

            if (empty($message)) {
                $this->ajaxDie(json_encode(['success' => false, 'error' => 'Message cannot be empty.']));
            }

            if ($gdprConsent !== '1') {
                $this->ajaxDie(json_encode(['success' => false, 'error' => 'You must agree to the GDPR terms.']));
            }

            // Attempt to send email
            $mailSent = Mail::Send(
                $this->context->language->id,
                'contact',
                'New Contact Message',
                ['{email}' => $email, '{message}' => nl2br($message)],
                Configuration::get('PS_SHOP_EMAIL'),
                null,
                $email,
                null
            );

            if ($mailSent) {
                $this->ajaxDie(json_encode(['success' => true, 'message' => 'Message sent successfully!']));
            } else {
                $this->ajaxDie(json_encode(['success' => false, 'error' => 'Failed to send the message.']));
            }
        }

        // Fallback for non-AJAX requests (redirect to homepage)
        Tools::redirect($this->context->link->getPageLink('index'));
    }
}
