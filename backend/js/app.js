(function($) {
    "use strict";

    var AdvanceFormApp = function() {
        this.$body = $("body");
        this.$window = $(window);
    };

    AdvanceFormApp.prototype.initSelect2 = function() {
        $('[data-toggle="select2"]').select2();
    };

    AdvanceFormApp.prototype.initMask = function() {
        $('[data-toggle="input-mask"]').each(function() {
            var maskFormat = $(this).data("maskFormat");
            var reverse = $(this).data("reverse");
            if (reverse !== null) {
                $(this).mask(maskFormat, { reverse: reverse });
            } else {
                $(this).mask(maskFormat);
            }
        });
    };

    AdvanceFormApp.prototype.initDateRange = function() {
        var dateRangeOptions = {
            cancelClass: "btn-light",
            applyButtonClasses: "btn-success"
        };

        $('[data-toggle="date-picker"]').each(function() {
            var options = $.extend({}, dateRangeOptions, $(this).data());
            $(this).daterangepicker(options);
        });

        var defaultDateRange = {
            startDate: moment().subtract(29, "days"),
            endDate: moment(),
            ranges: {
                Today: [moment(), moment()],
                Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
            }
        };

        $('[data-toggle="date-picker-range"]').each(function() {
            var options = $.extend({}, defaultDateRange, $(this).data());
            var targetDisplay = options.targetDisplay;
            $(this).daterangepicker(options, function(start, end) {
                if (targetDisplay) {
                    $(targetDisplay).html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
                }
            });
        });
    };

    AdvanceFormApp.prototype.init = function() {
        this.initSelect2();
        this.initMask();
        this.initDateRange();
    };

    $.AdvanceFormApp = new AdvanceFormApp();
    $.AdvanceFormApp.Constructor = AdvanceFormApp;

})(window.jQuery);

(function($) {
    "use strict";

    var Components = function() {};

    Components.prototype.initTooltipPlugin = function() {
        if ($.fn.tooltip) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    };

    Components.prototype.initPopoverPlugin = function() {
        if ($.fn.popover) {
            $('[data-toggle="popover"]').popover();
        }
    };

    Components.prototype.initCustomSelect = function() {
        $('[data-plugin="customselect"]').niceSelect();
    };

    Components.prototype.initSlimScrollPlugin = function() {
        if ($.fn.slimScroll) {
            $(".slimscroll").slimScroll({
                height: "auto",
                position: "right",
                size: "8px",
                touchScrollStep: 20,
                color: "#9ea5ab"
            });
        }
    };

    Components.prototype.initFormValidation = function() {
        $(".needs-validation").on("submit", function(event) {
            var form = $(this);
            form.addClass("was-validated");
            if (form[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
        });
    };

    Components.prototype.init = function() {
        this.initTooltipPlugin();
        this.initPopoverPlugin();
        this.initCustomSelect();
        this.initSlimScrollPlugin();
        this.initFormValidation();
    };

    $.Components = new Components();
    $.Components.Constructor = Components;

})(window.jQuery);

(function($) {
    "use strict";

    var App = function() {
        this.$body = $("body");
        this.$window = $(window);
    };

    App.prototype.initMenu = function() {
        var _this = this;
        $(".button-menu-mobile").on("click", function(event) {
            event.preventDefault();
            if (_this.$window.width() < 768) {
                _this.$body.toggleClass("sidebar-enable");
            }
            $(".slimscroll-menu").slimscroll({
                height: "auto",
                position: "right",
                size: "8px",
                color: "#9ea5ab",
                wheelStep: 5,
                touchScrollStep: 20
            });
        });

        $("#side-menu").metisMenu();

        $(".slimscroll-menu").slimscroll({
            height: "auto",
            position: "right",
            size: "8px",
            color: "#9ea5ab",
            wheelStep: 5,
            touchScrollStep: 20
        });

        $(".right-bar-toggle").on("click", function() {
            $("body").toggleClass("right-bar-enabled");
        });

        $(document).on("click", "body", function(event) {
            if (!$(event.target).closest(".right-bar-toggle, .right-bar, .left-side-menu, #sidebar-menu, .button-menu-mobile").length) {
                $("body").removeClass("right-bar-enabled sidebar-enable");
            }
        });

        $("#sidebar-menu a").each(function() {
            var currentUrl = window.location.href.split(/[?#]/)[0];
            if (this.href === currentUrl) {
                $(this).addClass("active").parent().addClass("active in");
                $(this).parent().parent().addClass("in");
                $(this).parent().parent().prev().addClass("active");
                $(this).parent().parent().parent().addClass("active");
                $(this).parent().parent().parent().parent().addClass("in");
                $(this).parent().parent().parent().parent().parent().addClass("active");
            }
        });
    };

    App.prototype.initLayout = function() {
        if (this.$window.width() >= 768 && this.$window.width() <= 1028) {
            this.$body.addClass("enlarged");
        } else if (this.$body.data("keep-enlarged") !== 1) {
            this.$body.removeClass("enlarged");
        }
    };

    App.prototype.init = function() {
        var _this = this;
        this.initLayout();
        this.initMenu();
        $.AdvanceFormApp.init();
        $.Components.init();
        this.$window.on("resize", function(event) {
            event.preventDefault();
            console.log("resized");
            _this.initLayout();
        });
    };

    $.App = new App();
    $.App.Constructor = App;

})(window.jQuery);

(function($) {
    "use strict";

    $.App.init();

})(window.jQuery);