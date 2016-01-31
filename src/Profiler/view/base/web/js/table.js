define([
    'jquery',
    'jquery/jquery.cookie',
    'jquery/ui',
    'Mirasvit_Profiler/js/lib/jquery.treetable',
    'Mirasvit_Profiler/js/lib/jquery.tablesorter',
    'Mirasvit_Profiler/js/lib/jquery.filtertable'
], function ($) {
    'use strict';

    var methods = {
        init: function (options) {
            var $table = this;

            $table.treetable({
                expandable: true
            });

            $table.tablesorter({
                callback: function (term, table) {
                    $table.treetable('expandAll');
                }
            });

            $table.bind("sortStart", function () {
                $table.treetable('expandAll');
            });


            $table.filterTable({
                callback: function (term, table) {
                    $table.treetable('expandAll');
                }
            });

            if ($table.attr('data-threshold')) {
                var max = 0;
                var min = 1000000;
                $('[data-threshold-value]', $table).each(function (i, tr) {
                    var value = parseInt($(tr).attr('data-threshold-value'));
                    if (value > max) {
                        max = value;
                    }
                    if (value < max) {
                        min = value;
                    }
                });

                var $threshold = $($table.attr('data-threshold'));
                $threshold.slider({
                    min: min,
                    max: max,
                    value: min,
                    slide: function (event, ui) {
                        $table.treetable('expandAll');

                        $('[data-threshold-value]', $table).each(function (i, tr) {
                            var value = $(tr).attr('data-threshold-value');
                            if (value > ui.value) {
                                $(tr).show();
                            } else {
                                $(tr).hide();
                            }
                        });

                        $(".value", this).html(ui.value + " ms");
                    }
                });
            }
        }
    };

    $.fn.profilerTable = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        }
    };
});
