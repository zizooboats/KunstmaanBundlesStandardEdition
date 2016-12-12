(function (document, $, radio) {

    'use strict';

    var locale = document.documentElement.lang;
    var $body = $(document.body);

    function init() {
        var $backdropEl = $('<div class="site-search-backdrop"></div>');

        $('.js-autocomplete').each(function() {
            var $el = $(this);
            var config = $el.data('config');

            if (config) {
                if (config.sitewide) {
                    $el.selectize({
                        valueField: 'id',
                        labelField: 'name',
                        searchField: 'name',
                        optgroupField: 'group',
                        optgroups: [
                            { value: 'posts', label: locale === 'de'? 'Verwandte Artikel' : 'Related Articles' },
                            { value: 'latest', label: locale === 'de'? 'Neueste Artikel' : 'Latest Articles' },
                            { value: 'locations', label: locale === 'de'? 'Reiseziele' : 'Locations' },
                            { value: 'suggested', label: locale === 'de'? 'Empfohlene Reiseziele' : 'Suggested Locations' },
                            { value: 'boats', label: locale === 'de'? 'Boote' : 'Boats' },
                            { value: 'recommended', label: locale === 'de'? 'Beliebte Boote' : 'Recommended Boats' }
                        ],
                        lockOptgroupOrder: true,
                        options: [],
                        create: false,
                        score: function(search) {
                            return function(item) {
                                return 1;
                            };
                        },
                        render: {
                            option: function(data, escape) {
                                var tmpl = [
                                    '<a href="{URL}" class="option">',
                                    '   <img src="{IMAGE}" class="option-image" width="45" height="35">',
                                    '   <span class="option-name">{NAME}</span>',
                                    '</a>',
                                ].join('');

                                return tmpl
                                    .replace('{URL}', data.url)
                                    .replace('{NAME}', data.name)
                                    .replace('{IMAGE}', data.image ? data.image : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC0AAAAjCAMAAAA3znPYAAAAGFBMVEXc3NxDRUuXmJvo6Oiys7Tf399wcnbHx8hbYQ1fAAABT0lEQVR42o3U0YrDMAxEUWmk0fz/H6+kLPShbpILKZieGmPHNRrfNtZed9aM4AvNaBeUUi+0EmlCeeWjpuXAci9ZxIMekX5VSPJWh8E/FW7nDqsPlRKiGXnWNNTF5xMRYezHeNQhqBZ3zWkUJJDnuSO90A7YdRiZVfixbgYq0qEq2yUoZzMhnvckM7LUD4ykcbSXnfUOU4xysb2qhivOmteI5TAaHOlVN3NvhJdZeRpAIOxep7vg4K7M+KDlDi++ug0M8y6NvNGcoom0GrIZb99aU8rgaLynaj2evudumQmgWlXjfbe2TH1pktHlzovGU0Z3XMkWq+YQt4q7PaEN+1TGd7rQZdxpi/QrLAYsbjSVqGvinADFL82ghP/2F3uZzzoMCikT2TZzziX64UHvpa+MsJk/tRs9359vsVKWVVBzkc//seT1Vqw9a07G54x/dI4LAyez4xwAAAAASUVORK5CYII=');
                            }
                        },
                        onItemAdd: function(value, $item) {
                            var url = $item
                                .closest('.selectize-control')
                                .find('.option[data-value="' + value + '"]')
                                .attr('href');

                            window.location.href = url;
                        },
                        load: function(query, callback) {
                            var self = this;

                            if (!query.length) { return callback(); }

                            $.ajax({
                                url: config.source,
                                type: 'GET',
                                dataType: 'json',
                                data: {
                                    term: query
                                },
                                error: function() {
                                    callback();
                                },
                                success: function(res) {
                                    self.clearOptions();
                                    callback(concatArrays(res));
                                }
                            });
                        },
                        onDropdownOpen: function($dropdown) {
                            $backdropEl.prependTo('body');
                            $body.addClass('u-no-scroll');
                        },
                        onDropdownClose: function($dropdown) {
                            $backdropEl.detach();
                            $body.removeClass('u-no-scroll');
                        },
                    });
                } else {
                    $el.selectize({
                        valueField: 'id',
                        labelField: 'name',
                        searchField: 'name',
                        options: [],
                        create: false,
                        onInitialize: function() {
                            radio('searchAutocompleteInit').broadcast();
                        },
                        onChange: function(val) {
                            if (config.publishChange && $el.attr('name')) {
                                radio($el.attr('name') + 'DropdownChange').broadcast(val);
                            }
                        },
                        load: function(query, callback) {
                            if (!query.length) { return callback(); }

                            $.ajax({
                                url: config.source,
                                type: 'GET',
                                dataType: 'json',
                                data: {
                                    term: query
                                },
                                error: function() {
                                    callback();
                                },
                                success: function(res) {
                                    if (config.sitewide) {
                                        callback(concatArrays(res));
                                    } else {
                                        callback(res);
                                    }
                                }
                            });
                        }
                    });
                }
            } else {
                console.log('.js-autocomplete: no config found');
            }
        });

        function concatArrays(obj) {
            return Object.keys(obj).reduce(function(arr, key) {
                return arr.concat(obj[key]);
            }, []);
        }

        $('.js-dropdown').each(function() {
            var $el = $(this);
            var config = $el.data();

            $el.selectize({
                create: false,
                sortField: 'text',
                onInitialize: function() {
                    if (config.unset) {
                        $el.data('selectize').clear();
                    }

                    radio('searchDropdownInit').broadcast();
                },
                onChange: function(val) {
                    if (config.publishChange && $el.attr('name')) {
                        radio($el.attr('name') + 'DropdownChange').broadcast(val);
                    }
                }
            });
        });

        $('select[data-publish-change]')
            .not('.js-autocomplete')
            .not('.js-dropdown')
            .each(function() {
                var $el = $(this);
                var config = $el.data();

                if (config.publishChange && $el.attr('name')) {
                    $el.on('change', function() {
                        radio($el.attr('name') + 'DropdownChange').broadcast($el.val());
                    });
                }
            });
    }

    $(document).ready(init);

}(document, jQuery, radio));
