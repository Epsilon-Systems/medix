Joomla.submitbutton = function (task) {
    if (Joomla.getOptions('com_joomtestimonials.form').isModal) {
        if (task == 'testimonial.cancel') {
            parent.document.querySelector(".iziModal-button-close").click()
        } else if (document.formvalidator.isValid(document.getElementById('adminForm'))) {
            Joomla.submitform(task);
        }
    } else {
        if (task == 'testimonial.cancel' || document.formvalidator.isValid(document.getElementById('adminForm'))) {
            Joomla.submitform(task);
        }
    }

}

// move custom fields position using field label class name.
jQuery(document).ready(function ($) {

    $('[class*=jt_after_]').each(function () {

        // get after position name
        let after_position_class = $(this).attr('class');
        let after_position_name = after_position_class.split("_")[2];

        $(this).parent().insertAfter('.predefined-field-' + after_position_name);


    });
});