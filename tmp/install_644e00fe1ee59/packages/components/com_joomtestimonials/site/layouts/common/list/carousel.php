<?php
/**
 * @copyright	Copyright (c) 2013 - 2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;
extract($displayData);
$doc = JFactory::getDocument();

$display_list_type = $layoutparams->get('display_list_type');
$carousel = (array)$layoutparams->get('carousel');

// Swiper params
$autoplay              = $carousel['autoplay'];
$slideShadows          = $carousel['slideshadows'];
$autoplaydelay         = $carousel['autoplaydelay'];
$effect                = $carousel['effect'];
$loop                  = $carousel['loop'];
$grabcursor            = $carousel['grapcursor'];
$loopblank             = $carousel['loopblank'];
$item480               = $carousel['item480'];
$item768               = $carousel['item768'];
$item1024              = $carousel['item1024'];
$autoheight            = $carousel['autoheight'];
$cItemHeight           = $carousel['citemheight'];

// swiper
$autoplaycode = '';

if($autoplay){
    $autoplaycode = "autoplay: {
        delay: $autoplaydelay
        },";
}

HTMLHelper::_('script', 'media/com_joomtestimonials/js/swiper.min.js');
$doc->addStyleSheet(JUri::root(TRUE).'/media/com_joomtestimonials/css/swiper.min.css');



$js_swiper    =
    <<<EOF
		// global scope variable
		var jtCarousel$id;

            window.addEventListener('load',function(){
            
      jtCarousel$id = new Swiper('#$tagId .swiper-container', {
        $autoplaycode
        autoHeight: $autoheight,
        setWrapperSize: true,
        navigation: {
            nextEl: '#$tagId  .swiper-button-next',
            prevEl: '#$tagId  .swiper-button-prev',
        },
        scrollbar: {
            el: '#$tagId .swiper-scrollbar',
            hide: false,
        },
        slidesPerView: $item1024,
        spaceBetween: 30,
        effect: '$effect',
        grabCursor: $grabcursor,
        centeredSlides: true,        
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows : $slideShadows,
        },
        fadeEffect: {
            crossFade: true
        },
        loop: $loop,
        loopFillGroupWithBlank: $loopblank,
        pagination: {
        el: '#$tagId .swiper-pagination',
        dynamicBullets: true,
      },
        breakpoints: {
            480: {
              slidesPerView: $item480,
              spaceBetween: 10,
            },
            768: {
              slidesPerView: $item768,
              spaceBetween: 20,
            },
            1024: {
              slidesPerView: $item1024,
              spaceBetween: 30,
            }
  }    
    });
       
    });
EOF;


$doc->addScriptDeclaration($js_swiper);


if($autoheight == "true")
    $doc->addStyleDeclaration("
		#$tagId .swiper-container-autoheight, 
		#$tagId .swiper-container-autoheight .swiper-slide, 
		#$tagId .swiper-container-autoheight .swiper-slide > div{
			height: $cItemHeight !important
		}");

// carousel navigation buttons color
$navbuttonscolor        = $carousel['navbuttons_color'];
if(!empty($navbuttonscolor) && $display_list_type == 'carousel'){
    $doc->addStyleDeclaration("
        #$tagId .swiper-button-next, #$tagId .swiper-button-prev{            
            color: $navbuttonscolor;        
        }
    ");
}

// Show navigation buttons on hover
if($carousel['navbuttons_onhover'] && $display_list_type == 'carousel'){
    $doc->addStyleDeclaration("
        #$tagId .swiper-button-next, #$tagId .swiper-button-prev{            
            display: none;
            transition: display 2s ease-out;    
        }
        
        #$tagId:hover .swiper-button-next, #$tagId:hover .swiper-button-prev{
            display: block;
        }     
        
    ");
}



