if (void 0 === $.validator) throw new Error('jQuery Validation plugin not found. "appFormValidator" requires jQuery Validation >= v1.17.0');
function confirm_delete() {
    var e = "Are you sure you want to perform this action?";
    return "undefined" != typeof app && (e = app.lang.confirm_action_prompt), 0 != confirm(e);
}
!(function (i) {
    var r = !1;
    i.fn.appFormValidator = function (e) {
        var t = this,
            a = { email: { remote: i.fn.appFormValidator.internal_options.localization.email_exists } },
            n = {
                rules: [],
                messages: [],
                ignore: [],
                onSubmit: !1,
                submitHandler: function (e) {
                    var t = i(e);
                    t.hasClass("disable-on-submit") && t.find('[type="submit"]').prop("disabled", !0);
                    var a = t.find("[data-loading-text]");
                    if ((0 < a.length && a.button("loading"), !o.onSubmit)) return !0;
                    o.onSubmit(e);
                },
            },
            o = i.extend({}, n, e);
        return (
            void 0 === o.messages.email && (o.messages.email = a.email),
            (t.configureJqueryValidationDefaults = function () {
                if (r) return !0;
                (r = !0),
                    i.validator.setDefaults({
                        highlight: i.fn.appFormValidator.internal_options.error_highlight,
                        unhighlight: i.fn.appFormValidator.internal_options.error_unhighlight,
                        errorElement: i.fn.appFormValidator.internal_options.error_element,
                        errorClass: i.fn.appFormValidator.internal_options.error_class,
                        errorPlacement: i.fn.appFormValidator.internal_options.error_placement,
                    }),
                    t.addMethodFileSize(),
                    t.addMethodExtension();
            }),
            (t.addMethodFileSize = function () {
                i.validator.addMethod(
                    "filesize",
                    function (e, t, a) {
                        return this.optional(t) || t.files[0].size <= a;
                    },
                    i.fn.appFormValidator.internal_options.localization.file_exceeds_max_filesize
                );
            }),
            (t.addMethodExtension = function () {
                i.validator.addMethod(
                    "extension",
                    function (e, t, a) {
                        return (a = "string" == typeof a ? a.replace(/,/g, "|") : "png|jpe?g|gif"), this.optional(t) || e.match(new RegExp("\\.(" + a + ")$", "i"));
                    },
                    i.fn.appFormValidator.internal_options.localization.validation_extension_not_allowed
                );
            }),
            (t.validateCustomFields = function (e) {
                i.each(e.find(i.fn.appFormValidator.internal_options.required_custom_fields_selector), function () {
                    if (!i(this).parents("tr.main").length && !i(this).hasClass("do-not-validate") && (i(this).rules("add", { required: !0 }), i.fn.appFormValidator.internal_options.on_required_add_symbol)) {
                        var e = i(this)
                            .parents("." + i.fn.appFormValidator.internal_options.field_wrapper_class)
                            .find('[for="' + i(this).attr("name") + '"]');
                        0 < e.length && 0 === e.find(".req").length && e.prepend('<small class="req text-danger">* </small>');
                    }
                });
            }),
            (t.addRequiredFieldSymbol = function (n) {
                i.fn.appFormValidator.internal_options.on_required_add_symbol &&
                    i.each(o.rules, function (e, t) {
                        if (("required" == t && !jQuery.isPlainObject(t)) || (jQuery.isPlainObject(t) && t.hasOwnProperty("required"))) {
                            var a = n.find('[for="' + e + '"]');
                            0 < a.length && 0 === a.find(".req").length && a.prepend(' <small class="req text-danger">* </small>');
                        }
                    });
            }),
            t.configureJqueryValidationDefaults(),
            t.each(function () {
                var e = i(this);
                e.data("validator") && e.data("validator").destroy(), e.validate(o), t.validateCustomFields(e), t.addRequiredFieldSymbol(e), i(document).trigger("app.form-validate", e);
            })
        );
    };
})(jQuery),
    ($.fn.appFormValidator.internal_options = {
        localization: {
            email_exists: "undefined" != typeof app ? app.lang.email_exists : "Please fix this field",
            file_exceeds_max_filesize: "undefined" != typeof app ? app.lang.file_exceeds_max_filesize : "File Exceeds Max Filesize",
            validation_extension_not_allowed: "undefined" != typeof app ? $.validator.format(app.lang.validation_extension_not_allowed) : $.validator.format("Extension not allowed"),
        },
        on_required_add_symbol: !0,
        error_class: "text-danger",
        error_element: "p",
        required_custom_fields_selector: "[data-custom-field-required]",
        field_wrapper_class: "form-group",
        field_wrapper_error_class: "has-error",
        tab_panel_wrapper: "tab-pane",
        validated_tab_class: "tab-validated",
        error_placement: function (e, t) {
            t.parent(".input-group").length || t.parents(".chk").length
                ? t.parents(".chk").length
                    ? e.insertAfter(t.parents(".chk"))
                    : e.insertAfter(t.parent())
                : t.is("select") && (t.hasClass("selectpicker") || t.hasClass("ajax-search"))
                ? e.insertAfter(t.parents("." + $.fn.appFormValidator.internal_options.field_wrapper_class + " *").last())
                : e.insertAfter(t);
        },
        error_highlight: function (e) {
            var t = $(e).parents("." + $.fn.appFormValidator.internal_options.tab_panel_wrapper);
            t.length &&
                !t.is(":visible") &&
                $('a[href="#' + t.attr("id") + '"]')
                    .css("border-bottom", "1px solid red")
                    .css("color", "red")
                    .addClass($.fn.appFormValidator.internal_options.validated_tab_class),
                $(e).is("select")
                    ? delay(function () {
                          $(e)
                              .closest("." + $.fn.appFormValidator.internal_options.field_wrapper_class)
                              .addClass($.fn.appFormValidator.internal_options.field_wrapper_error_class);
                      }, 400)
                    : $(e)
                          .closest("." + $.fn.appFormValidator.internal_options.field_wrapper_class)
                          .addClass($.fn.appFormValidator.internal_options.field_wrapper_error_class);
        },
        error_unhighlight: function (e) {
            var t = (e = $(e)).parents("." + $.fn.appFormValidator.internal_options.tab_panel_wrapper);
            t.length &&
                $('a[href="#' + t.attr("id") + '"]')
                    .removeAttr("style")
                    .removeClass($.fn.appFormValidator.internal_options.validated_tab_class),
                e.closest("." + $.fn.appFormValidator.internal_options.field_wrapper_class).removeClass($.fn.appFormValidator.internal_options.field_wrapper_error_class);
        },
    }),
    jQuery.extend({
        highlight: function (e, t, a, n) {
            if (3 === e.nodeType) {
                var o = e.data.match(t);
                if (o) {
                    var i = document.createElement(a || "span");
                    i.className = n || "highlight";
                    var r = e.splitText(o.index);
                    r.splitText(o[0].length);
                    var s = r.cloneNode(!0);
                    return r.parentNode.tagName && "textarea" !== r.parentNode.tagName.toLowerCase() && (i.appendChild(s), r.parentNode.replaceChild(i, r)), 1;
                }
            } else if (1 === e.nodeType && e.childNodes && !/(script|style)/i.test(e.tagName) && (e.tagName !== a.toUpperCase() || e.className !== n))
                for (var l = 0; l < e.childNodes.length; l++) l += jQuery.highlight(e.childNodes[l], t, a, n);
            return 0;
        },
    }),
    (jQuery.fn.highlight = function (e, t) {
        var a = { className: "highlight animated flash", element: "span", caseSensitive: !1, wordsOnly: !1 };
        if (
            (jQuery.extend(a, t),
            e.constructor === String && (e = [e]),
            (e = jQuery.grep(e, function (e, t) {
                return "" != e;
            })),
            0 ==
                (e = jQuery.map(e, function (e, t) {
                    return e.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
                })).length)
        )
            return this;
        var n = a.caseSensitive ? "" : "i",
            o = "(" + e.join("|") + ")";
        a.wordsOnly && (o = "\\b" + o + "\\b");
        var i = new RegExp(o, n);
        return this.each(function () {
            jQuery.highlight(this, i, a.element, a.className);
        });
    }),
    (jQuery.fn.unhighlight = function (e) {
        var t = { className: "highlight", element: "span" };
        return (
            jQuery.extend(t, e),
            this.find(t.element + "." + t.className)
                .each(function () {
                    var e = this.parentNode;
                    e.replaceChild(this.firstChild, this), e.normalize();
                })
                .end()
        );
    }),
    (function (r) {
        r.fn.googleDrivePicker = function (e) {
            var a,
                n = !1,
                o = {
                    initGooglePickerAPI: function (e) {
                        gapi.load("auth2", function () {
                            o.onAuthApiLoad(e);
                        }),
                            gapi.load("picker", o.onPickerApiLoad);
                    },
                    onAuthApiLoad: function (e) {
                        (e.disabled = !1),
                            e.addEventListener("click", function () {
                                gapi.auth2.authorize({ client_id: i.clientId, scope: i.scope }, o.handleAuthResult);
                            });
                    },
                    onPickerApiLoad: function () {
                        (n = !0), o.createPicker();
                    },
                    handleAuthResult: function (e) {
                        e && !e.error ? ((a = e.access_token), o.createPicker()) : e.error && console.error(e);
                    },
                    createPicker: function () {
                        if (n && a) {
                            var e = new google.picker.DocsView().setIncludeFolders(!0),
                                t = new google.picker.DocsUploadView().setIncludeFolders(!0);
                            i.mimeTypes && (e.setMimeTypes(i.mimeTypes), t.setMimeTypes(i.mimeTypes)),
                                new google.picker.PickerBuilder().addView(e).addView(t).setOAuthToken(a).setDeveloperKey(i.developerKey).setCallback(o.pickerCallback).build().setVisible(!0),
                                setTimeout(function () {
                                    r(".picker-dialog").css("z-index", 10002);
                                }, 20);
                        }
                    },
                    pickerCallback: function (e) {
                        if (e[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
                            var t = [];
                            e[google.picker.Response.DOCUMENTS].forEach(function (e) {
                                t.push({ name: e[google.picker.Document.NAME], link: e[google.picker.Document.URL], mime: e[google.picker.Document.MIME_TYPE] });
                            }),
                                "function" == typeof i.onPick ? i.onPick(t) : window[i.onPick](t);
                        }
                    },
                },
                i = r.extend({}, r.fn.googleDrivePicker.defaults, e);
            return this.each(function () {
                i.clientId ? (r(this).data("on-pick") && (i.onPick = r(this).data("on-pick")), o.initGooglePickerAPI(r(this)[0]), r(this).css("opacity", 1)) : r(this).css("opacity", 0);
            });
        };
    })(jQuery),
    ($.fn.googleDrivePicker.defaults = { scope: "https://www.googleapis.com/auth/drive", mimeTypes: null, developerKey: "", clientId: "", onPick: function (e) {} }),
    $(document).keyup(function (e) {
        27 == e.keyCode && $(".modal").is(":visible") && 1 === $(".modal:visible").length && $("body").find('.modal:visible [onclick^="close_modal_manually"]').eq(0).click();
    }),
    $(function () {
        setTimeout(function () {
            $("#gantt .noDrag > g.handle-group").hide();
            var e = document.querySelectorAll(".bar-wrapper");
            Array.prototype.forEach.call(e, function (e) {
                e.addEventListener(
                    "mousedown",
                    function (e, t) {
                        $(e.target).closest(".bar-wrapper").hasClass("noDrag") && event.stopPropagation();
                    },
                    !0
                );
            });
        }, 1e3);
        var a = 1;
        $("body").on("click", ".add_more_attachments", function () {
            if ($(this).hasClass("disabled")) return !1;
            var e = $('.attachments input[name*="attachments"]').length;
            if ($(this).data("max") && e >= $(this).data("max")) return !1;
            var t = $(".attachments").find(".attachment").eq(0).clone().appendTo(".attachments");
            t.find("input").removeAttr("aria-describedby aria-invalid"),
                t
                    .find("input")
                    .attr("name", "attachments[" + a + "]")
                    .val(""),
                t.find($.fn.appFormValidator.internal_options.error_element + '[id*="error"]').remove(),
                t.find("." + $.fn.appFormValidator.internal_options.field_wrapper_class).removeClass($.fn.appFormValidator.internal_options.field_wrapper_error_class),
                t.find("i").removeClass("fa-plus").addClass("fa-minus"),
                t.find("button").removeClass("add_more_attachments").addClass("remove_attachment").removeClass("btn-success").addClass("btn-danger"),
                a++;
        }),
            $("body").on("click", ".remove_attachment", function () {
                $(this).parents(".attachment").remove();
            }),
            $("a[href='#top']").on("click", function (e) {
                e.preventDefault(), $("html,body").animate({ scrollTop: 0 }, 1e3), e.preventDefault();
            }),
            $("a[href='#bot']").on("click", function (e) {
                e.preventDefault(), $("html,body").animate({ scrollTop: $(document).height() }, 1e3), e.preventDefault();
            }),
            $(document).on("change", ".dt-page-jump-select", function () {
                $("#" + $(this).attr("data-id"))
                    .DataTable()
                    .page($(this).val() - 1)
                    .draw(!1);
            }),
            $("body").on("click", function () {
                $(".tooltip").remove();
            }),
            $("body").on("click", "[data-loading-text]", function () {
                var e = $(this).data("form");
                if (null != e) return !0;
                $(this).button("loading");
            }),
            $("body").on("click", function (e) {
                $('[data-toggle="popover"],.manual-popover').each(function () {
                    $(this).is(e.target) || 0 !== $(this).has(e.target).length || 0 !== $(".popover").has(e.target).length || $(this).popover("hide");
                });
            }),
            $("body").on("change", 'select[name="range"]', function () {
                var e = $(".period");
                "period" == $(this).val() ? e.removeClass("hide") : (e.addClass("hide"), e.find("input").val(""));
            }),
            $(document).on("shown.bs.dropdown", ".table-responsive", function (e) {
                var t = $(e.target);
                if (!t.hasClass("bootstrap-select")) {
                    var a = t.find(".dropdown-menu");
                    a.length ? t.data("dropdown-menu", a) : (a = t.data("dropdown-menu")), a.css("top", t.offset().top + t.outerHeight() + "px");
                    var n;
                    a.css("display", "block"), a.css("position", "absolute");
                    var o = t.parent().outerWidth(),
                        i = a.outerWidth();
                    (n = t.parent().offset().left - (i - o)), a.css("left", n + "px"), a.css("right", "auto"), a.appendTo("body");
                }
            }),
            $(document).on("hide.bs.dropdown", ".table-responsive", function (e) {
                var t = $(e.target);
                t.hasClass("bootstrap-select") || t.data("dropdown-menu").css("display", "none");
            }),
            $("body").on("click", "._delete", function (e) {
                return !!confirm_delete();
            });
    });
var delay = (function () {
    var a = 0;
    return function (e, t) {
        clearTimeout(a), (a = setTimeout(e, t));
    };
})();
function slugify(e) {
    return e
        .toString()
        .trim()
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\-]+/g, "")
        .replace(/\-\-+/g, "-")
        .replace(/^-+/, "")
        .replace(/-+$/, "");
}
function stripTags(e) {
    var t = document.createElement("DIV");
    return (t.innerHTML = e), t.textContent || t.innerText || "";
}
function empty(e) {
    if ("number" == typeof e || "boolean" == typeof e) return !1;
    if (null == e) return !0;
    if (void 0 !== e.length) return 0 === e.length;
    var t = 0;
    for (var a in e) e.hasOwnProperty(a) && t++;
    return 0 === t;
}
function add_hotkey(e, t) {
    if (void 0 === $.Shortcuts) return !1;
    $.Shortcuts.add({ type: "down", mask: e, handler: t });
}
function _tinymce_mobile_toolbar() {
    return ["undo", "redo", "styleselect", "bold", "italic", "link", "image", "bullist", "numlist", "forecolor", "fontsizeselect"];
}
function decimalToHM(e) {
    var t = parseInt(Number(e)),
        a = Math.round(60 * (Number(e) - t));
    return (t < 10 ? "0" + t : t) + ":" + (a < 10 ? "0" + a : a);
}
function color(e, t, a) {
    return "rgb(" + e + "," + t + "," + a + ")";
}
function buildUrl(e, t) {
    var a = "";
    for (var n in t) {
        var o = t[n];
        a += encodeURIComponent(n) + "=" + encodeURIComponent(o) + "&";
    }
    return 0 < a.length && (e = e + "?" + (a = a.substring(0, a.length - 1))), e;
}
function is_ios() {
    return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
}
function is_ms_browser() {
    return !(!/MSIE/i.test(navigator.userAgent) && !navigator.userAgent.match(/Trident.*rv\:11\./)) || !!/Edge/i.test(navigator.userAgent);
}
function _simple_editor_config() {
    return {
        forced_root_block: "p",
        height: is_mobile() ? 50 : 100,
        menubar: !1,
        autoresize_bottom_margin: 15,
        plugins: ["table advlist codesample autosave" + (is_mobile() ? " " : " autoresize ") + "lists link image textcolor media contextmenu paste"],
        toolbar: "insert formatselect bold forecolor backcolor" + (is_mobile() ? " | " : " ") + "alignleft aligncenter alignright bullist numlist | restoredraft",
        insert_button_items: "image media link codesample",
        toolbar1: "",
    };
}
function _create_print_window(e) {
    var t = "width=" + screen.width;
    return (t += ", height=" + screen.height), (t += ", top=0, left=0"), (t += ", fullscreen=yes"), window.open("", e, t);
}
function _add_print_window_default_styles(e) {
    e.document.write("<style>"),
        e.document.write(
            '.clearfix:after { clear: both;}.clearfix:before, .clearfix:after { display: table; content: " ";}body { font-family: Arial, Helvetica, sans-serif;color: #444; font-size:13px;}.bold { font-weight: bold !important;}'
        ),
        e.document.write("</style>");
}
function nl2br(e, t) {
    return (e + "").replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, "$1" + (t || void 0 === t ? "<br />" : "<br>") + "$2");
}
function tilt_direction(a) {
    setTimeout(function () {
        var t = a.position().left,
            e = function (e) {
                e.pageX >= t ? (a.addClass("right"), a.removeClass("left")) : (a.addClass("left"), a.removeClass("right")), (t = e.pageX);
            };
        $("html").on("mousemove", e), a.data("move_handler", e);
    }, 1e3);
}
function close_modal_manually(e) {
    (e = 0 === $(e).length ? $("body").find(e) : (e = $(e))).fadeOut("fast", function () {
        e.remove(), $("body").find(".modal").is(":visible") || ($(".modal-backdrop").remove(), $("body").removeClass("modal-open"));
    });
}
function showPassword(e) {
    var t = $('input[name="' + e + '"]');
    "password" == $(t).attr("type") && "" !== $(t).val()
        ? $(t).queue(function () {
              $(t).attr("type", "text").dequeue();
          })
        : $(t).queue(function () {
              $(t).attr("type", "password").dequeue();
          });
}
function hidden_input(e, t) {
    return '<input type="hidden" name="' + e + '" value="' + t + '">';
}
function appColorPicker(e) {
    void 0 === e && (e = $("body").find("div.colorpicker-input")), e.length && e.colorpicker({ format: "hex" });
}
function appSelectPicker(e) {
    void 0 === e && (e = $("body").find("select.selectpicker")), e.length && e.selectpicker({ showSubtext: !0 });
}
function appProgressBar() {
    var e = $("body").find(".progress div.progress-bar");
    e.length &&
        e.each(function () {
            var e = $(this),
                t = e.attr("data-percent");
            e.css("width", t + "%"), e.hasClass("no-percent-text") || e.text(t + "%");
        });
}
function appLightbox(e) {
    if ("undefined" == typeof lightbox) return !1;
    var t = { showImageNumberLabel: !1, resizeDuration: 200, positionFromTop: 25 };
    void 0 !== e && jQuery.extend(t, e), lightbox.option(t);
}
function DataTablesInlineLazyLoadImages(e, t, a) {
    var n = $("img.img-table-loading", e);
    return n.attr("src", n.data("orig")), n.prev("div").addClass("hide"), e;
}
function _table_jump_to_page(e, t) {
    var a = e.DataTable().page.info(),
        n = $("body").find("#dt-page-jump-" + t.sTableId);
    if ((n.length && n.remove(), 1 < a.pages)) {
        for (var o = $("<select></select>", { "data-id": t.sTableId, class: "dt-page-jump-select form-control", id: "dt-page-jump-" + t.sTableId }), i = "", r = 1; r <= a.pages; r++) {
            i += "<option value='" + r + "'" + (a.page + 1 === r ? "selected" : "") + ">" + r + "</option>";
        }
        "" != i && o.append(i), $("#" + t.sTableId + "_wrapper .dt-page-jump").append(o);
    }
}
function alert_float(e, t, a) {
    var n, o;
    (n = $("body").find("float-alert").length),
        (n = "alert_float_" + ++n),
        (o = $("<div></div>", { id: n, class: "float-alert animated fadeInRight col-xs-10 col-sm-3 alert alert-" + e })).append(
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
        ),
        o.append('<span class="fa fa-bell-o" data-notify="icon"></span>'),
        o.append('<span class="alert-title">' + t + "</span>"),
        $("body").append(o),
        (a = a || 3500),
        setTimeout(function () {
            $("#" + n).hide("fast", function () {
                $("#" + n).remove();
            });
        }, a);
}
function generatePassword(e) {
    for (var t = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789", a = "", n = 0, o = t.length; n < 12; ++n) a += t.charAt(Math.floor(Math.random() * o));
    $(e).parents().find("input.password").val(a);
}
function get_url_param(e) {
    var n = {};
    return (
        window.location.href.replace(location.hash, "").replace(/[?&]+([^=&]+)=?([^&]*)?/gi, function (e, t, a) {
            n[t] = void 0 !== a ? a : "";
        }),
        e ? (n[e] ? n[e] : null) : n
    );
}
function is_mobile() {
    if ("undefined" != typeof app && void 0 !== app.is_mobile) return app.is_mobile;
    try {
        return document.createEvent("TouchEvent"), !0;
    } catch (e) {
        return !1;
    }
}
function onGoogleApiLoad() {
    var e = $(".gpicker");
    $.each(e, function () {
        var e = $(this);
        setTimeout(function () {
            e.googleDrivePicker();
        }, 10);
    });
}
function _get_jquery_comments_default_config(e) {
    return {
        roundProfilePictures: !0,
        textareaRows: 4,
        textareaRowsOnFocus: 6,
        profilePictureURL: discussion_user_profile_image_url,
        enableUpvoting: !1,
        enableDeletingCommentWithReplies: !1,
        enableAttachments: !0,
        popularText: "",
        enableDeleting: !0,
        textareaPlaceholderText: e.discussion_add_comment,
        newestText: e.discussion_newest,
        oldestText: e.discussion_oldest,
        attachmentsText: e.discussion_attachments,
        sendText: e.discussion_send,
        replyText: e.discussion_reply,
        editText: e.discussion_edit,
        editedText: e.discussion_edited,
        youText: e.discussion_you,
        saveText: e.discussion_save,
        deleteText: e.discussion_delete,
        viewAllRepliesText: e.discussion_view_all_replies + " (__replyCount__)",
        hideRepliesText: e.discussion_hide_replies,
        noCommentsText: e.discussion_no_comments,
        noAttachmentsText: e.discussion_no_attachments,
        attachmentDropText: e.discussion_attachments_drop,
        timeFormatter: function (e) {
            return moment(e).fromNow();
        },
    };
}
function appDataTableInline(e, t) {
    var i = $(void 0 !== e ? e : ".dt-table");
    if (0 !== i.length) {
        var r,
            s,
            l,
            a = {
                supportsButtons: !1,
                supportsLoading: !1,
                dtLengthMenuAllText: app.lang.dt_length_menu_all,
                processing: !0,
                language: app.lang.datatables,
                paginate: !0,
                pageLength: app.options.tables_pagination_limit,
                fnRowCallback: DataTablesInlineLazyLoadImages,
                order: [0, "asc"],
                dom: "<'row'><'row'<'col-md-6'lB><'col-md-6'f>r>t<'row'<'col-md-4'i>><'row'<'#colvis'><'.dt-page-jump'>p>",
                fnDrawCallback: function (e) {
                    _table_jump_to_page(this, e),
                        0 == e.aoData.length || 0 == e.aiDisplay.length ? $(e.nTableWrapper).addClass("app_dt_empty") : $(e.nTableWrapper).removeClass("app_dt_empty"),
                        "function" == typeof d.onDrawCallback && d.onDrawCallback(e, this);
                },
                initComplete: function (e, t) {
                    this.wrap('<div class="table-responsive"></div>');
                    var a = this.find(".dataTables_empty");
                    if ((a.length && a.attr("colspan", this.find("thead th").length), d.supportsLoading && this.parents(".table-loading").removeClass("table-loading"), d.supportsButtons)) {
                        (n = i.find("thead th:last-child")).hasClass("options") && n.addClass("not-export");
                        var n = i.find("thead th:last-child");
                        "undefined" != typeof app && n.text().trim() == app.lang.options && n.addClass("not-export");
                        var o = i.find("thead th:first-child");
                        0 < o.find('input[type="checkbox"]').length && o.addClass("not-export"), "function" == typeof d.onInitComplete && d.onInitComplete(e, t, this);
                    }
                },
            },
            d = $.extend({}, a, t),
            n = [10, 25, 50, 100],
            o = [10, 25, 50, 100];
        (d.pageLength = parseFloat(d.pageLength)),
            -1 == $.inArray(d.pageLength, n) && (n.push(d.pageLength), o.push(d.pageLength)),
            n.sort(function (e, t) {
                return e - t;
            }),
            o.sort(function (e, t) {
                return e - t;
            }),
            n.push(-1),
            o.push(d.dtLengthMenuAllText),
            (d.lengthMenu = [n, o]),
            d.supportsButtons || (d.dom = d.dom.replace("lB", "l")),
            $.each(i, function () {
                if (($(this).addClass("dt-inline"), (r = $(this).attr("data-order-col")), (s = $(this).attr("data-order-type")), (l = $(this).attr("data-s-type")), r && s && (d.order = [[r, s]]), l)) {
                    l = JSON.parse(l);
                    var e = $(this).find("thead th"),
                        t = e.length;
                    d.aoColumns = [];
                    for (var a = 0; a < t; a++) {
                        var n = $(e[a]),
                            o = l.find(function (e) {
                                return e.column === n.index();
                            });
                        d.aoColumns.push(o ? { sType: o.type } : null);
                    }
                }
                d.supportsButtons && (d.buttons = get_datatable_buttons(this)), $(this).DataTable(d);
            });
    }
}
function get_datatable_buttons(r) {
    if (("persian" == app.user_language.toLowerCase() || "arabic" == app.user_language.toLowerCase()) && 0 === $("body").find("#amiri").length) {
        var e = document.createElement("script");
        e.setAttribute("src", "https://rawgit.com/xErik/pdfmake-fonts-google/master/build/script/ofl/amiri.js"), e.setAttribute("id", "amiri"), document.head.appendChild(e);
        var t = document.createElement("script");
        t.setAttribute("src", "https://rawgit.com/xErik/pdfmake-fonts-google/master/build/script/ofl/amiri.map.js"), document.head.appendChild(t);
    }
    var a = {
            body: function (e, t, a, n) {
                var o = $("<div></div>", e);
                o.append(e), 0 < o.find("[data-note-edit-textarea]").length && (o.find("[data-note-edit-textarea]").remove(), (e = o.html().trim()));
                var i = o.find(".text-has-action.is-date");
                i.length && (e = i.attr("data-title")),
                    0 < o.find(".row-options").length && (o.find(".row-options").remove(), (e = o.html().trim())),
                    0 < o.find(".table-export-exclude").length && (o.find(".table-export-exclude").remove(), (e = o.html().trim()));
                var r = document.createElement("div");
                return (r.innerHTML = e), (r.textContent || r.innerText || "").trim();
            },
        },
        n = [];
    ("function" == typeof table_export_button_is_hidden && table_export_button_is_hidden()) ||
        n.push({
            extend: "collection",
            text: app.lang.dt_button_export,
            className: "btn btn-default-dt-options",
            buttons: [
                {
                    extend: "excel",
                    text: app.lang.dt_button_excel,
                    footer: !0,
                    exportOptions: {
                        columns: [0, ':visible'],
                        rows: function (e) {
                            return _dt_maybe_export_only_selected_rows(e, r);
                        },
                        format: a,
                    },
                },
                {
                    extend: "csvHtml5",
                    text: app.lang.dt_button_csv,
                    footer: !0,
                    exportOptions: {
                        columns: [0, ':visible'],
                        rows: function (e) {
                            return _dt_maybe_export_only_selected_rows(e, r);
                        },
                        format: a,
                    },
                },
                {
                    extend: "colvis"
                },
                {
                    extend: "pdfHtml5",
                    text: app.lang.dt_button_pdf,
                    footer: !0,
                    exportOptions: {
                        columns: [0, ':visible'],
                        rows: function (e) {
                            return _dt_maybe_export_only_selected_rows(e, r);
                        },
                        format: a,
                    },
                    orientation: "landscape",
                    customize: function (t) {
                        var e = $(r).DataTable().columns().visible(),
                            a = e.length,
                            n = 0;
                        for (i = 0; i < a; i++) 1 == e[i] && n++;
                        setTimeout(function () {
                            if (n <= 5) {
                                var e = [];
                                for (i = 0; i < n; i++) e.push(735 / n);
                                t.content[1].table.widths = e;
                            }
                        }, 10),
                            ("persian" != app.user_language.toLowerCase() && "arabic" != app.user_language.toLowerCase()) || (t.defaultStyle.font = Object.keys(pdfMake.fonts)[0]),
                            (t.styles.tableHeader.alignment = "left"),
                            (t.defaultStyle.fontSize = 10),
                            (t.styles.tableHeader.fontSize = 10),
                            (t.styles.tableHeader.margin = [3, 3, 3, 3]),
                            (t.styles.tableFooter.fontSize = 10),
                            (t.styles.tableFooter.margin = [3, 0, 0, 0]),
                            (t.pageMargins = [2, 20, 2, 20]);
                    },
                },
                {
                    extend: "print",
                    text: app.lang.dt_button_print,
                    footer: !0,
                    exportOptions: {
                        columns: [0, ':visible'],
                        rows: function (e) {
                            return _dt_maybe_export_only_selected_rows(e, r);
                        },
                        format: a,
                    },
                },
            ],
        });
    var o = $("body").find(".table-btn");
    return (
        $.each(o, function () {
            var o = $(this);
            o.length &&
                o.attr("data-table") &&
                $(r).is(o.attr("data-table")) &&
                n.push({
                    text: o.text().trim(),
                    className: "btn btn-default-dt-options",
                    action: function (e, t, a, n) {
                        o.click();
                    },
                });
        }),
        $(r).hasClass("dt-inline") ||
            n.push({
                text: '<i class="fa fa-refresh"></i>',
                className: "btn btn-default-dt-options btn-dt-reload",
                action: function (e, t, a, n) {
                    t.ajax.reload();
                },
            }),
        n
    );
}
function table_export_button_is_hidden() {
    return "to_all" != app.options.show_table_export_button && ("hide" === app.options.show_table_export_button || ("only_admins" === app.options.show_table_export_button && 0 == app.user_is_admin));
}
function _dt_maybe_export_only_selected_rows(e, t) {
    (t = $(t)), (e = e.toString());
    var a = t.find('thead th input[type="checkbox"]').eq(0);
    if (a && 0 < a.length) {
        var n = t.find("tbody tr"),
            o = !1;
        return (
            $.each(n, function () {
                $(this).find('td:first input[type="checkbox"]:checked').length && (o = !0);
            }),
            o ? (0 < t.find("tbody tr:eq(" + e + ') td:first input[type="checkbox"]:checked').length ? e : null) : e
        );
    }
    return e;
}
function slideToggle(e, t) {
    var a = $(e);
    a.hasClass("hide") && a.removeClass("hide", "slow"), a.length && a.slideToggle();
    var n = $(".progress-bar").not(".not-dynamic");
    0 < n.length &&
        (n.each(function () {
            $(this).css("width", "0%"), $(this).text("0%");
        }),
        "function" == typeof appProgressBar && appProgressBar()),
        "function" == typeof t && t();
}
function appDatepicker(e) {
    void 0 === app._date_picker_locale_configured && (jQuery.datetimepicker.setLocale(app.locale), (app._date_picker_locale_configured = !0));
    var t = { date_format: app.options.date_format, time_format: app.options.time_format, week_start: app.options.calendar_first_day, date_picker_selector: ".datepicker", date_time_picker_selector: ".datetimepicker" },
        r = $.extend({}, t, e),
        a = void 0 !== r.element_date ? r.element_date : $(r.date_picker_selector),
        n = void 0 !== r.element_time ? r.element_time : $(r.date_time_picker_selector);
    (0 === n.length && 0 === a.length) ||
        ($.each(a, function () {
            var e = $(this),
                t = { timepicker: !1, scrollInput: !1, lazyInit: !0, format: r.date_format, dayOfWeekStart: r.week_start },
                a = e.attr("data-date-end-date"),
                n = e.attr("data-date-min-date"),
                o = e.attr("data-lazy");
            o && (t.lazyInit = "true" == o),
                a && (t.maxDate = a),
                n && (t.minDate = n),
                e.datetimepicker(t),
                e
                    .parents(".form-group")
                    .find(".calendar-icon")
                    .on("click", function () {
                        e.focus(), e.trigger("open.xdsoft");
                    });
        }),
        $.each(n, function () {
            var e = $(this),
                t = { lazyInit: !0, scrollInput: !1, validateOnBlur: !1, dayOfWeekStart: r.week_start };
            24 == r.time_format ? (t.format = r.date_format + " H:i") : ((t.format = r.date_format + " g:i A"), (t.formatTime = "g:i A"));
            var a = e.attr("data-date-end-date"),
                n = e.attr("data-date-min-date"),
                o = e.attr("data-step"),
                i = e.attr("data-lazy");
            i && (t.lazyInit = "true" == i),
                o && (t.step = parseInt(o)),
                a && (t.maxDate = a),
                n && (t.minDate = n),
                e.datetimepicker(t),
                e
                    .parents(".form-group")
                    .find(".calendar-icon")
                    .on("click", function () {
                        e.focus(), e.trigger("open.xdsoft");
                    });
        }));
}
function appTagsInput(e) {
    void 0 === e && (e = $("body").find("input.tagsinput")),
        e.length &&
            e.tagit({
                availableTags: app.available_tags,
                allowSpaces: !0,
                animate: !1,
                placeholderText: app.lang.tag,
                showAutocompleteOnFocus: !0,
                caseSensitive: !1,
                autocomplete: { appendTo: "#inputTagsWrapper" },
                afterTagAdded: function (e, t) {
                    var a = app.available_tags.indexOf($.trim($(t.tag).find(".tagit-label").text()));
                    if (-1 < a) {
                        var n = app.available_tags_ids[a];
                        $(t.tag).addClass("tag-id-" + n);
                    }
                    showHideTagsPlaceholder($(this));
                },
                afterTagRemoved: function (e, t) {
                    showHideTagsPlaceholder($(this));
                },
            });
}
function fixHelperTableHelperSortable(e, t) {
    return (
        t.children().each(function () {
            $(this).width($(this).width());
        }),
        t
    );
}
function _dropzone_defaults() {
    var e = app.options.allowed_files;
    return (
        "safari" === app.browser && -1 < e.indexOf(".jpg") && -1 === e.indexOf(".jpeg") && (e += ",.jpeg"),
        {
            createImageThumbnails: !0,
            dictDefaultMessage: app.lang.drop_files_here_to_upload,
            dictFallbackMessage: app.lang.browser_not_support_drag_and_drop,
            dictFileTooBig: app.lang.file_exceeds_maxfile_size_in_form,
            dictCancelUpload: app.lang.cancel_upload,
            dictRemoveFile: app.lang.remove_file,
            dictMaxFilesExceeded: app.lang.you_can_not_upload_any_more_files,
            maxFilesize: (app.max_php_ini_upload_size_bytes / 1048576).toFixed(0),
            acceptedFiles: e,
            error: function (e, t) {
                alert_float("danger", t);
            },
            complete: function (e) {
                this.files.length && this.removeFile(e);
            },
        }
    );
}
function appCreateDropzoneOptions(e) {
    return $.extend({}, _dropzone_defaults(), e);
}
function onChartClickRedirect(e, t, a) {
    void 0 === a && (a = "statusLink");
    var n = t.getElementAtEvent(e)[0];
    if (n) {
        var o = t.data.datasets[0][a][n._index];
        o && (window.location.href = o);
    }
}
function destroy_dynamic_scripts_in_element(e) {
    e.find("input.tagsinput").tagit("destroy").find(".manual-popover").popover("destroy").find(".datepicker").datetimepicker("destroy").find("select").selectpicker("destroy");
}
function appValidateForm(e, t, a, n) {
    $(e).appFormValidator({ rules: t, onSubmit: a, messages: n });
}
function htmlEntities(e) {
    return String(e).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;");
}
($.fn.isInViewport = function () {
    var e = $(this).offset().top,
        t = e + $(this).outerHeight(),
        a = $(window).scrollTop(),
        n = a + $(window).height();
    return a < t && e < n;
}),
    (String.prototype.matchAll = function (e) {
        var a = [];
        return (
            this.replace(e, function () {
                var e = [].slice.call(arguments, 0),
                    t = e.splice(-2);
                (e.index = t[0]), (e.input = t[1]), a.push(e);
            }),
            a.length ? a : null
        );
    });
