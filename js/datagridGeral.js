(function (factory) {
                if (typeof define === 'function' && define.amd) {
                    // AMD
                    define(['jquery', 'datatables.net'], function ($) {
                        return factory($, window, document);
                    });
                }
                else if (typeof exports === 'object') {
                    // CommonJS
                    module.exports = function (root, $) {
                        if (!root) {
                            root = window;
                        }

                        if (!$ || !$.fn.dataTable) {
                            $ = require('datatables.net')(root, $).$;
                        }

                        return factory($, root, root.document);
                    };
                }
                else {
                    // Browser
                    factory(jQuery, window, document);
                }
            }(function ($, window, document, undefined) {
                'use strict';

// Unique value allowing multiple absolute ordering use cases on a single page.
                var _unique = 0;

// Function to encapsulate code that is common to both the string and number
// ordering plug-ins.
                var _setup = function (values) {
                    if (!$.isArray(values)) {
                        values = [values];
                    }

                    var o = {
                        name: 'absoluteOrder' + (_unique++),
                        alwaysTop: {},
                        alwaysBottom: {}
                    };

                    // In order to provide performance, the symbols that are to be looked for
                    // are stored as parameter keys in an object, allowing O(1) lookup, rather
                    // than O(n) if it were in an array.
                    for (var i = 0, ien = values.length; i < ien; i++) {
                        var conf = values[i];

                        if (typeof conf === 'string') {
                            o.alwaysTop[ conf ] = true;
                        }
                        else if (conf.position === undefined || conf.position === 'top') {
                            o.alwaysTop[ conf.value ] = true;
                        }
                        else {
                            o.alwaysBottom[ conf.value ] = true;
                        }
                    }

                    // Ascending ordering method
                    o.asc = function (a, b, isNumber) {
                        if (o.alwaysTop[ a ] || o.alwaysBottom[ b ]) {
                            return -1;
                        }
                        else if (o.alwaysBottom[ a ] || o.alwaysTop[ b ]) {
                            return 1;
                        }

                        if (isNumber) {
                            // Cast as a number if required
                            if (typeof a === 'string') {
                                a = a.replace(/[^\d\-\.]/g) * 1;
                            }
                            if (typeof b === 'string') {
                                b = b.replace(/[^\d\-\.]/g) * 1;
                            }
                        }

                        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                    };

                    // Descending ordering method
                    o.desc = function (a, b, isNumber) {
                        if (o.alwaysTop[ a ] || o.alwaysBottom[ b ]) {
                            return -1;
                        }
                        else if (o.alwaysBottom[ a ] || o.alwaysTop[ b ]) {
                            return 1;
                        }

                        if (isNumber) {
                            if (typeof a === 'string') {
                                a = a.replace(/[^\d\-\.]/g) * 1;
                            }
                            if (typeof b === 'string') {
                                b = b.replace(/[^\d\-\.]/g) * 1;
                            }
                        }

                        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                    };

                    return o;
                };

// String based ordering
                $.fn.dataTable.absoluteOrder = function (values) {
                    var conf = _setup(values);

                    $.fn.dataTable.ext.type.order[ conf.name + '-asc' ] = conf.asc;
                    $.fn.dataTable.ext.type.order[ conf.name + '-desc' ] = conf.desc;

                    // Return the name of the sorting plug-in that was created so it can be used
                    // with the `columns.type` parameter. There is no auto-detection here.
                    return conf.name;
                };

// Number based ordering - strips out everything but the number information
                $.fn.dataTable.absoluteOrderNumber = function (values) {
                    var conf = _setup(values);

                    $.fn.dataTable.ext.type.order[ conf.name + '-asc' ] = function (a, b) {
                        return conf.asc(a, b, true);
                    };
                    $.fn.dataTable.ext.type.order[ conf.name + '-desc' ] = function (a, b) {
                        return conf.asc(a, b, true);
                    };

                    return conf.name;
                };


            }));


            $(document).ready(function () {

                $('#tblDados').DataTable({
                    
                    "language": {
                        "decimal":        ",",
                        "thousands":      ".",
                        "lengthMenu": "Exibir _MENU_ registros por página",
                        "zeroRecords": "Nenhum registro encontrado",
                        "info": "Exibir _PAGE_ de _PAGES_ página(s)",
                        "infoEmpty": "Nenhum registro encontrado",
                        "infoFiltered": "(De um total de _MAX_ registros)",
                        "search": "Filtrar:",
                        "paginate": {
                            "first": "Primeiro",
                            "last": "Último",
                            "next": "Próximo",
                            "previous": "Anterior"
                        },
                    }
                });
            });

