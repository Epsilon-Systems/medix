/**
 * @package         Modals
 * @version         12.3.2
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://regularlabs.com
 * @copyright       Copyright © 2023 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

'use strict';

import {Helper} from './helper.js?12.3.2';
import {Slide} from './slide.js?12.3.2';

export function Modal(link, group) {
    this.group                = group;
    this.link                 = link;
    this.element              = null;
    this.elements             = {};
    this.events               = {};
    this.globalEventListeners = {};
    this.first                = true;
    this.status               = 'close';
    this.slides               = [];
    this.settings             = RegularLabs.Modals.settings;
    this.aciveSlide           = null;
    this.previousSlide        = null;
    this.preventOutsideClick  = false;
    this.autoclose_timeout    = null;
    this.slideshow            = null;
    this.slideshowResumeTimer = null;
    this.touchStartPosition   = null;

    const init = async () => {
        const createElements = () => {
            return new Promise((resolve) => {
                this.element    = Helper.createElementFromHtml(this.settings.htmlTemplates.modal);
                this.element.id = `rl_modal_${this.group}`;

                Helper.setData(this.element, 'theme', this.settings.theme);

                this.elements.overlay  = this.element.querySelector('[data-modals-element="overlay"]');
                this.elements.spinner  = this.element.querySelector('[data-modals-element="spinner"]');
                this.elements.main     = this.element.querySelector('[data-modals-element="main"]');
                this.elements.slides   = this.element.querySelector('[data-modals-element="slides"]');
                this.elements.closeBar = this.element.querySelector('[data-modals-element="close-bar"]');
                this.elements.close    = this.element.querySelector('[data-modals-element="close"]');

                resolve();
            });
        };

        const addEventListeners = () => {
            if (this.settings.showCloseButton && this.elements.close) {
                this.addEventListener(
                    this.elements.close,
                    'click',
                    (event) => {
                        this.close();
                        event.preventDefault();
                    }
                );

                Helper.show(this.elements.close);
            }

            if (this.elements.next) {
                this.addEventListener(
                    this.elements.next,
                    'click',
                    (event) => {
                        this.openNext();
                        event.preventDefault();
                    }
                );
            }

            if (this.elements.previous) {
                this.addEventListener(
                    this.elements.previous,
                    'click',
                    (event) => {
                        this.openPrevious();
                        event.preventDefault();
                    }
                );
            }

            if (this.settings.closeOnOutsideClick) {
                this.addEventListener(
                    this.element,
                    'click',
                    (event) => {
                        if ( ! Helper.hasData(event.target, 'close-on-click')) {
                            return;
                        }

                        this.close();
                    }
                );
            }

            this.addEventListener(
                this.element,
                'touchstart',
                (event) => {
                    if (event.touches.length > 1
                        || this.activeSlide.getType() !== 'image'
                        || ! this.activeSlide.elements.container.contains(event.target)
                    ) {
                        this.touchStartPosition = 0;
                        return;
                    }

                    this.touchStartPosition = event.changedTouches[0].screenX;
                }
            );

            this.addEventListener(
                this.element,
                'touchend',
                (event) => {
                    if (event.touches.length > 1
                        || ! this.touchStartPosition
                    ) {
                        return;
                    }

                    const touchEndX = event.changedTouches[0].screenX;

                    if (this.touchStartPosition > (touchEndX + this.settings.minimumTouchSlideMovement)) {
                        this.openNext();
                        return;
                    }

                    if (this.touchStartPosition < (touchEndX - this.settings.minimumTouchSlideMovement)) {
                        this.openPrevious();
                    }
                }
            );

        };

        const createSlides = () => {
            return new Promise(async (resolve) => {
                const links = document.querySelectorAll(`[data-modals-group="${this.group}"]`);

                for (const link of links) {
                    await this.createSlide(link);
                }

                resolve();
            });
        };


        const setSettings = () => {
            return new Promise((resolve) => {
                this.settings = Object.assign({}, this.settings);
                for (const setting in this.settings) {
                    const linkSetting = Helper.getData(this.link, setting);

                    if (linkSetting === undefined) {
                        continue;
                    }

                    this.settings[setting] = linkSetting;
                }

                resolve();
            });
        };

        await setSettings();
        await createElements();
        addEventListeners();
        await createSlides();

        

        if (Helper.getData(this.link, 'open')) {
            const delay = Helper.getData(this.link, 'open-delay');

            setTimeout(() => {
                this.open(this.slides[0]);
            }, delay ? delay : 0);
        }
    };

    init();
}

Modal.prototype = {
    addGlobalEventListeners: function() {
        if ( ! this.globalEventListeners.hasOwnProperty('keyboardNavigation')
            && this.settings.keyboardNavigation
        ) {
            this.globalEventListeners.keyboardNavigation = this.addEventListener(
                window,
                'keydown',
                (event) => {
                    switch (event.keyCode) {
                        case 9: // tab
                            this.handleTab(event);
                            break;

                        case 39: // right
                            if (this.slides.length > 1) {
                                this.openNext();
                            }
                            break;

                        case 37: // left
                            if (this.slides.length > 1) {
                                this.openPrevious();
                            }
                            break;

                        case 27: // esc
                            this.close();
                            break;

                        default:
                            break;
                    }
                }
            );
        }

    },

    handleTab: function() {
        const nextButton = event.shiftKey
            ? this.getPreviousFocusElement()
            : this.getNextFocusElement();

        if ( ! nextButton) {
            return;
        }

        event.preventDefault();

        if (nextButton) {
            nextButton.focus();
        }
    },

    getFocusElements: function() {
        const elements = document.querySelectorAll('button[data-modals-taborder]:not(.disabled):not(.active)');

        // remove elements that have display:none
        return Array.prototype.filter.call(elements, element => {
            return window.getComputedStyle(element).display !== "none";
        });
    },

    getFocusedElementTabOrder: function() {
        const focusedButton = document.querySelector('button[data-modals-taborder]:focus');

        return focusedButton ? Helper.getData(focusedButton, 'taborder') : 1;
    },

    getOrderedTabOrders: function(buttons) {
        const orders = [];

        buttons.forEach(button => {
            orders.push(parseInt(button.getAttribute('data-modals-taborder')));
        });

        orders.sort(function(a, b) {
            return a - b;
        });

        return orders;
    },

    getNextFocusElement: function() {
        const buttons = this.getFocusElements();

        if ( ! buttons.length) {
            return false;
        }

        if (buttons.length === 1) {
            return buttons[0];
        }

        const tabOrders       = this.getOrderedTabOrders(buttons);
        const lastTabOrder    = tabOrders[tabOrders.length - 1];
        const focusedTabOrder = this.getFocusedElementTabOrder();

        let newTabOrder = focusedTabOrder < 0 ? 1 : parseInt(focusedTabOrder) + 1;

        if (newTabOrder > lastTabOrder) {
            newTabOrder = 0;
        }

        const nextTabOrders = tabOrders.filter(function(el) {
            return el >= newTabOrder;
        });

        nextTabOrders.sort(function(a, b) {
            return a - b;
        });

        newTabOrder = nextTabOrders[0];

        return document.querySelector(`button[data-modals-taborder="${newTabOrder}"]`);
    },

    getPreviousFocusElement: function() {
        const buttons = this.getFocusElements();

        if ( ! buttons.length) {
            return false;
        }

        if (buttons.length === 1) {
            return buttons[0];
        }

        const tabOrders       = this.getOrderedTabOrders(buttons);
        const lastTabOrder    = tabOrders[tabOrders.length - 1];
        const focusedTabOrder = this.getFocusedElementTabOrder();

        let newTabOrder = focusedTabOrder < 0 ? 1 : parseInt(focusedTabOrder) - 1;

        if (newTabOrder < 1) {
            newTabOrder = lastTabOrder;
        }

        const previousTabOrders = tabOrders.filter(function(el) {
            return el <= newTabOrder;
        });

        previousTabOrders.sort(function(a, b) {
            return b - a;
        });

        newTabOrder = previousTabOrders[0];

        return document.querySelector(`button[data-modals-taborder="${newTabOrder}"]`);
    },

    open: async function(slide) {
        if ( ! slide) {
            slide = this.slides[0];
        }

        this.activeSlide = slide;

        if ( ! document.querySelector(`#${this.element.id}`)) {
            document.body.appendChild(this.element);
        }

        await this.updateStatus('open');
        Helper.hide(slide.element);

        this.addGlobalEventListeners();
        RegularLabs.Modals.hideBodyElements();

        Helper.getMainHtmlElement().classList.add('rl-modal-open');

        if ( ! Helper.getData(this.link, 'enable-page-scrolling')) {
            Helper.disablePageScrolling();
        }

        const effect = slide.settings.openEffect === 'none' ? 'none' : slide.settings.cssEffects.fade.in;

        await Helper.animate(
            this.element,
            effect,
            [async () => {
                this.updateStatus('opened');

                await this.loadSlide(slide);

            }]
        );
    },

    updateStatus: async function(status) {
        return new Promise((resolve) => {
            this.status = status;
            this.triggerEvent(status);

            resolve();
        });
    },

    triggerEvent: function(status) {
        if (typeof this.settings[`on${Helper.capitalize(status)}`] === 'function') {
            this.settings[`on${Helper.capitalize(state)}`]();
        }

        if (this.activeSlide && typeof this.activeSlide.eventListeners[status] === 'function') {
            this.activeSlide.eventListeners[status]();
        }
    },

    close: async function() {
        if (this.status === 'close' || this.status === 'closed') {
            return;
        }

        clearTimeout(this.autoclose_timeout);


        await this.updateStatus('close');

        this.removeGlobalEventListeners();

        RegularLabs.Modals.showBodyElements();

        Helper.animate(this.elements.overlay, this.settings.openEffect === 'none' ? 'none' : this.settings.cssEffects.fade.out);
        Helper.animate(this.elements.buttons, this.settings.openEffect === 'none' ? 'none' : this.settings.cssEffects.fade.out);

        if ( ! this.activeSlide) {
            return;
        }

        await this.activeSlide.hide(
            'close',
            [() => {
                this.updateStatus('closed');

                this.activeSlide   = null;
                this.previousSlide = null;

                Helper.enablePageScrolling();
                Helper.getMainHtmlElement().classList.remove('rl-modal-open');
                Helper.remove(this.element);
            }]
        );
    },

    openNext: async function() {
    },

    openPrevious: async function() {
    },

    preloadNext: function() {
    },

    getNextSlide: function() {
    },

    getPreviousSlide: function() {
    },

    loadSlide: async function(slide, effect) {

        if ( ! this.first
            && this.activeSlide && Helper.getData(this.activeSlide.element, 'animating')
        ) {
            // Don't open another slide if still in animation process
            return;
        }

        this.first = false;

        clearTimeout(this.autoclose_timeout);

        Helper.show(this.elements.spinner);

        await this.updateStatus('load');

        if ( ! effect) {
            effect = this.previousSlide
                ? (this.previousSlide.id > slide.id ? 'previous' : 'next')
                : 'open';
        }

        if (Helper.getData(slide.link, 'legacy')) {
            effect = 'legacy';
        }

        this.activeSlide = slide;

        this.hideInactiveSlides(effect);

        if (this.previousSlide) {
            this.previousSlide.hide(effect);
        }

        await slide.show(effect);

        Helper.hide(this.elements.spinner);

        await this.updateStatus('loaded');


        this.previousSlide = slide;
    },

    setActivePage: function() {
    },

    setAutoClose: function(delay) {
    },

    hideInactiveSlides: function() {
        this.slides.forEach((inactive_slide) => {
            if (inactive_slide === this.activeSlide
                || inactive_slide === this.previousSlide
            ) {
                return;
            }

            Helper.hide(inactive_slide.element);
        });
    },

    createSlide: async function(link) {
        return new Promise((resolve) => {
            const slide_id = this.slides.length;

            this.slides[slide_id] = null;
            Helper.setData(link, 'done', true);
            resolve(slide_id);

            this.slides[slide_id] = new Slide(this, link, slide_id);
        });
    },

    addEventListener: function(element, type, callback) {
        element.addEventListener(type, callback, true);

        return {
            element : element,
            type    : type,
            callback: callback
        };
    },

    removeGlobalEventListeners: function() {
        for (const event in this.globalEventListeners) {
            const listener = this.globalEventListeners[event];
            listener.element.removeEventListener(listener.type, listener.callback, true);
        }

        this.globalEventListeners = {};
    },

    startSlideshow: async function() {
    },

    getSlideshowInterval: function() {
    },

    stopSlideshow: function() {
    },
};
