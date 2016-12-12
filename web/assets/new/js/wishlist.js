(function (document, window, $) {

    'use strict';

    var wishlistModel;
    var storageKey = 'wishlist';
    var itemTpl;
    var emptyTpl;
    var $docEl = $(document.documentElement);

    function persist(data) {
        localStorage.setItem(storageKey, JSON.stringify(data));
    }

    function hydrate() {
        return JSON.parse(localStorage.getItem(storageKey));
    }

    function model() {
        var store = {
            items: [],
            itemsByIds: {}
        };

        return {
            init: function(data) {
                if (data) {
                    store = data;
                }
            },
            getCount: function() {
                return store.items.length;
            },
            getAll: function() {
                return store.items.map(function(id) {
                    return store.itemsByIds[id];
                });
            },
            getOne: function(id) {
                return store.itemsByIds[id];
            },
            add: function(item) {
                item.updatedAt = Date.now();

                if (this.getOne(item.id)) {
                    store.itemsByIds[item.id] = item;
                } else {
                    store.itemsByIds[item.id] = item;
                    store.items.push(item.id);
                }

                persist(store);
                render(this.getAll());
            },
            remove: function(id) {
                var index = store.items.indexOf(id);

                if (index > -1) {
                    store.items.splice(index, 1);
                }

                delete store.itemsByIds[id];
                persist(store);
                render(this.getAll());
            }
        }
    }

    function handleButtonState(el) {
        var $el = $(el);
        var data = $el.data('boat');
        var source = $el.data('source');

        // unfortrunately, the only way to get the dates is to read the inputs on add
        $.extend(data, {
            checkin: $('.js-date-range-from').val(),
            checkout: $('.js-date-range-to').val()
        });

        // if on the boat page, the url and price will change with every basket change
        // so it's necessary to query these data when adding to wishlist
        if (source === 'view') {
            data.url = window.location.href;
            data.price = $('.js-wishlist-price').text()
        }

        if ($el.hasClass('is-in')) {
            $el.addClass('is-out').removeClass('is-in');
            wishlistModel.remove(data.id);
        } else {
            $el.addClass('is-in').removeClass('is-out');
            wishlistModel.add(data);
        }
    }

    function determineButtonState(el) {
        var $el = $(el);
        var data = $el.data('boat');

        if (wishlistModel.getOne(data.id)) {
            var action = $el.attr('data-track-action');
            var altAction = $el.attr('data-track-action-alt');

            $el.addClass('is-in').removeClass('is-out');
            $el.attr('data-track-action', altAction);
            $el.attr('data-track-action-alt', action);
        } else {
            $el.addClass('is-out').removeClass('is-in');
        }
    }

    function determineButtonStates() {
        $('.js-wishlist-toggle').each(function(i, el) {
            determineButtonState(el);
        });

        setItemCount();
    }

    function setItemCount() {
        $('.js-header-menu[data-target=".js-wishlist-menu"]')
            .attr('data-track-value', wishlistModel.getCount());
    }

    function renderItem(item) {
        var EMPTY = '-';

        return itemTpl
            .replace('{IMAGE}', item.image)
            .replace('{NAME}', item.name)
            .replace('{LOCATION}', item.location)
            .replace('{LENGTH}', item.length || EMPTY)
            .replace('{CABINS}', item.cabins || EMPTY)
            .replace('{GUESTS}', item.guests || EMPTY)
            .replace('{PRICE}', item.price || EMPTY)
            .replace('{CHECKIN}', item.checkin || EMPTY)
            .replace('{CHECKOUT}', item.checkout || EMPTY)
            .replace(/{URL}/g, item.url)
            .replace(/{ID}/g, item.id);
    }

    function render(items) {
        var $wishlistEl = $('.js-wishlist');

        if (items.length) {
            $wishlistEl.html(items.map(renderItem).join(''));
        } else {
            $wishlistEl.html(emptyTpl);
        }
    }

    function init() {
        itemTpl = document.getElementById('wishlist-item');
        emptyTpl = document.getElementById('wishlist-empty');

        if (itemTpl && emptyTpl) {
            itemTpl = itemTpl.innerHTML;
            emptyTpl = emptyTpl.innerHTML;

            wishlistModel = model();
            wishlistModel.init(hydrate());

            render(wishlistModel.getAll());

            $docEl.on('click', '.js-wishlist-toggle', function(e) {
                handleButtonState(this);
                setItemCount();
            });

            $docEl.on('click', '.js-wishlist-remove', function(e) {
                wishlistModel.remove(e.target.getAttribute('data-id'));
                determineButtonStates();
            });

            determineButtonStates();
            radio('ajaxSuccess').subscribe(determineButtonStates);
        } else {
            console.log('Wishlist: #wishlist-item and #wishlist-empty not found');
        }
    }

    if ('localStorage' in window) {
        if (
            typeof localStorage.getItem === 'function'
            && typeof localStorage.setItem === 'function'
        ) {
            $(document).ready(init);
        } else {
            console.error('Wishlist: localStorage is disabled');
        }
    } else {
        console.error('Wishlist: browser does not support localStorage');
    }

}(document, window, jQuery));
