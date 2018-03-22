//------------------------------------------------------------------------------------
// Filter Bar ScrewDefaultButtons v2.0.6 Adjustments

(function (e, t, n, r) {
    'use strict';
    var i = {
        init: function (t) {
            var n = e.extend({image: null, width: 50, height: 50, disabled: !1}, t);
            return this.each(function () {
                var t = e(this), r = n.image, i = t.data("sdb-image");
                i && (r = i);
                r || e.error("There is no image assigned for ScrewDefaultButtons");
                t.wrap("<div >").css({display: "none"});
                var s = t.attr("class"), o = t.attr("onclick"), u = t.parent("div");
                u.addClass(s);
                u.attr("onclick", o);
                u.css({"background-image": r, width: n.width, height: n.height, cursor: "pointer"});
                var a = 0, f = -n.height;
                if (t.is(":disabled")) {
                    a = -(n.height * 2);
                    f = -(n.height * 3)
                }
                t.on("disableBtn", function () {
                    t.attr("disabled", "disabled");
                    a = -(n.height * 2);
                    f = -(n.height * 3);
                    t.trigger("resetBackground")
                });
                t.on("enableBtn", function () {
                    t.removeAttr("disabled");
                    a = 0;
                    f = -n.height;
                    t.trigger("resetBackground")
                });
                t.on("resetBackground", function () {
                    t.is(":checked") ? u.css({backgroundPosition: "0 " + f + "px"}) : u.css({backgroundPosition: "0 " + a + "px"})
                });
                t.trigger("resetBackground");
                if (t.is(":checkbox")) {
                    u.on("click", function () {
                        t.is(":disabled") || t.change()
                    });
                    u.addClass("styledCheckbox");
                    t.on("change", function () {
                        if (t.prop("checked")) {
                            t.prop("checked", !1);
                            u.css({backgroundPosition: "0 " + a + "px"})
                        } else {
                            t.prop("checked", !0);
                            u.css({backgroundPosition: "0 " + f + "px"})
                        }
                    })
                } else if (t.is(":radio")) {
                    u.addClass("styledRadio");
                    var l = t.attr("name");
                    u.on("click", function () {
                        !t.prop("checked") && !t.is(":disabled") && t.change()
                    });
                    t.on("change", function () {
                        if (t.prop("checked")) {
                            t.prop("checked", !1);
                            u.css({backgroundPosition: "0 " + a + "px"})
                        } else {
                            t.prop("checked", !0);
                            u.css({backgroundPosition: "0 " + f + "px"});
                            var n = e('input[name="' + l + '"]').not(t);
                            n.trigger("radioSwitch")
                        }
                    });
                    t.on("radioSwitch", function () {
                        u.css({backgroundPosition: "0 " + a + "px"})
                    });
                    var c = e(this).attr("id"), h = e('label[for="' + c + '"]');
                    h.on("click", function () {
                        u.trigger("click")
                    })
                }
                if (!e.support.leadingWhitespace) {
                    var c = e(this).attr("id"), h = e('label[for="' + c + '"]');
                    h.on("click", function () {
                        u.trigger("click")
                    })
                }
            })
        }, check: function () {
            return this.each(function () {
                var t = e(this);
                i.isChecked(t) || t.change()
            })
        }, uncheck: function () {
            return this.each(function () {
                var t = e(this);
                i.isChecked(t) && t.change()
            })
        }, toggle: function () {
            return this.each(function () {
                var t = e(this);
                t.change()
            })
        }, disable: function () {
            return this.each(function () {
                var t = e(this);
                t.trigger("disableBtn")
            })
        }, enable: function () {
            return this.each(function () {
                var t = e(this);
                t.trigger("enableBtn")
            })
        }, isChecked: function (e) {
            return e.prop("checked") ? !0 : !1
        }
    };
    e.fn.screwDefaultButtons = function (t, n) {
        if (i[t]) return i[t].apply(this, Array.prototype.slice.call(arguments, 1));
        if (typeof t == "object" || !t) return i.init.apply(this, arguments);
        e.error("Method " + t + " does not exist on jQuery.screwDefaultButtons")
    };
    return this
})(jQuery);
