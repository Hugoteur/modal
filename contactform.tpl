<div id="contactModal" class="custom-modal" >
    <div class="custom-modal-content">
        <span id="closeModalButton" class="custom-modal-close">&times;</span>
        <form id="customContactForm">
            <label for="contact_email">Email:</label>
            <input type="email" id="contact_email" name="contact_email" required />

            <label for="contact_message">Message:</label>
            <textarea id="contact_message" name="contact_message" required></textarea>

            {if $displayGDPR}
                {$displayGDPR nofilter}
            {/if}

            <button type="submit" class="btn btn-primary">Send</button>
        </form>
        <div id="formFeedback"></div>
    </div>
</div>

<script>
    const ajaxUrl = '{$link->getModuleLink('evncontactform', 'submit')}';
</script>
<script src="{$module_dir}views/js/contactform.js"></script>