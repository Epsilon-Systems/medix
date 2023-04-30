jQuery(document).ready(function($){



    // add jb_template id to sidebar to apply icons
    $('ul#submenu').parent().attr('id','jb_template');

    // add Class to distinguish if is parent or child
    $('ul#submenu > li').each(function(){

        if($(this).find('i').hasClass('isParent') == true){
            $(this).addClass('isParent');
        }else{
            $(this).addClass('isChild');
        }

    });

    // find and hide children
    $('ul#submenu > li.isParent').each(function(){

        let i = 0;

        $(this).nextUntil('li.isParent').each(function(){
            $(this).hide();
            i++;
        });

        if(i > 0){
            $(this).find('a').append('<span class="fas fa-angle-down subMenuControl"></span>');
        }

    })

    // find parent of active child

    $('.isChild.active').prevUntil('.isParent').prev().last().addClass('active').find('.fa-angle-down').toggleClass('fa-angle-up');

    $('.isParent.active').nextUntil('li.isParent').each(function(){

        $(this).show('fast');

    })

    // open or close parent on click
    $('.isParent').click(function(e){

        let i = 0;

        $(this).nextUntil('li.isParent').each(function(){
            $(this).slideToggle('fast');
            i++
        });

        if(i > 0){
            e.preventDefault();
        }

        $(this).find('.fa-angle-down,.fa-angle-up').toggleClass('fa-angle-down').toggleClass('fa-angle-up');

    });

});