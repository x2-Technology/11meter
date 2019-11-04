/**
 * Created by adler_supervisor on 14.08.17.
 */

!(function ($) {
    'use strict';
    $.extend({
       
        tsoftx: new function () {
            
            this.loaderObj = null;
            
            let L = this;
            
            // Stored Acler Controller for other method if need
            // Declare this before call target Function
            this.storedAlertControllerWithActions = {ac: undefined, actions: {}};
            
            this.fakeFormComplete = function (file, ext) {
                
                let ajx = new $.tsoftx.ajax(), l = new $.tsoftx.loader();
                l.show(function () {
                    ajx
                        .setCnt("_Public")
                        .setMtd("getFakeFormData")
                        .setData({
                            file: file,
                            ext: ext
                        })
                        .setProcessWithSession(false)
                        .execute(function () {
                            
                            for (let el in this) {
                                
                                $("[name=" + el + "]").focus().val(this[el]).blur()
                                
                            }
                            $("select").removeClass("missing-data").removeClass("missing-data-all").removeClass("missing-data-bottom");
                            l.dismiss();
                        });
                });
                
                
            };
            
            this.inputFormat = function (el, event, callback) {
                
                let
                    err_,
                    msg = "",
                    $e = elementConvertTo(e, "object"),
                    _ui = {
                        self: $e,
                        dispatcher: function () {
                            
                            if (params.format === null) {
                                msg = "No format selected!";
                                this.error();
                            } else {
                                this.select();
                            }
                            
                        },
                        select: function () {
                            
                            if (params.format === "number") {
                                let
                                    k,
                                    accessKeys = [46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57];
                                _ui.self.keypress(function (event) {
                                    err_ = false;
                                    k = event.which;
                                    if (accessKeys.indexOf(k) == -1) {
                                        msg = $.tsoftx.translate("access only number");
                                        err_ = true;
                                    } else {
                                        // Access only 1 time ".";
                                        let number = this.value;
                                        if (k == 46 && number.indexOf(".") != -1) {
                                            err_ = true;
                                            msg = $.tsoftx.translate("seperator use only 1 time");
                                        }
                                    }
                                    if (err_) {
                                    
                                    }
                                });
                            }
                            
                            if (params.format === "calendar" || params.format === "date") {
                                this.date();
                            }
                            if (params.format === "time") {
                                this.time();
                            }
                            if (params.format === "email") {
                                this.email();
                            }
                            if (params.format === "ucase") {
                                this.ucase();
                            }
                            if (params.format === "lcase") {
                                this.lcase();
                            }
                            return this;
                        },
                        email: function () {
                            let
                                email = _ui.self.val(),
                                re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                            
                            if (!re.test(email)) {
                                msg = $.tsoftx.translate("Invalid") + " " + "email!";
                                _ui.error();
                            }
                            
                        },
                        date: function () {
                            console.log(_ui.self);
                            $e.mask("99.99.9999");
                        },
                        time: function () {
                            _ui.self.mask("99:99");
                        },
                        output: function () {
                        
                        },
                        ucase: function () {
                            $(this.self).keyup(function (e) {
                                $e.val($e.val().toUpperCase());
                            });
                        },
                        lcase: function () {
                            $(this.self).keyup(function (e) {
                                $e.val($e.val().toLowerCase());
                            });
                        },
                        error: function () {
                            
                            $.tsoftx.dialog({
                                model: "msgbox", // msgbox, dialog, editor
                                content: msg,
                                close: true,
                                buttons_pos: "right",
                                image: $.helper.image.err,
                                buttons: {
                                    negative: {
                                        label: $.tsoftx.translate("close"),
                                        pos: "right",
                                        click: function () {
                                        
                                        }
                                    }
                                }
                            }, function () {
                            
                            });
                            
                            // Dialogbox
                        },
                        callback: function () {
                            if (callback !== undefined && callback === "function") {
                                callback.call(_ui.self, _ui);
                            }
                        }
                    }
                
                _ui.dispatcher();
                
                
            };
            
            this.formInput = function (el, event, callback) {
                
                this.placeholderColor = "rgba(0,0,0,.1)";
                this.paddingLeft = 0;
                this.defH = 0;
                
                this.init = function () {
                    
                    if (undefined !== el[0]) {
                        el = el[0];
                    }
                    
                    
                    let wrapper = document.createElement("div");
                    wrapper.classList.add("tsoftx-form-group");
                    // alert(el.getAttribute("class"));
                    wrapper.setAttribute("class", el.getAttribute("class"));
                    if (!wrapper.classList.contains("tsoftx-form-group")) {
                        wrapper.classList.add("tsoftx-form-group");
                    }
                    el.removeAttribute("class");
                    
                    
                    let placeholder = document.createElement("label");
                    placeholder.innerText = el.getAttribute("placeholder");
                    placeholder.onclick = function () {
                        el.focus();
                    };
                    
                    
                    let i = document.createElement("i");
                    // i.classList.add("pull-right");
                    
                    
                    // el.classList.add("tsoftx-form-control");
                    el.parentNode.appendChild(wrapper);
                    el.parentNode.style.marginTop = fontSize;
                    
                    
                    wrapper.appendChild(placeholder);
                    
                    wrapper.appendChild(el);
                    
                    
                    let
                        fontSize = window.getComputedStyle(el, null).getPropertyValue("font-size"),
                        fontFamily = window.getComputedStyle(el, null).getPropertyValue("font-family"),
                        fontWeight = window.getComputedStyle(el, null).getPropertyValue("font-weight");
                    
                    
                    if (el.getAttribute("icon") != undefined || el.getAttribute("icon") != null) {
                        this.paddingLeft = fontSize;
                    }
                    
                    // alert("Icon for " + el.getAttribute("name") + " " + el.getAttribute("icon"))
                    
                    el.removeAttribute("placeholder");
                    el.style.paddingLeft = this.paddingLeft;
                    
                    
                    placeholder.classList.add("tsoftx-input-palceholder");
                    // placeholder.style.fontSize = fontSize;
                    placeholder.style.color = this.placeholderColor;
                    placeholder.style.fontFamily = fontFamily;
                    placeholder.style.fontWeight = fontWeight;
                    placeholder.style.textOverflow = "ellipsis";
                    placeholder.style.overflow = "hidden";
                    placeholder.style.whiteSpace = "nowrap";
                    placeholder.style.fontSize = 24;
                    placeholder.style.height = 24 + 4;
                    
                    this.defH = placeholder.height;
                    
                    i.classList.add("icon", el.getAttribute("icon"));
                    i.style.position = "absolute";
                    i.style.left = 0;
                    i.style.fontSize = fontSize;
                    
                    
                    let animFocusParams = {
                        top: -35,
                        textDecoration: "underline",
                        zoom: .5
                    };
                    let animFocusOutParams = {
                        top: 0,
                        color: this.placeholderColor,
                        zoom: 1
                    };
                    
                    
                    if (el.getAttribute("icon") !== undefined) {
                        wrapper.appendChild(i);
                        
                        placeholder.style.paddingLeft = this.paddingLeft;
                        
                        
                        i.style.fontSize = parseInt(fontSize) - 8 + "px";
                        
                        let animFocusParams = {
                            top: -35,
                            left: 0,
                            paddingLeft: 0,
                            color: "rgb(108, 192, 255, 1)",
                            zoom: .5
                            
                        };
                        
                        let animFocusOutParams = {
                            top: 0,
                            paddingLeft: this.paddingLeft,
                            color: this.placeholderColor,
                            zoom: 1
                        };
                        
                        
                    }
                    
                    
                    if (el.dataset.button !== undefined && el.dataset.button == "true") {
                        
                        
                        let ap = document.createElement("a");
                        let pi = document.createElement("i");
                        
                        ap.style.position = "absolute";
                        ap.style.bottom = i.style.bottom;
                        ap.style.fontSize = fontSize;
                        ap.style.right = 0;
                        ap.style.cursor = "pointer";
                        ap.style.textDecoration = "none";
                        
                        
                        ap.appendChild(pi);
                        
                        ap.classList.add("pull-right");
                        pi.classList.add(el.dataset["button-icon"]);
                        
                        
                        el.style.paddingRight = pi.style.fontSize;
                        
                        
                        wrapper.appendChild(ap);
                    }
                    
                    
                    if (undefined !== event && undefined !== callback) {
                        
                        switch (event) {
                            
                            case "button-click":
                                ap.onclick = function () {
                                    callback.call(el);
                                }
                            
                        }
                        
                        
                    }
                    
                    
                    el.onclick = function () {
                        
                        /*let caretPos = this.selectionStart;
                        let textAreaTxt = this.value;
                        console.log(caretPos);
                        console.log(textAreaTxt[caretPos]);*/
                        
                    }
                    
                    
                    el.onfocus = function () {
                        
                        this.setSelectionRange(0, this.value.length);
                        
                        if (this.value === "") {
                            $(placeholder).animate(animFocusParams, 100, function () {
                                // $(this).css("text-decoration", "underline");
                            });
                            placeholder.style.color = "rgba(0,0,0,1)";
                        }
                        else {
                            return false;
                        }
                        
                        
                    }
                    
                    el.onchange = function () {
                        
                        console.log("Changed");
                        // if( el.value !== "" ){
                        $(placeholder).css(animFocusParams);
                        // }
                    };
                    
                    
                    if (el.value !== "") {
                        $(placeholder).css(animFocusParams);
                    }
                    
                    
                    el.onfocusout = function () {
                        
                        console.log("Focused out");
                        if (el.value === "") {
                            $(placeholder).animate(animFocusOutParams, "fast", function () {
                                // $(this).css("text-decoration", "none");
                                
                            });
                            placeholder.style.color = "rgba(0,0,0,.3)";
                        }
                        
                        
                    }
                    
                    el.onblur = function () {
                        
                        console.log("Blured");
                        
                        
                    }
                    
                    
                }
                
                
                this.init();
                
            };
            
            this.alertAction = function () {
                
                let cls = this,
                    
                    params = {
                        title: "Button",
                        style: "default",
                        classList: ["danger", "info", "success", "warning", "muted", "primary", "white"],
                        iconPos: "l"
                    },
                    b = null,
                    t = null,
                    bi = null,
                    beforeClickEvent = undefined,
                    createRequest = false;
                
                cls.init = function () {
                    
                    b = document.createElement("button");
                    t = document.createElement("span");
                    $(t).appendTo($(b));
                    
                    return b;
                    
                };
                
                cls.setTitle = function (val) {
                    params.title = val;
                    t.innerText = val;
                    return this;
                }
                cls.getTitle = function () {
                    return params.title;
                }
                
                cls.setStyle = function (val) {
                    
                    params.style = val;
                    for (let v in params.classList) {
                        b.classList.remove("btn-" + params.classList[v]);
                    }
                    b.classList.add("btn-" + val);
                    return this;
                    
                };
                cls.getStyle = function () {
                    return params.style;
                };
                
                
                cls.actionTo = function (obj) {
                    
                    if (createRequest) {
                        $(b).appendTo(obj);
                        createRequest = false;
                    } else {
                        // cls.errorDialog(null, "Action Button for Dialog not created yet!");
                    }
                    return this;
                };
                
                cls.actionAfter = function (obj) {
                    if (createRequest) {
                        $(obj).after($(b));
                        createRequest = false;
                    } else {
                        // cls.errorDialog(null, "Action Button for Dialog not created yet!");
                    }
                    return this;
                };
                
                cls.actionBefore = function (obj) {
                    if (createRequest) {
                        $(obj).before($(b));
                        createRequest = false;
                    } else {
                        // cls.errorDialog(null, "Action Button for Dialog not created yet!");
                    }
                    return this;
                };
                
                cls.margin = function (val, important) {
                    
                    $(b).css("margin", val, important !== undefined ? "important" : null);
                    
                    
                    return this;
                }
                
                
                cls.beforeClick = function (callback) {
                    
                    if (undefined !== callback && "function" === typeof callback) {
                        beforeClickEvent = callback;
                    }
                    return this;
                };
                
                /**
                 *
                 * @type {{enabled: cls.setActionsStatus.enabled, disabled: cls.setActionsStatus.disabled}}
                 * QUICK VERSION OF action.property( "disabled", true / false );
                 */
                cls.setActionsStatus = {
                    
                    enabled: function (actions) {
                        for (let action in actions) {
                            action.propery("disabled", false);
                        }
                    },
                    disabled: function (actions) {
                        for (let action in actions) {
                            action.propery("disabled", true);
                        }
                    }
                    
                }
                
                /**
                 *
                 * @param before Before Click Event
                 * @param callback After Click Event
                 */
                cls.click = function (callback) {
                    
                    let k = this;
                    
                    $(b).unbind("click").bind("click", function () {
                        
                        // if (undefined !== beforeClickEvent && typeof beforeClickEvent === "function") {
                        //     beforeClickEvent.call(k);
                        //
                        //     setTimeout(function () {
                        //         if (undefined !== callback && "function" === typeof callback) {
                        //             callback.call(k);
                        //         }
                        //     }, 100)
                        // }
                        // else {
                        //     if (undefined !== callback && "function" === typeof callback) {
                        //         callback.call(k);
                        //     }
                        // }
                        cls.clickEvent(callback);
                        
                        
                    });
                    
                    return this;
                };
                
                // Sub Method for Click, Trigger
                cls.clickEvent = function (callback) {
                    
                    if (undefined !== beforeClickEvent && typeof beforeClickEvent === "function") {
                        beforeClickEvent.call(this);
                        
                        setTimeout(function () {
                            if (undefined !== callback && "function" === typeof callback) {
                                callback.call(this);
                            }
                        }, 100)
                    }
                    else {
                        if (undefined !== callback && "function" === typeof callback) {
                            callback.call(this);
                        }
                    }
                    
                };
                
                cls.trigger = function (parameter, callback) {
                    
                    switch (parameter) {
                        
                        case "click":
                            cls.clickEvent(callback);
                            break;
                        
                        default:
                            break;
                        
                    }
                    
                }
                
                /**
                 *
                 * @param prop Name of Property enabled, disabled, remove, icon vbz
                 * @param value true false, with icon property name of icon
                 * @param io in out params use with icon property icon add or remove i in, o out
                 * @param pos params use with icon property icon position
                 * @returns {cls}
                 */
                cls.property = function (prop, value, io, pos) {
                    
                    switch (prop) {
                        
                        case "disabled":
                        case "enabled":
                            
                            if ((prop === "enabled" && !value) || (prop === "disabled" && value)) {
                                
                                b.classList.add("disabled");
                                b.setAttribute("disabled", "disabled");
                                
                            }
                            
                            else if ((prop === "enabled" && value) || (prop === "disabled" && !value)) {
                                
                                b.classList.remove("disabled");
                                b.removeAttribute("disabled");
                                
                            }
                            
                            break;
                        
                        case "remove":
                            // $(b).remove();
                            b.remove(b.selectedIndex);
                            break;
                        
                    }
                    
                    return this;
                    
                };
                
                cls.icon = function () {
                    
                    let k = this;
                    
                    return {
                        add: function (icon, pos) {
                            
                            
                            let e = $(b).find("span.glyphicon");
                            
                            if (e.length) {
                                e.remove(e.selectedIndex);
                                /*let c = e.find("i").attr("class");

                                 c = c.split(" ");

                                 for(let cx in c ){
                                 if( c[cx].match(/^icon/) ){
                                 e.find("i").removeClass( c[cx] )
                                 }
                                 }

                                 e.find("i").addClass("icon " + icon );*/
                            }
                            
                            let
                                bi = $("<span>").addClass("glyphicon"), i;
                            
                            // Default Position
                            if (pos === undefined) {
                                $("<i>").addClass("icon mr-5 " + icon).appendTo((bi));
                                $(t).before($(bi));
                            }
                            
                            // Selected Position
                            else {
                                switch (pos) {
                                    case "l":
                                        $("<i>").addClass("icon mr-5 " + icon).appendTo((bi));
                                        $(t).before($(bi));
                                        break;
                                    
                                    case "r":
                                        $("<i>").addClass("icon ml-5 " + icon).appendTo((bi));
                                        $(t).after($(bi));
                                        break;
                                }
                            }
                            
                            
                            return k;
                        },
                        remove: function () {
                            
                            let e = $(b).find("span.glyphicon");
                            e.remove(e.selectedIndex);
                            return k;
                            
                        }
                        
                        
                    }
                };
                
                cls.kill = function () {
                    
                    console.log("Button", b);
                    // $(b).remove();
                    b.remove(b.selectedIndex);
                    return this;
                };
                
                cls.display = function (val) {
                    $(b).css("display", val ? "block" : "none");
                    return this;
                };
                
                
                cls.create = function () {
                    
                    createRequest = true;
                    
                    b.classList.add("btn", "btn-" + this.getStyle());
                    t.innerText = this.getTitle();
                    
                    
                    return this;
                };
                
                
                cls.init();
                
                cls.errorDialog = function (title, message) {
                    
                    alert(message);
                    return this;
                    
                };
                
                
                return $.extend(b, cls);
                
                
            };
            
            this.alert = function (id) {
                
                
                let cls = this;
                
                this.developerMode = true;
                
                
                cls.setTitle = function () {
                };
                cls.setMessage = function () {
                };
                cls.setSubMessage = function () {
                };
                cls.setSubMessageStyle = function () {
                };
                cls.setType = function () {
                };
                cls.setDismissible = function () {
                };
                
                cls.okActionBeforeClickEvent = function () {
                };
                cls.cancelActionBeforeClickEvent = function () {
                };
                cls.setDismissEvent = function () {
                };
                cls.actions = function () {
                };
                cls.setModalID = function () {
                };
                
                
                cls.titleObj = "";
                cls.titleTextObj = "";
                cls.alertIDObj = "";
                cls.messageObj = "";
                cls.subMessageObj = "Sub Message";
                cls.okActionObj = "";
                cls.cancelActionObj = "";
                cls.actionsWrapper = "";
                cls.modalHeaderObj = "";
                cls.dismissibleObj = "";
                cls.footerObj = "";
                cls.dismissible = false;
                cls.modelBody = "";
                cls.modelBodyClass = "";
                cls.modelFooter = "";
                cls.modelLoader = "";
                cls.m = "";
                cls.dismCallEvent = null;
                cls.alertType = "default";
                cls.content = null;
                cls.alertIDNumber = undefined;
                cls.focusEl = undefined;
                cls.modalID = undefined;
                cls.modalObj = undefined;
                cls.timeoutInterval = 30000;
                cls.timeoutObject = null;
                
                cls.init = function () {
                    
                    cls.setIDNumber(id);
                    
                    cls.m = $("div#alert");
                    if (!cls.m.length) {
                        cls.create();
                    } else {
                        cls.m.remove();
                        cls.create();
                    }
                    
                };
                
                
                cls.setType = function (val, textColor ) {
                    cls.alertType = val;
                    cls.modalHeaderObj
                        .removeClass("bg-success bg-danger bg-info bg-warning bg-default")
                        .find("h4").removeClass("text-success text-danger text-info text-warning text-default ");
                    
                    cls.modalHeaderObj
                        .addClass("bg-" + val).find("h4");
                    
                    if( undefined !== textColor ){
                        cls.modalHeaderObj.find("h4")[0].style.color = "white";
                    } else {
                        cls.modalHeaderObj.find("h4").addClass("text-" + cls.alertType);
                    }
                    cls.modalHeaderObj.find("h4")[0].style.color = "white";
                    
                    return cls;
                };
                
                cls.create = function () {
                    
                    // wrapper
                    let $w = $("<div>");
                    $w.attr("id", "alert-" + btoa(Math.floor(Math.random() * 99999999).toString()));
                    // $w.addClass("modal fade");
                    $w.addClass("modal");
    
                    
                    
                    
                    document.getElementsByTagName("html")[0].appendChild($w[0]);
                    
                    cls.m = $w;
                    
                    // Dialog
                    let $d = $("<div>");
                    $d.addClass("modal-dialog alert-device-max-width");
                    // $d.addClass("modal-dialog dialog-sm");
                    $d.appendTo($w);
                    cls.modalObj = $d;
                    
                    // content
                    let $c = $("<div>");
                    $c.addClass("modal-content");
                    $c.appendTo($d);
                    // header
                    cls.modalHeaderObj = $("<div>");
                    cls.modalHeaderObj.addClass("modal-header box-no-border").css("border-top-left-radius", 4).css("border-top-right-radius", 4).appendTo($c);
                    // Header dismiss
                    cls.dismissibleObj = $("<button>");
                    cls.dismissibleObj.attr("type", "button").attr("class", "close").data("dismiss", "modal").attr("aria-hidden", "true").attr("data-dismiss", "modal").html("x");
                    
                    // header html
                    let $t = $("<h4>");
                    $t
                        .addClass("modal-title")
                        .appendTo(cls.modalHeaderObj);
                    cls.titleObj = $t;
                    
                    this.titleTextObj = $("<span>").addClass("title").html("Title").addClass("pull-left").appendTo($t);
                    
                    if (this.developerMode) {
                        this.alertIDObj = $("<span>").addClass("title").addClass("pull-right").addClass("mr-10").appendTo($t);
                    }
                    
                    
                    // Body
                    let $b = $("<div>").addClass("modal-body").appendTo($c);
                    let $m = $("<p>");
                    $m.addClass("message");
                    
                    let $wmw = $("<span>").addClass("text-warning");
                    let $wmt = $("<small>").appendTo($wmw);
                    $wmt.html("text-warning");
                    
                    cls.modelBody = $b;
                    cls.messageObj = $m;
                    cls.subMessageObj = $wmw;
                    cls.content = $m[0];
                    
                    // footer
                    let $footer = $("<div>");
                    $footer.addClass("modal-footer box-no-border").appendTo($c);
                    cls.modelFooter = $footer;
                    
                    cls.okActionObj = $("<button>").addClass("btn btn-primary pull-right ml-10").attr("type", "button").data("role", "ok").html("Ok");
                    cls.cancelActionObj = $("<button>").addClass("btn btn-default pull-left").attr("type", "button").attr("data-dismiss", "modal").data("role", "cancel").data("dismiss", "modal").html("Cancel");
                    cls.actionsWrapper = $("<span>").addClass("pull-right").appendTo(cls.modelFooter);
                    
                    /*cls.modelLoader = $("<div>").addClass("loader").appendTo(cls.modelFooter);
                    cls.loader("hide");*/
                    cls.loaderCreate();
                    
                    
                    
                    
                    // Default Dismiss Option
                    cls.cancelActionObj.on("click", function () {
                        cls.dismiss();
                    });
                    
                };
                
                cls.addBodyClass = function( _class ){
                    cls.modelBody.addClass(_class);
                    return this;
                };
                
                cls.getContent = function () {
                    return cls.modelBody;
                };
                
                cls.setModalID = function (id) {
                    cls.modalID = id;
                    cls.modalObj.attr("data-modal-id", id);
                    return this;
                };
                cls.getModalID = function () {
                    return cls.modalID;
                };
                
                
                cls.setTitle = function (c) {
                    
                    setTimeout(function () {
                        
                        /*
                        if (undefined !== id && cls.alertIDObj.text() !== id) {
                            cls.alertIDObj.text("(" + id + ")");
                        }
                        */
                        cls.titleTextObj.html(c)
                        
                    }, 0);
                    return cls;
                };
                
                cls.setIDNumber = function (sid) {
                    /*if (undefined !== cls.alertIDObj[0]) {
                        setTimeout(function () {
                            console.log("ID;", this.alertIDObj);
                            cls.alertIDObj[0].innerText = "(" + id + ")";
                        }, 50)
                    }*/
                    cls.alertIDNumber = sid;
                    return this;
                };
                cls.getIDNumber = function () {
                    
                    if (!cls.alertIDNumber !== undefined) {
                        return cls.alertIDNumber;
                    }
                    
                    return null;
                    
                };
                
                cls.setFocusEl = function (selector) {
                    cls.focusEl = selector;
                    return this;
                };
                cls.getFocusEl = function () {
                    return cls.focusEl;
                };
                
                cls.setMessage = function (c) {
                    
                    setTimeout(function () {
                        cls.messageObj.html(c).appendTo(cls.modelBody);
                    }, 0);
                    
                    return cls;
                    
                };
                
                cls.setSubMessage = function (c, style) {
                    
                    if (c !== undefined && c === "remove") {
                        
                        cls.subMessageObj.remove();
                        
                    } else {
                        let g = style !== undefined ? style : "default";
                        if (style !== undefined) {
                            cls.subMessageObj.removeAttr("class").addClass("text-" + g);
                        }
                        setTimeout(function () {
                            cls.subMessageObj.find('small').html(c);
                            cls.subMessageObj.appendTo(cls.modelBody);
                        }, 0);
                        
                        
                    }
                    
                    
                    return this;
                    
                    
                };
                
                cls.setSubMessageStyle = function (style) {
                    
                    cls.subMessageObj.addClass("text-" + style);
                    
                    return this;
                };
                
                cls.footer = function () {
                    
                    return $.extend(
                        cls.modelFooter,
                        {
                            addAction: function (obj) {
                                cls.modelFooter.append(obj)
                                
                            }
                            
                            
                        });
                };
                
                cls.actions = function () {
                    return cls.actionsWrapper;
                };
                
                cls.addAction = function (obj) {
                    
                    if (obj.isArray) {
                        
                        obj = obj.reverse();
                        
                        for (let o in obj) {
                            cls.actionsWrapper.append(obj[o]);
                        }
                        
                    } else {
                        cls.actionsWrapper.append(obj);
                    }
                    
                    return this;
                    
                };
                
                cls.setDismissible = function (c) {
                    
                    cls.dismissible = c;
                    if (c) {
                        cls.dismissibleObj.prependTo(cls.modalHeaderObj)
                    } else {
                        cls.dismissibleObj.remove()
                    }
                    return cls;
                    
                };
                
                cls.loaderCreate = function (callback) {
                    
                    cls.modelLoader = $("<div>").addClass("loader").appendTo(cls.modelFooter);
                    cls.loader("hide");
                    
                    if (undefined !== callback && "function" === typeof callback)
                        callback();
                    
                    
                    return this;
                    
                };
                
                cls.loader = function (action, callback) {
                    
                    function loaderCreateAndShow() {
                        cls.modelLoader.css("display", "block");
                        if (undefined !== callback && "function" === typeof callback) {
                            setTimeout(function () {
                                callback();
                            }, 500);
                        }
                        
                    }
                    
                    switch (action) {
                        case "show":
                            
                            if (cls.modelLoader === undefined) {
                                cls.loaderCreate(function () {
                                    loaderCreateAndShow();
                                });
                            } else {
                                loaderCreateAndShow();
                            }
                            
                            // Create timeout object
                            cls.timeoutObject = setTimeout(function () {
                                
                                cls
                                    .setMessage("Please reload the Page")
                                    .setTitle("Request out of the time ")
                                    .loader("hide");
                                
                                cls.actions().empty();
                                
                                let cancelAction = new $.tsoftx.alertAction();
                                cancelAction.setTitle("Reload").beforeClick(
                                    function () {
                                        cls.loader("show");
                                        this.property("disabled", true);
                                    }
                                ).click(function () {
                                    window.location.reload(true);
                                })
                                    .create()
                                    .actionTo(cls.actions())
                                
                                
                            }, cls.timeoutInterval);
                            
                            
                            break;
                        case "hide":
                        case "hidden":
                        case "dismiss":
                            
                            clearTimeout(cls.timeoutObject);
                            
                            cls.modelLoader.css("display", "none");
                            if (undefined !== callback && "function" === typeof callback) {
                                setTimeout(function () {
                                    callback();
                                }, 500);
                            }
                            break;
                        case "destroy":
                        case "remove":
                        case "kill":
                            
                            clearTimeout(cls.timeoutObject);
                            
                            cls.modelLoader.remove();
                            cls.modelLoader = undefined;
                            
                            if (undefined !== callback && "function" === typeof callback) {
                                setTimeout(function () {
                                    callback();
                                }, 500);
                            }
                            break;
                        
                    }
                    
                    /*return $.extend({
                     self:cls.modelLoader[0],
                     remove:function(){
                     cls.modelLoader.remove();
                     }

                     },cls);*/
                    return cls;
                    
                };
                
                /**
                 *
                 * @param opt 'click, html'
                 * @param animate True or False
                 * @param callback Click handler
                 * @returns {{self: *, disabled: disabled, style: style, text: text, remove: remove}}
                 */
                cls.okAction = function (opt, animate, callback) {
                    
                    let o = this;
                    
                    if (opt !== undefined) {
                        
                        cls.okActionObj.appendTo(cls.actionsWrapper);
                        
                        if (animate !== undefined && typeof animate === "boolean") {
                        
                        } else if (animate !== undefined && typeof  animate === "function") {
                            callback = animate;
                        }
                        
                        switch (opt) {
                            case "beforeClick":
                                
                                if (callback !== undefined && typeof callback === "function") {
                                    
                                    cls.okActionBeforeClickEvent = callback;
                                }
                                
                                
                                break;
                            
                            case "click":
                                
                                
                                if (callback !== undefined && typeof callback === "function") {
                                    
                                    cls.okActionObj.click(function () {
                                        
                                        let b = $(this);
                                        
                                        if (animate !== undefined && typeof animate === "boolean" && animate) {
                                            // cls.modelLoader.appendTo(cls.modelFooter);
                                            cls.loader("show");
                                        }
                                        
                                        cls.okActionBeforeClickEvent.call(cls.okAction, cls);
                                        
                                        setTimeout(function () {
                                            
                                            cls = $.extend(cls, {
                                                self: cls.okActionObj,
                                                disabled: function (val) {
                                                    cls.buttonStatus(b, "disabled", val)
                                                },
                                                text: function (val) {
                                                    
                                                    cls.okActionObj.html(val);
                                                    
                                                },
                                                style: function (style) {
                                                    cls.okActionObj.addClass("btn-" + style);
                                                    
                                                },
                                                remove: function () {
                                                    cls.okActionObj.remove();
                                                }
                                            });
                                            
                                            callback.call(cls.okAction, cls);
                                            
                                            // Added on 06.12.2017 15:55
                                            
                                            // callback = undefined;
                                            
                                        }, 100);
                                        
                                        
                                    });
                                    
                                }
                                
                                
                                break;
                            
                            case "text":
                                
                                cls.okActionObj.text(animate);
                                
                                break;
                            
                            case "html":
                                
                                cls.okActionObj.html(animate);
                                
                                break;
                            
                            
                            case "style":
                                
                                cls.okActionObj.removeClass(function (index, className) {
                                    return (className.match(/\bbtn-\S+/g) || []).join(' ');
                                });
                                cls.okActionObj.addClass("btn-" + animate);
                                
                                break;
                            
                            case "icon":
                                
                                let pos = callback;
                                let icon = animate;
                                
                                let
                                    span = $("<span>").addClass("glyphicon"), i;
                                
                                if (pos === undefined || pos === "after") {
                                    i = $("<i>").addClass("icon ml-5 " + icon).appendTo(span);
                                    span.appendTo(cls.okActionObj);
                                    
                                } else if (callback === "before") {
                                    i = $("<i>").addClass("icon mr-5 " + icon).appendTo(span);
                                    span.prependTo(cls.okActionObj);
                                }
                                
                                break;
                            
                            case "disabled": // Use Animate as Value
                                cls.buttonStatus(cls.okActionObj, "disabled", animate);
                                break;
                            
                            case "enabled": // Use Animate as Value
                                cls.buttonStatus(cls.okActionObj, "disabled", !animate);
                                break;
                            
                            case "remove":
                                
                                cls.okActionObj.remove();
                                
                                break;
                            
                        }
                        
                    }
                    
                    
                    return cls;
                    
                    
                };
                
                cls.getCancelAction = function () {
                    return cls.cancelActionObj;
                };
                
                cls.getOkAction = function () {
                    return cls.okActionObj;
                };
                
                cls.cancelAction = function (opt, animate, callback) {
                    
                    
                    if (opt !== undefined) {
                        
                        cls.cancelActionObj.appendTo(cls.actionsWrapper);
                        
                        if (animate !== undefined && typeof animate === "boolean") {
                        
                        } else if (animate !== undefined && typeof  animate === "function") {
                            callback = animate;
                        }
                        
                        
                        switch (opt) {
                            
                            case "beforeClick":
                                
                                if (callback !== undefined && typeof callback === "function") {
                                    
                                    cls.canceActionBeforeClickEvent = callback;
                                }
                                
                                break;
                            
                            case "click":
                                
                                cls.cancelActionObj.removeAttr("data-dismiss").removeData("dismiss").data("role", "ok");
                                
                                if (callback !== undefined && typeof callback === "function") {
                                    
                                    cls.cancelActionObj.unbind("click").click(function () {
                                        
                                        
                                        let b = $(this);
                                        
                                        if (animate !== undefined && typeof animate === "boolean" && animate) {
                                            // cls.modelLoader.appendTo(cls.modelFooter);
                                            cls.loader("show");
                                        }
                                        
                                        
                                        cls.cancelActionBeforeClickEvent.call(cls.cancelAction, cls);
                                        
                                        setTimeout(function () {
                                            
                                            cls = $.extend(cls, {
                                                self: cls.cancelActionObj,
                                                disabled: function (val) {
                                                    cls.buttonStatus(b, "disabled", val)
                                                },
                                                text: function (val) {
                                                    
                                                    cls.cancelActionObj.html(val);
                                                    
                                                },
                                                style: function (style) {
                                                    cls.cancelActionObj.addClass("btn-" + style);
                                                    
                                                },
                                                remove: function () {
                                                    cls.cancelActionObj.remove();
                                                }
                                            });
                                            
                                            callback.call(cls.cancelAction, cls);
                                            
                                            // Added on 06.12.2017 15:55
                                            // callback = undefined;
                                            
                                            
                                        }, 100);
                                        
                                        
                                    });
                                    
                                }
                                
                                
                                break;
                            
                            case "text":
                                cls.cancelActionObj.text(animate);
                                break;
                            case "html":
                                cls.cancelActionObj.html(animate);
                                break;
                            
                            
                            case "style":
                                
                                cls.cancelActionObj.removeClass(function (index, className) {
                                    return (className.match(/\bbtn-\S+/g) || []).join(' ');
                                });
                                cls.cancelActionObj.addClass("btn-" + animate);
                                
                                break;
                            
                            case "icon":
                                
                                let pos = callback;
                                let icon = animate;
                                
                                let
                                    span = $("<span>").addClass("glyphicon"), i;
                                
                                if (pos === undefined || pos === "after") {
                                    i = $("<i>").addClass("icon ml-5 " + icon).appendTo(span);
                                    span.appendTo(cls.cancelActionObj);
                                    
                                } else if (callback === "before") {
                                    i = $("<i>").addClass("icon mr-5 " + icon).appendTo(span);
                                    span.prependTo(cls.cancelActionObj);
                                }
                                
                                
                                break;
                            
                            case "enabled": // Use Animate as Value
                                cls.buttonStatus(cls.cancelActionObj, "disabled", !animate);
                                break;
                            case "disabled": // Use Animate as Value
                                cls.buttonStatus(cls.cancelActionObj, "disabled", animate);
                                break;
                            case "remove":
                                cls.cancelActionObj.remove();
                                break;
                            
                            
                        }
                        
                        
                    }
                    
                    
                    return cls;
                    
                    
                };
                
                cls.buttonStatus = function (el, operation, value) {
                    
                    switch (operation) {
                        
                        case "disabled":
                            
                            if (value) {
                                $(el).attr(operation, operation);
                            } else {
                                $(el).removeAttr(operation);
                            }
                            
                            break;
                    }
                };
                
                cls.show = function (callback) {
                    
                    
                    if (cls.getIDNumber() === undefined) {
                        
                        // alert("Currently Modal Alert need the specific id number!");
                        // No necessary for this Project
                        
                    } else {
                        
                        if (undefined !== cls.alertIDObj[0]) {
                            setTimeout(function () {
                                console.log("ID;", cls.alertIDObj);
                                cls.alertIDObj[0].innerText = "(" + cls.getIDNumber() + ")";
                            }, 50);
                        }
                    }
                    
                    
                    setTimeout(function () {
                        
                        if (!cls.dismissible) {
    
                            $(cls.m).modal({
                                backdrop: 'static',
                                keyboard: false
                            });
    
                            
                            
                            $(cls.m).velocity("transition.expandIn",{duration:400, mobileHA: true,backdrop: 'static',
                                keyboard: false});

                            
                        } else {
                            
                            $(cls.m)
                                .one('shown.bs.modal', null, function () {
                                    
                                    if (cls.getFocusEl() === undefined) {
                                        let firstEl = null;
                                        $(cls.messageObj).find("*").each(function () {
                                            if ($(this).attr("input:not[type=hidden]") || $(this)[0].nodeName == "SELECT" || $(this)[0].nodeName == "TEXTAREA") {
                                                firstEl = $(this)[0];
                                                return false;
                                            }
                                        });
                                        if (firstEl !== null)
                                            firstEl.focus();
                                        
                                    } else {
                                        $(cls.getFocusEl()).focus();
                                    }
                                    
                                    
                                }) // only called once
                                .one('hidden.bs.modal', function () {
                                    $(this).data('bs.modal', null);
                                    $(this).remove();
                                    try {
                                        cls.dismCallEvent();
                                    } catch (e) {
                                    
                                    }
                                }) // only called once
                                .modal();
                            
                        }
                        
                        
                        if (typeof callback === "function" && undefined !== callback) {
                            
                            setTimeout(function () {
                                callback.call(
                                    $.extend({
                                            content: cls.messageObj[0]
                                        },
                                        cls
                                    ));
                                
                            }, 300);
                            
                        }
                        
                    }, 100);
                    
                    return this;
                };
                
                cls.dismiss = function (callback) {
                    $(cls.m).modal("hide");
                    if (callback !== undefined && typeof callback === "function") {
                        callback.call(cls);
                    }
                    return this;
                    
                    
                };
                
                cls.dismissCallback = function (callback) {
                    
                    if (callback !== undefined && typeof callback === "function") {
                        cls.dismCallEvent = callback;
                    }
                    
                    return this;
                    
                };
                
                cls.setDismissEvent = function (callback) {
                    
                    
                    if (callback !== undefined && typeof callback === "function") {
                        cls.dismCallEvent = callback;
                    }
                    
                    return this;
                    
                };
                
                
                this.init();
                
            };
    
            this.deviceAlert = function () {
        
        
                let title = "Title";
                let message = "Message";
                let actions = [];
        
                this.setTitle = function (title) {
                    this.title = title;
                    return this;
                };
        
                this.getTitle = function () {
                    return this.title;
                };
        
                this.setMessage = function (message) {
                    this.message = message;
                    return this;
                };
        
                this.getMessage = function () {
                    return this.message;
                };
        
                this.addAction = function (action) {
                    actions.push(action);
                    return this;
                };
        
                this.getActions = function () {
                    return actions;
                };
        
                this.show = function(){
            
                    let dataJSON = {};
                    dataJSON.title = this.getTitle();
                    dataJSON.message = this.getMessage();
                    dataJSON.actions = this.getActions();
            
                    let dataJSONString = JSON.stringify(dataJSON);
            
                    // alert(DEVICE + "://" + ACTIVITY.ACTIVITY_ALERT_VIEW + "?" + dataJSONString);
            
                    location.href = DEVICE + "://" + ACTIVITY.ACTIVITY_ALERT_VIEW + "?" + dataJSONString;
            
                }
        
                
                return this;
        
            }
    
            
            
            this.loader = function () {
                
                let cls = this;
                let obj = null;
                
                
                cls.m = null;
                cls.le = null;
                let showInAnotherEl = false;
                cls.transparent = false;
                
                
                cls.bg = function () {
                    
                    cls.m = $("div#loader");
                    if (!cls.m.length) {
                        
                        let $w = $("<div>");
                        $w.attr("id", "loader");
                        if (!cls.transparent) {
                            $w.addClass("modal fade");
                            $w.data("role", "loader");
                        } else {
                            $w.addClass("modal-transparent");
                        }
                        document.getElementsByTagName("html")[0].appendChild($w[0]);
                        cls.m = $w;
                        
                    }
                    
                    return cls.m;
                    
                };
                
                // Transparent Loader
                cls.setTransparent = function () {
                    
                    // cls.m.css("background-color", "transparent", "important");
                    cls.transparent = true;
                    return this;
                    
                };
                
                cls.loaderEl = function () {
                    
                    if (!cls.transparent) {
                        let $c = new $("<div>");
                        $c.addClass("tsoftx-loader");
                        $c.attr("id", Math.floor(Math.random() * 99));
                        cls.le = $c;
                        return cls.le;
                    }
                    
                };
                
                cls.init = function () {
                    this.bg().append(cls.loaderEl());
                };
                
                cls.showIn = function (el) {
                    showInAnotherEl = true;
                    el.append($(cls.loaderEl()));
                    
                    $(cls.loaderEl()).css("margin-left", "").css("margin-right", "").css("margin-top", "");
                };
                
                cls.show = function (callback) {
                    
                    if (!cls.loaderExists()) {
                        
                        if (!showInAnotherEl) {
                            cls.init();
                        }
                        
                        if (!cls.transparent) {
                            // $(cls.m).modal("show");
                            let s = $(cls.m).modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                        }
                        
                        
                        
                        if (undefined !== callback && typeof callback === "function") {
                            setTimeout(function () {
                                callback();
                            }, 300);
                        }
                    }
                    
                    return this;
                    
                };
                
                cls.loaderExists = function () {
                    return $("div").filter(function () {
                        return $(this).data("role") === "loader";
                    }).length;
                };
                
                cls.dismiss = function (callback) {
                    
                    
                    if (!showInAnotherEl) {
                        
                        if (!cls.transparent) {
                            
                            $(cls.m).modal("hide");
                            setTimeout(function () {
                                $(cls.m).remove();
                                cls.loaderEl().remove();
                                if( $("body").find(".modal-backdrop").length ){
                                    $("body").find(".modal-backdrop").remove();
                                }
                            }, 100);
                            
                        } else {
                            cls.m.remove();
                        }
                        
                        if (undefined !== callback && typeof callback === "function") {
                            callback();
                        }
                    } else {
                        
                        alert($(cls.le)[0]);
                        cls.loaderEl().remove();
                    }
                    // showInAnotherEl = false;
                    
                };
                
                // this.init();
                
                $.tsoftx.loaderObj = cls;
                return this;
                
            };
            
            this.ajax = function () {
    
                
                
                let cls = this;
                cls.cnt = "";
                cls.nsp = "!";
                cls.mtd = "";
                cls.data = {};
                cls.indicator = false;
                cls.l = new $.tsoftx.loader();
                cls.processWithSession = true;
                cls.sessionExpiredCallback = function () {
                };
                cls.setCnt = function () {
                };
                cls.setNsp = function () {
                };
                cls.setMtd = function () {
                };
                cls.setData = function () {
                };
                cls.execute = function () {};
                cls.onProcess = function () {};
                cls.init = function () {
                    return cls;
                };
                cls.setCnt = function (val) {
                    cls.cnt = val;
                    return cls;
                };
                cls.setNsp = function (val) {
                    cls.nsp = val;
                    return cls;
                };
                cls.setMtd = function (val) {
                    cls.mtd = val;
                    return cls;
                };
                cls.beforeSendCallback = function () {
                };
                cls.withAnimate = function (val) {
                    cls.indicator = val
                };
                cls.setData = function (arrData) {
                    cls.data = arrData;
                    return cls;
                };
                cls.execute = function (callback, errorCallback ) {
                    
                    if (cls.data === undefined) {
                        cls.data = {};
                    }
                    
                   
                    cls.data.output = "json";
                    
                    
                    
                    $.sa_session.check(cls.l, function () {
    
                        // console.log("sa_session URL ", this);
                        
                        if ( this || (!this && !cls.processWithSession ) ) {
                            
                            let url = base_url + "/" + cls.cnt + "/" + cls.nsp + "/" + cls.mtd;
                            
                            // console.log("sa_session URL ", url);
                            
                            // Process with no session check
                            if (!cls.processWithSession) {
                                cls.data.with_session = false;
                            }
                            let interval = null, total = null, completed = null,percentage = null;
                            
                            try
                            
                            {
    
                                
                                $.ajax({
                                    method: "POST",
                                    url: url,
                                    data: cls.data,
                                    /*async:false,*/
                                    /*xhr: function () {*/
    
                                        /*let xhr = jQuery.ajaxSettings.xhr();
                                            console.log("Ready State", xhr);
                                        xhr.onprogress = function(e){
    */
                                        
                                        /*interval = setInterval(function () {
        
        
                                                // if (xhr.readyState > 2){
                                                total = parseInt(xhr.getResponseHeader('Content-length'));
                                                completed = parseInt(xhr.responseText.length);
                                                percentage = (100.0 / total * completed).toFixed(2);
                                                console.log("Completed %", );
                                                // }
        
                                            }, 50);*/
                                            
                                       /* }*/
                                        
        
                                    /*},*/
                                    beforeSend: function () {
                                        
                                        cls.beforeSendCallback();
                                    },
                                    complete: function () {
                                        setTimeout(function () {
                                            // clearInterval(interval);
                                        }, 1000);
                                    },
                                    success: function (dt) {
                                        
                                        
                                        console.log("TEMPORARY AJAX RESULTA,", dt);
    
                                        
                                        try {
                                            if (typeof dt === "string" && JSON.parse(dt)) {
                                                dt = JSON.parse(dt);
                                            }
                                            callback.call(dt["data"][0]);
                                            
                                        } catch (e) {
                                            
                                            // dt.message = e.message;
                                            
                                           /* try{
                                                let alert = new $.tsoftx.deviceAlert();
                                                alert.setTitle( "kritisches Problem" )
                                                    .setMessage( "Fehler aufgeteren \n" + e.message )
                                                    .addAction({
                                                        title: "Ok",
                                                        action: "",
                                                        style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                                                    })
        
                                                    .addAction({
                                                        title: "Report",
                                                        action: "javascript:$.tsoftx.developerReport('" + dt + "');",
                                                        style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault
                                                    })
                                                    .show();
                                            } catch(e){*/
                                                let ac = new $.tsoftx.alert(1000);
                                                ac
                                                    .setTitle("Function Error")
                                                    .setType("danger", "white")
                                                    .setMessage(dt + "<br />" + e.message + "<br />" + url)
                                                    .cancelAction("text", "Schließen")
                                                    .show();
    
                                                console.log("FUNCTION ERROR:", e);
    
                                                // cls.setErrorCallback(dt, dt, dt);
                                            /*}*/
                                            
                                            
    
                                            if (undefined !== errorCallback && typeof errorCallback === "function") {
                                                errorCallback();
                                            }
                                            
                                            
                                        }
    
                                        
                                        
                                    },
                                    error: function (request, status, error) {
                                        alert("Error");
                                        if (undefined !== errorCallback && typeof errorCallback === "function") {
                                            errorCallback(request, status, error);
                                        }
                                    },
                                    fail: function (jqXHR, textStatus, errorThrown) {
                                       alert("Fail");
                                        if (undefined !== errorCallback && typeof errorCallback === "function") {
                                            errorCallback(jqXHR, textStatus, errorThrown);
                                        }
                                    }
                                });
    
    
                                
                                
                            } catch (e) {
                                if (undefined !== errorCallback && typeof errorCallback === "function") {
                                    errorCallback( e.message, e.message, e.message );
                                }
                            }
                            
                            
                        } else {
    
                            
                            // If device Android
                            if (undefined !== errorCallback && typeof errorCallback === "function") {
                                errorCallback("Error 1","Error 2","Error 3");
                            }
                            
                            
                        }
                        
                        
                    }, errorCallback );
                    
                    
                    return cls;
                    
                };
                
                cls.error = function (callback) {
                    
                    
                    if (undefined !== callback && typeof callback === "function") {
                        cls.errorCallback = callback;
                    }
                    
                    return cls;
                    
                };
                
                cls.s_expired = function (callback) {
                    
                    if (undefined !== callback && typeof callback === "function") {
                        cls.sessionExpiredCallback = callback;
                    }
                    
                    return cls;
                    
                };
                
                cls.setProcessWithSession = function (val) {
                    cls.processWithSession = val;
                    return cls;
                };
                
                cls.beforeSend = function (callback) {
                    
                    if (undefined !== callback && typeof callback === "function") {
                        cls.beforeSendCallback = callback;
                    }
                    return cls;
                    
                };
                
                
                this.init();
                
            };
    
            this.HttpRequest = function (animate) {
        
                
        
                let cls = this;
                cls.cnt = "";
                cls.nsp = "!";
                cls.mtd = "";
                cls.data = {};
                cls.requestAnimate = undefined === animate ? false : animate;
                cls.activityIndicator = null;
                cls.l = new $.tsoftx.loader();
                cls.processWithSession = true;
                cls.setErrorCallback = function (request, status, error) {
                };
                cls.sessionExpiredCallback = function () {
                };
                /**
                 * Request Controller
                 */
        
                cls.setCnt = function () {
                };
                /**
                 * Request Namespace default !
                 */
        
                cls.setNsp = function () {
                };
        
                /**
                 * Request Method
                 */
                cls.setMtd = function () {
                };
        
                /**
                 * set the external Indicator
                 * @param indicator Indicator Object
                 * @returns {cls}
                 */
                cls.setActivityIndicator = function (indicator) {
                    this.activityIndicator = indicator;
                    return this;
                };
        
                /**
                 * Get ActivityIndicator Success Ich setted the outside Indicator with setActivityIndicator Method
                 * @returns Indicator Object
                 */
                cls.getActivityIndicator = function () {
                    return this.activityIndicator;
                };
        
                /**
                 * this Method Create And Run Animate Before Request send
                 * @returns {cls}
                 */
                cls.setLocalActivityIndicator = function () {
                    this.activityIndicator = $.tsoftx.loader();
                    this.activityIndicator.show();
                    return this;
                };
        
                /**
                 *
                 * @param val Boolean -> with true Forward the execute to animate method
                 * @returns {cls}
                 */
                cls.setRequestWithAnimate = function (val) {
                    this.requestAnimate = val;
                    return this;
                };
                /**
                 * Return Boolean Using by Execute operation
                 * @returns {*}
                 */
                cls.getRequestWithAnimate = function () {
                    return this.requestAnimate;
                };
        
                /**
                 * Send Parameter for Request with method
                 */
                cls.setData = function () {
                };
        
                /**
                 * Request Exceute
                 */
                cls.execute = function () {
                };
        
                cls.init = function () {
                    return cls;
                };
                cls.setCnt = function (val) {
                    cls.cnt = val;
                    return cls;
                };
                cls.setNsp = function (val) {
                    cls.nsp = val;
                    return cls;
                };
                cls.setMtd = function (val) {
                    cls.mtd = val;
                    return cls;
                };
                cls.beforeSendCallback = function () {
                };
        
                cls.setData = function (arrData) {
                    cls.data = arrData;
                    return cls;
                };
                cls.setData = function (arrData) {
                    cls.data = arrData;
                    return cls;
                };
                cls.execute = function (callback) {
            
                    cls.data.output = "json";
            
                    if( cls.getRequestWithAnimate() ){
                
                        return cls.executeWithAnimation(callback)
                
                    }
            
            
                    $.sa_session.check(cls.l, function () {
                
                        console.log("this", this);
                
                        if (this || (!this && !cls.processWithSession)) {
                    
                            let url = base_url + "/" + cls.cnt + "/" + cls.nsp + "/" + cls.mtd;
                    
                            // Process with no session check
                            if (!cls.processWithSession) {
                                cls.data.with_session = false;
                            }
                            console.log(JSON.stringify(cls.data));
                    
                            try {
                        
                                $.ajax({
                                    method: "POST",
                                    url: url,
                                    data: cls.data,
                                    beforeSend: function () {
                                
                                        cls.beforeSendCallback();
                                    },
                                    complete: function () {
                                
                                    },
                                    success: function (dt) {
                                
                                
                                        if( null !== cls.getActivityIndicator() ){
                                            cls.getActivityIndicator().dismiss();
                                        }
                                
                                        console.log("TEMPORARY AJAX RESULTA,", dt);
                                
                                        try {
                                            if (typeof dt === "string" && JSON.parse(dt)) {
                                                dt = JSON.parse(dt);
                                            }
                                            callback.call(dt);
                                    
                                        } catch (e) {
                                    
                                    
                                    
                                    
                                    
                                            let ac = new $.tsoftx.alert(1000);
                                            ac
                                                .setTitle("Function Error")
                                                .setType("danger")
                                                .setMessage(dt + "<br />" + e.message)
                                                .cancelAction("text", lang.close)
                                                .show(function () {
                                            
                                                });
                                    
                                    
                                            cls.setErrorCallback(dt, dt, dt);
                                    
                                        }
                                    },
                                    error: function (request, status, error) {
                                
                                        if( null !== cls.getActivityIndicator() ){
                                            cls.getActivityIndicator().dismiss();
                                        }
                                
                                        console.log(request, status, error);
                                        cls.setErrorCallback(request, status, error);
                                    },
                                    fail: function (jqXHR, textStatus, errorThrown) {
                                
                                        if( null !== cls.getActivityIndicator() ){
                                            cls.getActivityIndicator().dismiss();
                                        }
                                
                                        alert(jqXHR);
                                    }
                                });
                        
                        
                            } catch (e) {
                        
                                if( null !== cls.getActivityIndicator() ){
                                    cls.getActivityIndicator().dismiss();
                                }
                        
                                console.log(e);
                            }
                    
                    
                        } else {
                    
                            if( null !== cls.getActivityIndicator() ){
                                cls.getActivityIndicator().dismiss();
                            }
                    
                            console.log("Session Expired!");
                            cls.sessionExpiredCallback();
                    
                    
                        }
                
                
                    });
            
            
                    return cls;
            
                };
        
                cls.executeWithAnimation = function(){
            
                    cls.data.output = "json";
            
                    let ai = $.tsoftx.loader();
            
                    ai.show(function () {
                
                        $.sa_session.check(cls.l, function () {
                    
                    
                            if (this || (!this && !cls.processWithSession)) {
                        
                                let url = base_url + "/" + cls.cnt + "/" + cls.nsp + "/" + cls.mtd;
                        
                                // Process with no session check
                                if (!cls.processWithSession) {
                                    cls.data.with_session = false;
                                }
                        
                                try {
                            
                                    $.ajax({
                                        method: "POST",
                                        url: url,
                                        data: cls.data,
                                        beforeSend: function () {
                                    
                                            cls.beforeSendCallback();
                                        },
                                        complete: function () {
                                    
                                        },
                                        success: function (dt) {
                                    
                                    
                                            console.log("TEMPORARY AJAX RESULTA,", dt);
                                    
                                            try {
                                        
                                                ai.dismiss();
                                        
                                                if (typeof dt === "string" && JSON.parse(dt)) {
                                                    dt = JSON.parse(dt);
                                                }
                                                callback.call(dt);
                                        
                                        
                                            } catch (e) {
                                        
                                        
                                        
                                        
                                                let ac = new $.tsoftx.alert(1000);
                                                ac
                                                    .setTitle("Function Error")
                                                    .setType("danger")
                                                    .setMessage(dt + "<br />" + e.message)
                                                    .cancelAction("text", lang.close)
                                                    .show(function () {
                                                        ai.dismiss();
                                                    });
                                        
                                        
                                                cls.setErrorCallback(dt, dt, dt);
                                        
                                            }
                                        },
                                        error: function (request, status, error) {
                                            console.log(request, status, error);
                                            cls.setErrorCallback(request, status, error);
                                            ai.dismiss();
                                        },
                                        fail: function (jqXHR, textStatus, errorThrown) {
                                            alert(jqXHR);
                                            ai.dismiss();
                                        }
                                    });
                            
                            
                                } catch (e) {
                                    console.log(e);
                                }
                        
                        
                            } else {
                        
                                console.log("Session Expired!");
                                cls.sessionExpiredCallback();
                                ai.dismiss();
                        
                        
                            }
                    
                    
                        });
                
                
                
                    });
            
            
            
            
            
                    return cls;
            
                }
        
        
                cls.error = function (callback) {
            
            
                    if (undefined !== callback && typeof callback === "function") {
                        cls.setErrorCallback = callback;
                    }
            
                    return cls;
            
                };
        
                cls.s_expired = function (callback) {
            
                    if (undefined !== callback && typeof callback === "function") {
                        cls.sessionExpiredCallback = callback;
                    }
            
                    return cls;
            
                };
        
                cls.setProcessWithSession = function (val) {
                    cls.processWithSession = val;
                    return cls;
                };
        
                cls.beforeSend = function (callback) {
            
                    if (undefined !== callback && typeof callback === "function") {
                        cls.beforeSendCallback = callback;
                    }
                    return cls;
            
                };
        
        
                this.init();
        
            };
            
            this.processResultaWithView = function( parent, message, color ){
                
                let view = $("<div>")[0];
                // 1 view.classList.add("row", "alert", "alert-" + color, "alert-dismissable", "process-alert", "alert-show", "font-small", "font-italic", "pl-10", "mb-0", "mt-0", "box-with-border-radius-none");
                // 2
                // view.classList.add("top-result-view", "row", "alert", "alert-" + color, "alert-dismissable", "invisible", "font-small", "font-italic", "pl-20", "mb-0", "ml-0", "mr-0", "box-with-border-radius-none", "pos-fixed", "w-100");
                // view.classList.add("top-result-view", "row", "alert", "alert-" + color, "alert-dismissable", "font-small", "font-italic", "pl-20", "mb-0", "ml-0", "mr-0", "box-with-border-radius-none", "w-100");
                view.classList.add("top-result-view", "alert-" + color);
                view.style.zIndex = 2;
                view.innerText = message;
                
                parent.prepend(view);
                /* 1
                setTimeout(function () {
                    view.classList.add("alert-hide");
                    setTimeout(function () {
                        view.remove();
                    }, 3000);
                },500);
                */
                // 2
               /* let h = view.offsetHeight;
                view.style.marginTop = -h;
                view.classList.remove("invisible");
                $(view).animate({
                    marginTop:0
                },300, function(){
                    
                    setTimeout(function () {
                        $(view).animate({
                            marginTop:-h
                        },300,function(){
                            view.remove();
                        });
                    },2000);
                    
                    
                });*/
                
                
                
                // 3
                /*
                let style = document.documentElement.appendChild(document.createElement("style"));
                let rule = " run {\
                                    0%   {\
                                        -webkit-transform: translate3d(0, 0, 0); }\
                                        transform: translate3d(0, 0, 0); }\
                                    }\
                                    100% {\
                                        -webkit-transform: translate3d(0, " + 10 + "px, 0);\
                                        transform: translate3d(0, " + 10 + "px, 0);\
                                    }\
                                }";
    
    
                if (CSSRule.KEYFRAMES_RULE) {
                    style.sheet.insertRule("@keyframes" + rule, 0);
                } else if (CSSRule.WEBKIT_KEYFRAMES_RULE) { // WebKit
                    style.sheet.insertRule("@-webkit-keyframes" + rule, 0);
                }
    
                let
                    stylesheet = document.styleSheets[0] // replace 0 with the number of the stylesheet that you want to modify
                    , rules = stylesheet.rules
                    , i = rules.length
                    , keyframes
                    , keyframe
                ;
    
                while (i--) {
                    keyframes = rules.item(i);
                    if (
                        (
                            keyframes.type === keyframes.KEYFRAMES_RULE
                            || keyframes.type === keyframes.WEBKIT_KEYFRAMES_RULE
                        )
                        && keyframes.name === "run"
                    ) {
                        rules = keyframes.cssRules;
                        i = rules.length;
                        while (i--) {
                            keyframe = rules.item(i);
                            if (
                                (
                                    keyframe.type === keyframe.KEYFRAME_RULE
                                    || keyframe.type === keyframe.WEBKIT_KEYFRAME_RULE
                                )
                                && keyframe.keyText === "100%"
                            ) {
                                keyframe.style.webkitTransform =
                                    keyframe.style.transform =
                                        "translate3d(0, " + 50 + "px, 0)";
                                break;
                            }
                        }
                        break;
                    }
                }
                */
                
                
                
            }
            
            
            this.lang = function (key) {
                let lang = JSON.parse(lang);
                return lang[key];
            };
            
            this.formControl = function (el, callback, errCallback) {
                
                
                let status = true;
                let needFields = [];
                el.find("*[required]").each(function () {
                    
                    
                    let $t = $(this);
                    
                    switch ($t[0].nodeName) {
                        case "INPUT":
                            switch ($t.attr("type")) {
                                case "text":
                                case "password":
                                case "email":
                                case "date":
                                case "hidden":
                                    
                                    
                                    if ($t.val() === "") {
                                        
                                        let bt = window.getComputedStyle($t[0], null).getPropertyValue("border-top"),
                                            bb = window.getComputedStyle($t[0], null).getPropertyValue("border-bottom"),
                                            bl = window.getComputedStyle($t[0], null).getPropertyValue("border-left"),
                                            br = window.getComputedStyle($t[0], null).getPropertyValue("border-right");
                                        
                                        
                                        // alert( parseInt(bt) + " " + parseInt(bl) + " " +  parseInt(br) + " " + parseInt(bb) );
                                        
                                        if (!parseInt(bt) && !parseInt(bl) && !parseInt(br) && parseInt(bb)) {
                                            $t.addClass("missing-data-bottom")
                                        } else {
                                            $t.addClass("missing-data-all")
                                        }
                                        
                                        
                                        $t.on('click, blur, focus', function () {
                                            
                                            // $(this).removeClass("missing-data");
                                            // $(this).removeClass("missing-data", "missing-data-all", "missing-data-bottom");
                                            $(this).removeClass("missing-data").removeClass("missing-data-all").removeClass("missing-data-bottom");
                                        });
                                        
                                        if (undefined !== $t.data("missing-info")) {
                                            needFields.push(" * <font color='red'>" + $t.data("missing-info") + "</font>")
                                        }
                                        
                                        status = false;
                                        
                                        
                                    } else if ($t.attr("data-unacceptable") !== undefined && $t.attr("data-unacceptable") == "true") {
                                        
                                        console.log("For Element " + $t[0].getAttribute("name") + " " + $t[0].nodeName + " " + $t.data("unacceptable"));
                                        $t.on('click, blur, focus', function () {
                                            
                                            $(this).removeClass("missing-data").removeClass("missing-data-all").removeClass("missing-data-bottom");
                                        });
                                        
                                        status = false;
                                    }
                                    
                                    
                                    break;
                                
                                case "radio":
                                    
                                    let name = $t.attr("name");
                                    let totalUnchecked = $("input[type=radio][name=" + name + "]");
                                    if (!$("input[type=" + $t.attr("type") + "][name=" + name + "]:checked").length) {
                                        
                                        totalUnchecked.parent().css("color", "red");
                                        status = false;
                                    }
                                    
                                    totalUnchecked.click(function () {
                                        
                                        totalUnchecked.parent().css("color", "black");
                                        
                                        
                                    });
                                    
                                    
                                    break;
                                
                                case "checkbox":
                                    if (!$t.is(":checked")) {
                                        $t.parent().css("color", "red");
                                        $t.click(function () {
                                            $(this).parent().css("color", "black");
                                        });
                                        
                                        status = false;
                                        
                                    }
                                    
                                    break;
                                
                                
                            }
                            
                            
                            break;
                        
                        case "TEXTAREA":
                            
                            if ($t.val() === "") {
                                $t.addClass("missing-data").addClass("missing-data-all").click(function () {
                                    $(this).removeClass("missing-data").removeClass("missing-data-all");
                                });
                                
                                if (undefined !== $t.data("missing-show")) {
                                    needFields.push($t.data("missing-show"))
                                }
                                
                                status = false;
                                
                            }
                            
                            break;
                        
                        case "SELECT":
                            
                            if ($t.val() === "" || $t.val() == 0) {
                                $t.addClass("missing-data").addClass("missing-data-all").click(function () {
                                    $(this)
                                        .removeClass("missing-data")
                                        .removeClass("missing-data-all");
                                });
                                
                                if (undefined !== $t.data("missing-show")) {
                                    needFields.push($t.data("missing-show"))
                                }
                                
                                status = false;
                                
                            }
                            
                            break;
                        
                        
                    }
                    
                    
                });
                
                
                if (callback !== undefined && typeof callback === "function" && status) {
                    callback.call(el[0]);
                } else {
                    
                    if (needFields.length) {
                        needFields = needFields.join("<br />");
                    }
                    
                    if ($("*").filter(function () {
                            return $(this).data("modal-id") === "modal-form-error";
                        }).length) {
                        errCallback.call(el[0]);
                        return false;
                    }
                    
                    let ac = new $.tsoftx.alert(1001);
                    ac
                        .setTitle("Error with Form ")
                        .setType("danger")
                        .setModalID("modal-form-error")
                        .setMessage("Required form with errors, please check out of the content!<br />" + needFields)
                        .setDismissible(true)
                        // .setProcessWithSession(false)
                        .cancelAction('text', "Sließen")
                        .show(function () {
                            
                            if (errCallback !== undefined && typeof errCallback === "function") {
                                errCallback.call(el[0]);
                            }
                        });
                    
                    
                }
                
                
            };
            
            this.inputCheck = function (el, callback) {
                
                let errWithEmailAddress;
                let msgTitle = "Fehler aufgetreten";
                let msgMsg = "";
                let ac = new $.tsoftx.alert(1002);
                
                if (el === undefined)
                    return false;
                
                
                let wr;
                let tt = document.createElement("DIV");
                
                if (el.parentNode.nodeName == "DIV") {
                    
                    wr = el.parentNode;
                    
                } else {
                    
                    let clonedEl = el.cloneNode(true);
                    
                    // Create Wrapper
                    wr = document.createElement("div");
                    
                    $(el).replaceWith(wr);
                    
                    wr.appendChild(clonedEl);
                    
                    el = clonedEl;
                    
                    
                }
                
                wr.classList.add("input-checker");
                wr.style.position = "relative";
                
                el.dataset.toggle = "tooltip";
                // el.setAttribute("rel","tooltip");
                el.dataset.html = "true";
                // el.setAttribute("data-html", "true");
                // $.autoload.tooltip();
                $(el).tooltip();
                
                
                el.onblur = function () {
                    
                    
                    // Check input next element add on ( with icon )
                    let elAddOn = $(this).next().filter(function () {
                        return $(this).hasClass("input-group-addon");
                    });
                    
                    errWithEmailAddress = false;
                    
                    
                    if ($.trim($(this).val()) !== "") {
                        
                        // if ($(el).data("last-value") !== el.val()) {
                        if (el.dataset.lastValue !== el.value) {
                            
                            // set Indicator
                            wr.classList.add("check-indicator");
                            
                            el.classList.remove("missing-data", "missing-data-all", "missing-data-bottom");
                            
                            el.setAttribute("disabled", "disabled");
                            
                            
                            let type = $(this).attr("type") || $(this).data("type");
                            
                            switch (type) {
                                
                                case "text":
                                    break;
                                
                                case "email":
                                    
                                    // Text is email ?
                                    let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                                    if (!re.test(el.value)) {
                                        
                                        errWithEmailAddress = true;
                                        msgTitle = "Invalid Email Address!";
                                        msgMsg = "This email <b>" + el.value + "</b> is not valid!";
                                        
                                        
                                        // el.parent().addClass("missing-data").data("unacceptable", "true").data("last-value", el.val());
                                        // loader.removeClass("loader").removeClass("loader-mini").addClass("check-error").data("toggle","tooltip").attr("data-original-title", "Invalid email address");
                                        
                                        // $.autoload.tooltip();
                                        // return false;
                                        
                                    }
                                    
                                    
                                    break;
                                
                                
                            }
                            
                            let bt = window.getComputedStyle(el, null).getPropertyValue("border-top"),
                                bb = window.getComputedStyle(el, null).getPropertyValue("border-bottom"),
                                bl = window.getComputedStyle(el, null).getPropertyValue("border-left"),
                                br = window.getComputedStyle(el, null).getPropertyValue("border-right");
                            
                            
                            if (errWithEmailAddress) {
                                
                                ac
                                    .setType("danger")
                                    .setTitle(msgTitle)
                                    .setMessage(msgMsg)
                                    .cancelAction("text", "Sließen")
                                    .cancelAction("style", "danger")
                                    .show();
                                
                                if (!parseInt(bt) && !parseInt(bl) && !parseInt(br) && parseInt(bb)) {
                                    el.classList.add("missing-data-bottom")
                                } else {
                                    el.classList.add("missing-data-all")
                                }
                                
                                el.classList.add("missing-data");
                                el.dataset.unacceptable = true;
                                
                                
                                wr.classList.remove("loader", "loader-mini", "check-indicator");
                                wr.classList.add("check-error");
                                
                                el.setAttribute("data-original-title", msgTitle);
                                
                                el.removeAttribute("disabled");
                                
                                
                            }
                            
                            else {
                                
                                callback.call(el, function response(s) {
                                    
                                    console.log("Data", s);
                                    
                                    // let regex = /(<([^>]+)>)/ig, body = s.alertMessage, result = body.replace(regex, "");
                                    let result = s.alertMessage;
                                    el.setAttribute("data-original-title", result);
                                    
                                    if (s.found) {
                                        
                                        let ac = new $.tsoftx.alert(1003);
                                        ac
                                            .setType("danger")
                                            .setTitle(s.alertTitle)
                                            .setMessage(s.alertMessage)
                                            .cancelAction("text", "Sließen")
                                            .cancelAction("style", "danger")
                                            .show();
                                        
                                        
                                        if (!parseInt(bt) && !parseInt(bl) && !parseInt(br) && parseInt(bb)) {
                                            el.classList.add("missing-data-bottom")
                                        } else {
                                            el.classList.add("missing-data-all")
                                        }
                                        
                                        el.classList.add("missing-data");
                                        el.dataset.unacceptable = true;
                                        
                                        
                                        wr.classList.remove("loader", "loader-mini", "check-indicator", "check-success");
                                        wr.classList.add("check-error");
                                        
                                        
                                        el.removeAttribute("disabled");
                                        
                                        
                                    }
                                    else {
                                        
                                        el.classList.remove("missing-data", "missing-data-all", "missing-data-bottom");
                                        delete el.dataset.unacceptable;
                                        
                                        wr.classList.remove("loader", "loader-mini", "check-indicator", "check-error");
                                        wr.classList.add("check-success");
                                        
                                        el.removeAttribute("disabled");
                                        
                                        
                                    }
                                    
                                    
                                });
                                
                                
                            }
                            
                            
                        } else {
                        
                        
                        }
                        
                        console.log("For Blur Element " + el.getAttribute("name") + " " + el.nodeName + " " + el.dataset.unacceptable);
                        
                        
                    } else {
                        
                        
                        // el.removeClass("missing-data").removeData("unacceptable").removeData("last-value");
                        el.classList.remove("missing-data-all", "missing-data", "missing-data-bottom");
                        delete el.dataset.unacceptable;
                        el.removeAttribute("data-unacceptable");
                        
                        delete el.dataset.lastValue;
                        
                        wr.classList.remove("loader", "loader-mini", "check-indicator", "check-error", "check-success");
                        
                        el.removeAttribute("disabled");
                        
                        el.dataset.toggle = "";
                        
                        
                    }
                    
                    el.dataset.lastValue = el.value;
                    // tsoftx.js class
                    
                    
                }
                
                
                el.onfocus = function () {
                    console.log("For Focus Element " + el.getAttribute("name") + " " + el.nodeName + " " + el.dataset.unacceptable);
                }
                
            };
            
            
            this.showableInput = function (el, params, callback) {
                
                el.each(function (e) {
                    let inpGrp = $("<div>").addClass("input-group");
                    let inp = $(this).clone();
                    let iconWrapper = $("<span>").addClass("input-group-addon cursor-pointer");
                    let icon = $("<i>").addClass("icon " + params.on).appendTo(iconWrapper);
                    
                    inpGrp.append(inp);
                    inpGrp.append(iconWrapper);
                    
                    iconWrapper.on("click", function (e) {
                        
                        if (icon.hasClass(params.on)) {
                            icon.addClass(params.off).removeClass(params.on);
                            inp.attr("type", "text");
                        } else {
                            icon.removeClass(params.off).addClass(params.on);
                            inp.attr("type", "password");
                        }
                        
                    });
                    
                    // inpGrp.appendTo(el.parent());
                    // el.remove();
                    $(this).replaceWith(inpGrp);
                    
                    
                });
                
                
            };
            
            this.uploadableFiles = [];
            this.uploadManager = function (el, params, callback) {
                
                
                if (el === undefined) {
                    // alert( "Upload Object not found!");
                    return false;
                }
                
                // Prepare Zone
                el.classList.add("tsoftx-upload-zone");
                
                // Create Content area
                let zone = contentArea();
                let fileBox = [];
                let removedFileBox = [];
                let cHighlight = contentHighlight();
                
                
                let defaults = {
                    accept: ["jpg", "jpeg", "png", "PNG", "pdf"],
                    max_file: 1
                };
                
                params = $.extend(defaults, params);
                
                
                zone.onmousedown = function () {
                    // console.log("ZONE ZONE , " + this);
                    // return false;
                };
                
                zone.ondragover = function () {
                    // this.className = "dropzone dragover";
                    return false;
                };
                
                zone.ondragleave = function () {
                    // this.className = "dropzone dragleave";
                    //return false;
                };
                
                zone.ondrop = function (e) {
                    
                    e.preventDefault();
                    
                    putFilesToZone(e.dataTransfer.files);
                    
                    // this.className = "dropzone dragleave";
                    
                };
                
                
                if (callback !== undefined && typeof callback === "function") {
                    callback.call(el, fileBox, removedFileBox); // element;
                }
                
                
                function contentArea() {
                    
                    // Content of default area
                    let cnt = $(el).html();
                    $(el).empty();
                    
                    
                    let c = document.createElement("div");
                    c.innerHTML = cnt;
                    
                    el.appendChild(c);
                    
                    /*alert($(c).find(".upload-file").length);
                     if( !$(c).find(".upload-file").length ){
                     console.log(cHighlight);
                     c.appendChild( $(cHighlight)[0] );
                     }*/
                    
                    /// Set Action for Already Items
                    setActionsForAlreadyCreatedItems(c);
                    
                    
                    return c;
                    
                }
                
                function setActionsForAlreadyCreatedItems(content) {
                    
                    
                    $(content).find(".upload-file").each(function () {
                        
                        
                        let s = $(this).find(".show a");
                        let d = $(this).find(".del a");
                        let fileEl = $(this);
                        
                        s.on("click", function () {
                            showEl(fileEl);
                        });
                        
                        d.on("click", function () {
                            delEl(fileEl);
                        });
                        
                        
                    });
                    
                    
                    let showEl = function ($el) {
                        
                        let item = this;
                        let pwFile = $el.find("*").filter(function () {
                            return $(this).data("uploadedfile") == true;
                        })[0].cloneNode(true);
                        console.log("SRC EL", pwFile);
                        
                        pwFile.style.minHeight = "300px";
                        
                        
                        let ac = new $.tsoftx.alert(1004);
                        ac
                            .setTitle($(pwFile).data("filename"))
                            .setMessage(pwFile)
                            .show();
                        
                        let okAction = new $.tsoftx.alertAction();
                        okAction
                            .setTitle("Löschen")
                            .setStyle("danger")
                            .icon().add("icon-bin5")
                            .create()
                            .beforeClick(function () {
                                this.property("disabled", true);
                                cancelAction.property("disabled", true);
                                ac.loader("show");
                            })
                            .click(function () {
                                
                                $el.remove();
                                ac.loader("hide");
                                ac.dismiss();
                                
                                removedFileBox.push($(pwFile).data("filename"))
                                
                            })
                            .actionTo(ac.actions());
                        
                        
                        let cancelAction = new $.tsoftx.alertAction();
                        cancelAction
                            .setTitle("Abbrechen")
                            .create()
                            .click(function () {
                                ac.dismiss();
                            })
                            .actionBefore(okAction);
                        
                        
                        /*.okAction("text", lang.remove)
                            .okAction("style", "danger")
                            .okAction("click", true, function () {

                                $el.remove();
                                ac.loader("hide");
                                ac.dismiss();

                                removedFileBox.push($(pwFile).data("filename"))


                            })
                            .cancelAction("text", lang.close)
                            .show();*/
                        
                        
                    };
                    
                    let delEl = function ($el) {
                        
                        let pwFile = $el.find("*").filter(function () {
                            return $(this).data("uploadedfile") == true;
                        });
                        
                        let ac = new $.tsoftx.alert(1005);
                        ac
                            .setTitle("Artikel werde löschen")
                            .setMessage("Möchten Sie löschen?")
                            .show()
                        
                        let okAction = new $.tsoftx.alertAction();
                        okAction
                            .setTitle("Löschen")
                            .icon().add("icon-bin5")
                            .setStyle("danger")
                            .create()
                            .beforeClick(function () {
                                this.property("enabled", false);
                                cancelAction.property("enabled", false);
                                ac.loader("show");
                            })
                            .click(function () {
                                
                                $el.remove();
                                ac.loader("hide");
                                ac.dismiss();
                                // fileBox.splice(index, 1);
                                removedFileBox.push(pwFile.data("filename"));
                                
                            })
                            .actionTo(ac.actions());
                        
                        let cancelAction = new $.tsoftx.alertAction();
                        cancelAction
                            .setTitle("Abbrechen")
                            // .icon().add("icon-cross")
                            .click(function () {
                                ac.dismiss();
                            })
                            .create()
                            .actionBefore(okAction);
                        
                        
                        /*.okAction("text", lang.remove)
                            .okAction("style", "danger")
                            .okAction("click", true, function () {

                                $el.remove();
                                ac.loader("hide");
                                ac.dismiss();

                                // fileBox.splice(index, 1);
                                removedFileBox.push(pwFile.data("filename"));
                            })
                            .cancelAction("text", lang.cancel)
                            .show();*/
                        
                        
                    };
                    
                }
                
                let putFilesToZone = function (p_files) {
                    
                    
                    if (getFileCountInZone(zone) >= params.max_file) {
                        
                        ac = new $.tsoftx.alert(1006);
                        ac
                            .setTitle("Info")
                            .setMessage("Akzeptieren nur " + " (" + params.max_file + ") " + " Dokument")
                            .cancelAction("style", "default")
                            .cancelAction("text", "Sließen")
                            .show();
                        
                        return false;
                    }
                    
                    
                    for (let i = 0; i < p_files.length; i++) {
                        
                        let fileextention = p_files[i].name.split(".").pop(),
                            accept = params.accept;
                        
                        
                        if (accept.indexOf(fileextention) < 0) {
                            
                            console.log("File" + p_files[i].name + " not accessable!");
                            let ac = new $.tsoftx.alert(1007);
                            ac
                                .setTitle("Ungültig Dokument")
                                .setMessage("Ungültig Dokument" + " :" + p_files[i].name + "<br />" + " akzeptiert nur " + params.accept.join(", "))
                                .cancelAction("text", "Sließen")
                                .cancelAction("style", "danger")
                                .show();
                            
                        }
                        else {
                            createItemForZone(p_files[i]);
                        }
                        
                    }
                    
                    
                };
                
                let createItemForZone = function (file) {
                    
                    
                    let
                        reader = new FileReader(),
                        f, indicator, lbl, lblName;
                    
                    reader.fileName = file.name;
                    reader.readAsDataURL(file);
                    reader.onload = function (evnt) {
                        
                        
                        // Is Document Exist
                        if (isFileExistsInZone(zone, file.name)) {
                            
                            let ac = new $.tsoftx.alert(1008);
                            ac
                                .setTitle("Fehler Aufgetreten")
                                .setMessage("Dokument bereit existriert!")
                                .cancelAction("style", "default")
                                .cancelAction("text", "Schließen")
                                .show();
                            
                            return false;
                        }
                        
                        
                        // File extension
                        let ext = evnt.target.fileName;
                        ext = ext.split(".");
                        // console.log(ext[1]);
                        
                        switch (ext[1]) {
                            
                            case "pdf":
                                
                                f = document.createElement("embed"),
                                    indicator = document.createElement("img"),
                                    lbl = document.createElement("label"),
                                    lblName = document.createElement("label");
                                
                                
                                f.setAttribute("type", "application/pdf");
                                f.setAttribute("src", evnt.target.result);
                                
                                f.dataset.uploadedfile = true;
                                f.dataset.filename = evnt.target.fileName;
                                
                                f.style.width = "100%";
                                f.setAttribute("id", "thumb");
                                f.setAttribute("title", evnt.target.fileName);
                                
                                
                                lblName.innerHTML = evnt.target.fileName;
                                
                                
                                break;
                            
                            case "jpg":
                            case "jpeg":
                            case "png":
                            case "PNG":
                            case "img":
                            case "xls":
                            case "xlsx":
                                
                                f = document.createElement("img"),
                                    // fileWr = document.createElement("div"),
                                    indicator = document.createElement("img"),
                                    lbl = document.createElement("label"),
                                    lblName = document.createElement("label");
                                
                                // Check Is Image or another file
                                let imgs = ["jpg", "jpeg", "png", "tif", "gif", "raw"];
                                let is_image = imgs.indexOf(ext[1]);
                                if (is_image === -1) {
                                    f.setAttribute("src", base_url + "/images/filetypes/" + ext[1] + ".png");
                                } else {
                                    f.setAttribute("src", evnt.target.result);
                                }
                                
                                f.dataset.uploadedfile = true;
                                f.dataset.filename = evnt.target.fileName;
                                
                                f.style.width = "100%";
                                f.setAttribute("id", "thumb");
                                f.setAttribute("title", evnt.target.fileName);
                                
                                
                                lblName.innerHTML = evnt.target.fileName;
                                
                                break;
                            
                            default:
                                alert("Invalid file extension");
                                return false;
                            
                            
                        }
                        
                        
                        console.log("Upload files", f);
                        
                        let createdFileForZone = fileWrapper(f, evnt.target.fileName);
                        
                        // Push to Array
                        fileBox.push({
                            obj: createdFileForZone,
                            file: file,
                            type: ext[1]
                        });
                        
                        zone.appendChild(createdFileForZone);
                        
                        
                    };
                    
                    // files.push( file );
                    
                    
                    let fileWrapper = function (appendedFile, fname) {
                        
                        
                        let fw = document.createElement("div"), tb, show, space, del, ic;
                        fw.classList.add("col-lg-3", "upload-file");
                        fw.dataset.fname = fname;
                        fw.onclick = function () {
                            
                            /*console.log("This", $(this));

                             if(!uploadCompleted)
                             return false;


                             for(let i = 0; i < this.parentNode.childNodes.length; i++)
                             {
                             this.parentNode.childNodes[i].setAttribute("selected", false);
                             this.parentNode.childNodes[i].firstChild.style.borderColor = "#CCCCCC";
                             this.parentNode.childNodes[i].lastChild.style.display = "none";


                             if( i === this.parentNode.childNodes.length -1 )
                             {
                             this.setAttribute("selected",true);
                             this.firstChild.style.borderColor = "red";
                             this.lastChild.style.display = "block";


                             //selectedFile = this.firstChild;


                             }
                             }*/
                        };
                        
                        fw.appendChild(createFileName(fname));
                        fw.appendChild(appendedFile);
                        fw.appendChild(createToolbar(function () {
                            
                            
                            
                            
                            
                            // Function call after toolbar created
                            
                            // Created Toolbar this
                            createToolbarItem(fw, this, "del", ["icon-bin5", "pull-left", "ml-5"], function (index) {
                                
                                let item = this;
                                
                                
                                let ac = new $.tsoftx.alert(1009);
                                ac
                                    .setTitle("Artikel werde Löchen")
                                    .setMessage("Möchten Sie löschen")
                                    .okAction("text", "Löschen")
                                    .okAction("style", "danger")
                                    .okAction("click", true, function () {
                                        
                                        item.remove();
                                        ac.loader("hide");
                                        ac.dismiss();
                                        fileBox.splice(index, 1);
                                    })
                                    .cancelAction("text", "Abbrechen")
                                    .show();
                                
                                
                            });
                            
                            createToolbarItem(fw, this, "space", null, null);
                            
                            // Created Toolbar this
                            createToolbarItem(fw, this, "show", ["icon-search2", "pull-right", "mr-5"], function () {
                                
                                let item = this;
                                let pwFile = appendedFile.cloneNode(true);
                                pwFile.style.minHeight = "300px";
                                
                                
                                let ac = new $.tsoftx.alert(1010);
                                ac
                                    .setTitle(fname)
                                    .setMessage(pwFile)
                                    .okAction("text", "Löschen")
                                    .okAction("style", "danger")
                                    .okAction("click", true, function () {
                                        
                                        item.remove();
                                        ac.loader("hide");
                                        ac.dismiss();
                                        
                                    })
                                    .cancelAction("text", "Schließen")
                                    .show();
                            });
                            
                        }));
                        
                        
                        // $.tsoftx.uploadableFiles = fileBox;
                        // console.log("Uploadable Files", fileBox);
                        
                        return fw;
                        
                        
                    };
                    
                    let createFileName = function (fname) {
                        
                        let fn = document.createElement("div");
                        fn.classList.add("file-name", "bg-primary");
                        fn.innerText = fname;
                        
                        return fn;
                        
                    };
                    
                    let createToolbar = function (callback) {
                        
                        let tb;
                        tb = document.createElement("div");
                        tb.classList.add("toolbar");
                        
                        callback.call(tb);
                        
                        return tb;
                        
                        
                    };
                    
                    let createToolbarItem = function (file, toEl, cls, iconCls, actionHandler) {
                        
                        // Show Item with icon
                        let itm = document.createElement("div");
                        itm.classList.add("item", cls);
                        
                        
                        if (iconCls !== null && iconCls.length) {
                            let ic = document.createElement("a");
                            // ic.classList.add("icon", iconCls );
                            ic.classList.add("icon");
                            for (let cl in iconCls) {
                                ic.classList.add(iconCls[cl]);
                            }
                            itm.appendChild(ic);
                            
                            if ((actionHandler !== undefined || actionHandler !== null) && typeof actionHandler === "function") {
                                ic.onclick = function () {
                                    actionHandler.call(file, $(file).index());
                                }
                            }
                        }
                        
                        if (cls === "space") {
                            itm.appendChild(createProgressBar(0));
                        }
                        
                        
                        toEl.appendChild(itm);
                        
                        
                    };
                    
                    let createProgressBar = function (val) {
                        
                        
                        let prg = document.createElement("div");
                        prg.classList.add("progress");
                        
                        let prgString = document.createElement("div");
                        prgString.classList.add("lbl-success");
                        prgString.innerText = "Progress";
                        
                        
                        let prgS = document.createElement("div");
                        prgS.classList.add("progress-bar", "progress-bar-success");
                        prgS.style.width = val + "%";
                        prgS.setAttribute("role", "progressbar");
                        prgS.setAttribute("aria-valuemin", "0");
                        prgS.setAttribute("aria-valuemax", "100");
                        prgS.setAttribute("aria-valuenow", val);
                        // prgS.innerText = "Process in" + " " + val + "%";
                        
                        prg.appendChild(prgS);
                        prg.appendChild(prgString);
                        
                        return prg;
                        
                        
                    }
                    
                    
                };
                
                function getFileCountInZone(content) {
                    return $(content).find(".upload-file").length;
                }
                
                function isFileExistsInZone(content, fname) {
                    
                    return $(content).find(".upload-file").filter(function () {
                        return $(this).data("fname") === fname;
                    }).length;
                }
                
                function contentHighlight() {
                    
                    let w = $("<div>"), i1 = $("<p>"), i2 = $("<p>"), i3 = $("<p>"),
                        b = $("<button>");
                    w.addClass("col-lg-12").data("role", "file-upload-zone-inline").css("padding", 50);
                    i1.addClass("font-size-14").text("Bla").appendTo(w);
                    i2.append(b.addClass("btn", "btn-success").append("<i class='icon icon-folder-open'></i> Open File")).appendTo(w);
                    i3.addClass("col-lg-12").text("Bla 2").appendTo(w);
                    return w;
                    
                    
                };
                
                
            };
            
            // For Upload Manager
            this.uploadFiles = function (files, params, completion) {
                
                
                let progressIndicatorWrapper    = document.createElement("div");
                let progressIndicator           = document.createElement("div");
                
                progressIndicatorWrapper.classList.add("progress-indicator-wrapper");
                progressIndicator.classList.add("loader", "progress-indicator");
                
                progressIndicatorWrapper.appendChild( progressIndicator );
                
                
                $(files[0].obj).append(progressIndicatorWrapper);
                
                setTimeout(function () {
                    start();
                },300);
                
                function start() {
                    
                    
                    let defaults = {}, cls = this;
                    
                    params = $.extend(defaults, params);
                    
                    if (!files.length) {
                        return false;
                    }
                    
                    
                    let uploadedFileData = [],
                        uploadStatus = true,
                        formData = new FormData();
                    // xhr = new XMLHttpRequest(),
                    // dropzone = dialog.delegates.content.find("> div");
                    // dropzone = $uploadableZone;
                    
                    // let dir = dialog.delegates.content.find("select#uploaddir").val();
                    
                    
                    formData.append("output", "json");
                    formData.append("file[]", files[0].file);
                    formData.append("dir", params.dir);
                    
                    
                    /*formData.append("path", currentpath);
                                                formData.append("is_cloud", is_cloud);
                                                formData.append("cloud_id", cloud_id);*/
                    
                    
                    
                    $.ajax({
                        type: 'POST',
                        url: base_url + "/_Public/!/jQueryUpload",
                        data: formData,
                        xhr: function () {
                            
                            let myXhr = $.ajaxSettings.xhr();
                            
                            console.log("myXhr - S ", myXhr);
                            if (myXhr.upload) {
                                myXhr.upload.addEventListener('progress', progress, false);
                            }
                            
                            myXhr.upload.onprogress = function (e) {
                                console.log("Upload on Progress", e);
                            };
                            
                            return myXhr;
                            
                        },/*
                                        //Before 1.5.1 you had to do this:
                                        beforeSend: function (x) {
                                                if (x && x.overrideMimeType) {
                                                        x.overrideMimeType("multipart/form-data");
                                                }
                                        },
                                        // Now you should be able to do this:
                                        mimeType: 'multipart/form-data',    //Property added in 1.5.1
                                        xhrFields: {
                                                withCredentials: true
                                        },*/
                        contentType: false,
                        /*contentType: 'multipart/form-data',*/
                        processData: false,
                        cache: false,/*
                                        */
                        success: function (dt) {
                            
                            
                            if (typeof dt === "string") {
                                dt = JSON.parse(dt);
                            }
                            console.log("File Upload -> jQueryUpload dt ", dt);
                            
                            if (!dt.resulta) {
                                uploadStatus = dt.resulta;
                            }
                            
                            $(files[0].obj).find("[role=progressbar]")
                                .parent().find(".lbl-success").text(dt.message);
                            
                            switch (files[0].type) {
                                case "pdf":
                                    $(files[0].obj).find("embed").attr("src", dt.fileUrl);
                                    break;
                                
                                default:
                                    $(files[0].obj).find("img").attr("src", dt.fileUrl);
                                
                            }
                            
                            uploadedFileData.push(dt);
                            
                            progressIndicatorWrapper.remove();
                            
                            // Remove 1 value from TotalFiles
                            files.shift();
                            // fileBox.splice(0, 1);
                            
                            if (files.length) {
                                
                                setTimeout(function () {
                                    $.tsoftx.uploadFiles(files, params, completion);
                                }, 100 );
                                
                            } else {
                                
                                console.log("Upload Completed");
                                
                                if (completion !== undefined && typeof completion === "function") {
                                    completion(uploadStatus, uploadedFileData, dt/* Other Php Data */ );
                                }
                                
                            }
                            
                        },
                        
                        error: function (data) {
                            
                            
                            if( cls.storedAlertControllerWithActions.ac !== undefined ){
                                
                                cls.storedAlertControllerWithActions
                                    .ac.setMessage(data.statusText);
                                
                                
                            }
                            
                            if( cls.storedAlertControllerWithActions.actions.okAction !== undefined ){
                                cls.storedAlertControllerWithActions.actions.okAction.kill();
                            }
                            
                            if( cls.storedAlertControllerWithActions.actions.cancelAction !== undefined ){
                                cls.storedAlertControllerWithActions.actions.cancelAction.setTitle("Schließen")
                            }
                            
                            console.log("Hata Olustu", data);
                        },
                        fail: function () {
                            alert("Fail");
                        }
                    });
                    
                    
                    function progress(e) {
                        
                        console.log("ProgressObj", $(files[0].obj).find("[role=progressbar]"));
                        console.log("Progress", e);
                        
                        if (e.lengthComputable) {
                            let max = e.total;
                            let current = e.loaded;
                            
                            let Percentage = (current * 100) / max;
                            
                            $(files[0].obj).find("[role=progressbar]")
                                .attr("aria-valuenow", parseInt(Percentage))
                                .css("width", parseInt(Percentage) + "%");
                            
                            let $lbl = $(files[0].obj).parent();
                            $lbl.find(".lbl-success").text("Process " + parseInt(Percentage) + "%");
                            
                            if (Percentage >= 100) {
                                $lbl.find(".lbl-success").text("Analysing... ");
                                console.log("Part Upload Finish");
                            }
                        }
                    }
                    
                }
                
                
            };
            
            /**
             * SERIALIZE CONTENT
             * @param el
             * @param callback
             * @returns {{}}
             * @deprecated
             */
            this.serializeContent_deprecated = function (el, callback) {
                
                try {
                    
                    let nodeName = $(el)[0].nodeName;
                    let jQueryArray = [], _ = {};
                    
                    if ( nodeName === "FORM" || nodeName === "DIV" ) {
                    // if (nodeName === "FORM") {
                        // jQueryArray = $(el).serializeArray();
                    // } else if (nodeName === "DIV") {
                        
                        $(el).find('*').filter(function () {
                            // return $(this).attr("name") !== undefined && $(this).attr("name") !== "" && $(this).attr("value") !== "" && $(this).val() !== "";
                            return $(this).attr("name") !== undefined ;
                        }).each(function () {
                            
                            
                            _ = {
                                "name"  : $(this).attr("name"),
                                "value" : $(this).attr("type") === "checkbox" ? ($(this).is(":checked") ? 1 : 0 ) : ( $(this).val() !== "" ? $(this).val() : null )
                            };
                            
                            jQueryArray.push(_);
                            
                        });
                        
                        
                    } else {
                        alert("Object must be form or div element!");
                        return false;
                    }
                    
                    console.log("jQueryArray", jQueryArray);
                    
                    
                    let new_arr = {};
                    for ( let i = 0; i < jQueryArray.length; i++) {
                        // if (jQueryArray[i].value !== "") {
                            new_arr[jQueryArray[i].name] = jQueryArray[i].value;
                        // }
                    }
                    
                    if (undefined !== callback && "function" === typeof callback) {
                        callback.call(new_arr);
                    }
                    
                    
                    return new_arr;
                    
                } catch (e) {
                    
                    alert(e.message);
                    
                }
                
                
            };
    
            this.serializeContent = function (el, callback) {
        
        
                let nodeName = $(el)[0].nodeName;
                let jQueryArray = [], _ = {};
                let error = false;
                let postableElements    = ["INPUT", "TEXTAREA", "SELECT"];
                let checkElements    = ["checkbox", "radio"];
                
                let acceptNode = ["FORM", "DIV", "UL"];
        
        
                if ( acceptNode.indexOf( nodeName ) > -1 ) {
            
                    $(el).find('*').filter(function () {
                        return $(this).attr("name") !== undefined && postableElements.indexOf(this.nodeName) > -1;
                    }).each(function () {
                
                        // Element Name
                        let name = this.name;
                
                        if( checkElements.indexOf(this.type) > -1 )
                        {
                    
                            if( name.indexOf("[]") > -1 )
                            {
                        
                                name = name.replace(/[[]]/g, '');
                        
                                console.log("Checkbox Multiple", name);
                        
                                let isElExists = false;
                                for (let i=0;i< jQueryArray.length;i++){
                                    if( jQueryArray[i].name === name ){
                                
                                        console.log("Checkbox is ", jQueryArray[i].name + " -> " + name);
                                        isElExists = true;
                                        if( this.checked ){
                                            jQueryArray[i].value.push( this.value )
                                        }
                                    }
                                }
                        
                                if( !isElExists ){
                                    console.log("Element not found!");
                            
                                    // Add first one
                                    _ = {
                                        "name"  : name,
                                        "value" : this.checked ? [this.value] : [],
                                        "type"  : this.type
                                    }
                            
                                    jQueryArray.push(_);
                            
                                } else {
                                    console.log("Element exits!");
                                }
                        
                        
                            }
                    
                            else {
                        
                                // console.log("Checkbox Single", this.name);
                                if( this.hasAttribute("required") && !this.checked ){
                            
                                    console.log("Form will stop for ", this.name);
                                    this.nextElementSibling.style.borderColor = "red";
                                    this.nextElementSibling.onclick = function(El){
                                        El.target.style.borderColor = "";
                                    }
                            
                                    error = true;
                            
                                } else {
                            
                                    if( (this.type === "radio" && this.checked) || this.type !== "radio" )
                                    {
                                        _ = {
                                            "name"  : this.name,
                                            "value" : this.checked,
                                            "type"  : this.type
                                        };
                                    }
                            
                            
                                    jQueryArray.push(_);
                                    try{
                                        this.nextElementSibling.style.borderColor = "";
                                    } catch(e){
                                
                                    }
                                }
                        
                            }
                    
                    
                        }
                
                
                        else {
                    
                            if( this.hasAttribute("required") && this.value === "" ){
                        
                                console.log("Form will stop for ", this.name);
                                error = true;
                                this.style.borderColor = "red";
                        
                        
                            } else {
                        
                                _ = {
                                    "name"  : this.name,
                                    "value" : this.value !== "" ? this.value : null,
                                    "type"  : this.type
                                };
                        
                                jQueryArray.push(_);
                                this.style.borderColor = "";
                            }
                    
                    
                        }
                
                
                        this.onclick = function(El){
                            El.target.style.borderColor = "";
                        }
                
                    });
            
            
                } else {
                    alert("Object must be [" + acceptNode.join(", ") + "] element!");
                    return false;
                }
        
        
        
        
        
                console.log( "jQueryArray", jQueryArray );
        
        
        
        
                let new_arr = {};
                for ( let i = 0; i < jQueryArray.length; i++) {
            
                    let totalElInForm = 1;
                    if( typeof jQueryArray[i].value === "object" && jQueryArray[i].value !== null ){
                
                        // Total El in form
                
                        totalElInForm = document.getElementsByName( jQueryArray[i].name + "[]");
                        if( totalElInForm.length && !jQueryArray[i].value.length ){
                    
                            console.log("Error for Required checkbox", jQueryArray[i].name );
                            document.getElementsByName( jQueryArray[i].name + "[]").forEach(function (El) {
                                // console.log("Parent of Checkbox", El.nextElementSibling );
                                El.nextElementSibling.style.borderColor = "red";
                                El.onclick = function(){
                                    // this.nextElementSibling.style.borderColor = "";
                                    document.getElementsByName( jQueryArray[i].name + "[]").forEach(function (El) {
                                        El.nextElementSibling.style.borderColor = "";
                                    });
                                }
                            });
                            error = true;
                        } else {
                            document.getElementsByName( jQueryArray[i].name + "[]").forEach(function (El) {
                                El.nextElementSibling.style.borderColor = "";
                            });
                    
                        }
                
                    }
                    
                    // console.log("Type of Value -> ", jQueryArray[i].name + " " + typeof jQueryArray[i].value + " Total:"+ totalElInForm );
            
            
                    new_arr[jQueryArray[i].name] = jQueryArray[i].value;
                    // }
                }
        
                console.log( "new_arr", new_arr );
        
                if( error ){
            
                    if (undefined !== callback && "function" === typeof callback) {
                        callback.call([]);
                        return false;
                    }
            
            
                }
        
                if (undefined !== callback && "function" === typeof callback) {
                    callback.call(new_arr);
                }
        
        
                return new_arr;
        
        
            };
            
            
            this.copyc = function (el, params, callback) {
                
                
                $(el).click(function () {
                    
                    let obJs = params.src;
                    obJs = obJs.split(" ");
                    let srcEl;
                    
                    switch (obJs.length) {
                        case 0:
                        case 1:
                            if (obJs[0] === "") {
                                alert("No any selector!");
                            } else {
                                srcEl = $(obJs[0])[0];
                            }
                            
                            break;
                        
                        case 2:
                            srcEl = $(this).closest(obJs[0]).find(obJs[1])[0];
                            break;
                        
                        default:
                            alert("Many more selector!\n" + obJs.join(" "))
                        
                    }
                    
                    let text = "";
                    switch (srcEl.nodeName) {
                        case "INPUT":
                            switch (srcEl.getAttribute("type")) {
                                case "text":
                                case "date":
                                case "time":
                                case "password":
                                case "email":
                                case "number":
                                case "hidden":
                                case "month":
                                case "search":
                                case "tel":
                                case "url":
                                case "week":
                                case null:
                                    text = srcEl.value;
                                    break;
                                
                                default:
                                    break;
                            }
                            
                            break;
                        
                        
                        case "TEXTAREA":
                            text = srcEl.value;
                            break;
                        
                        default: // DIV SPAN P otherwise
                            text = srcEl.innerText;
                            break;
                        
                        
                    }
                    
                    let input = document.createElement("INPUT");
                    input.setAttribute("type", "text");
                    input.setAttribute("value", text);
                    input.style.visibility = "visible";
                    $(this)[0].parentNode.appendChild(input);
                    input.select();
                    let successfully = document.execCommand("Copy");
                    input.remove();
                    
                });
                
            };
            
            
            this.checkNetConnection = function (url, callback ) {
                
                
                let re = false;
                let r = Math.round(Math.random() * 10000);
                jQuery.ajaxSetup({async: false});
                // $.get(url, {subins: r}, function (d) {
                $.get(url, null, function (d) {
                        re = true;
                    }
                ).error(function (e) {
                    console.log(e);
                    re = false;
                });
    
                
                
    
                /*let check_connectivity = {
                    is_internet_connected: function() {
                        return $.get({
                            url: url,
                            dataType: 'text',
                            cache: false
                        });
                    }
                };
    
                    check_connectivity.is_internet_connected().done(function() {
                        re = true;
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        //Something went wrong. Test textStatus/errorThrown to find out what. You may be offline.
                        re = false;
                    });*/
                
                if (undefined !== callback && "function" === typeof callback) {
                    callback.call(re);
                }
                return re;
            };
            
            this.imagePreview = function (el, targetEl, succCallback, errCallback) {
                
                if (el === undefined)
                    return false;
                
                if (el.getAttribute("type") !== "file") {
                    alert("Object must be File DOM Element");
                    
                    return false;
                }
                
                let defaultVal = el.files[0];
                
                el.onclick = function (e) {
                    console.log("File Element", this.files[0]);
                    defaultVal = this.files[0];
                };
                
                el.onchange = function (e) {
                    
                    let file = this.files[0].name;
                    let ext = file.split(".")[1];
                    let accept = el.getAttribute("accept");
                    
                    accept = accept.replace(/\s|\.+/g, '');
                    accept = accept.split(",");
                    
                    console.log(e);
                    
                    if (accept.indexOf(ext) < 0) {
                        
                        
                        alert("File Format not invalid");
                        
                        el.value = null;
                        
                        if (targetEl[0].nodeName === "IMG") {
                            targetEl[0].setAttribute("src", targetEl[0].getAttribute("data-avatar"));
                        } else {
                            targetEl[0].style.backgroundImage = "url(" + targetEl[0].getAttribute("data-avatar") + ")";
                        }
                        if (errCallback !== undefined && typeof errCallback === "function") {
                            errCallback();
                        }
                        
                        return false;
                        
                    }
                    
                    
                    if (this.files && this.files[0]) {
                        
                        let reader = new FileReader();
                        
                        reader.onload = function (e) {
                            
                            if (targetEl !== undefined) {
                                
                                if (targetEl[0].nodeName === "IMG") {
                                    targetEl[0].setAttribute("src", e.target.result);
                                } else {
                                    targetEl[0].style.backgroundImage = "url(" + e.target.result + ")";
                                }
                                
                                if (succCallback !== undefined && typeof succCallback === "function") {
                                    let r = e.target.result;
                                    succCallback.call(r.toString());
                                }
                                
                                
                            } else {
                                alert("Target element not ready");
                            }
                            
                            
                        };
                        
                        reader.readAsDataURL(el.files[0]);
                        
                        
                    }
                    
                    
                }
                
                
            }
            
            
            this.fileSelector = function (el, params, successCallback, errCallback) {
                
                
                params = $.extend( {
                    open    :"click",       // Open Dialog with "click", Or "quick"
                    target  :"self"         // after Load Set src for image to object
                }, params );
                
                
                
                if (el === undefined)
                    return false;
                
                // Create A file Element
                let fileEl = document.createElement("input");
                fileEl.setAttribute("type", "file");
                fileEl.style.display = "none";
                
                let dataStoreObjectCreated = false;
                
                let inputDataStore = undefined;
                
                console.log("File Selector Element", el);
                
                if (el.getAttribute("accept") !== undefined) {
                    fileEl.setAttribute("accept", el.getAttribute("accept"));
                }
                
                
                
                
                
                // Choose Parent
                let p = el.parentNode;
                
                // Append the DOM element to the parent
                p.appendChild(fileEl);
                
                if (
                    el.dataset["store-obj"] !== undefined
                    && ( el.dataset["store-fixed"] !== undefined
                        && el.dataset["store-fixed"] === "true" ) )
                {
                    inputDataStore = document.createElement("input");
                    inputDataStore.setAttribute("type", "hidden");
                    inputDataStore.setAttribute("name", el.dataset["store-obj"]);
                    inputDataStore.value = "";
                    
                    if( el.hasAttribute("required") ){
                        inputDataStore.setAttribute("required", 'required');
                    }
                    
                    if( el.dataset["missing-info"] !== undefined  ){
                        inputDataStore.setAttribute("data-missing-info",el.dataset["missing-info"]);
                    }
                    
                    
                    p.appendChild(inputDataStore);
                    
                    dataStoreObjectCreated = true;
                }
                
                
                // Open Dialog with ?
                
                switch (params.open){
                    
                    case "click":
                        el.onclick = function () { fileEl.click(); };
                        break;
                    
                    case "quick":
                        fileEl.click();
                        break;
                    
                }
                
                
                
                let defaultVal = fileEl.files[0];
                
                fileEl.onclick = function (e) {
                    defaultVal = this.files[0];
                };
                
                
                fileEl.onchange = function (e) {
                    
                    
                    console.log("Selected Files", this.files);
                    
                    
                    let file = this.files[0].name;
                    let ext = file.split(".")[1];
                    let accept = el.getAttribute("accept");
                    
                    accept = accept.replace(/\s|\.+/g, '');
                    accept = accept.split(",");
                    
                    console.log("Params for File Selector", params);
                    
                    if (accept.indexOf(ext) < 0) {
                        
                        
                        alert("File Format invalid");
                        
                        el.value = null;
                        
                        if (el.nodeName === "IMG") {
                            el.setAttribute("src", el.getAttribute("data-avatar"));
                        } else {
                            el.style.backgroundImage = "url(" + el.getAttribute("data-avatar") + ")";
                        }
                        if (errCallback !== undefined && typeof errCallback === "function") {
                            errCallback();
                        }
                        
                        return false;
                        
                    }
                    
                    
                    if (this.files && this.files[0]) {
                        
                        let reader = new FileReader();
                        
                        reader.onload = function (e) {
                            
                            
                            console.log("Loaded File", e);
                            
                            
                            if( params.target === "self" ){
                                
                                if (el.nodeName === "IMG") {
                                    el.setAttribute("src", e.target.result);
                                } else {
                                    el.style.backgroundImage = "url(" + e.target.result + ")";
                                }
                                
                            }
                            
                            
                            if (successCallback !== undefined && typeof successCallback  === "function") {
                                let r = e.target.result;
                                successCallback .call(r.toString(), e.total );
                                
                                
                                
                                <!-- Bu Attr Logo icin hidden input olusturuyor ve secilim image datasini onun valusune yaziyor -->
                                // Store Obj
                                if (el.dataset["store-obj"] !== undefined )
                                {
                                    if(!dataStoreObjectCreated){
                                        
                                        inputDataStore = document.createElement("input");
                                        inputDataStore.setAttribute("type", "hidden");
                                        inputDataStore.setAttribute("name", el.dataset["store-obj"]);
                                        
                                        if( el.hasAttribute("required") ){
                                            inputDataStore.setAttribute("required", 'required');
                                        }
                                        
                                        
                                        if( el.dataset["missing-info"] !== undefined  ){
                                            inputDataStore.setAttribute("data-missing-info",el.dataset["missing-info"]);
                                        }
                                        
                                        p.appendChild(inputDataStore);
                                        
                                    }
                                    
                                    inputDataStore.value = r.toString();
                                }
                                
                                
                                
                            }
                            
                            
                        };
                        
                        reader.readAsDataURL(fileEl.files[0]);
                        
                    }
                    
                    
                    if( params.open === "quick" ){
                        fileEl.remove();
                    }
                }
            }
            
            
            this.fileSelectorNew = function (el, params, callback ) {
                
                
                params = $.extend( {
                    open    :"click",       // Open Dialog with "click", Or "quick"
                    target  :"self",        // after Load Set src for image to object
                    start   :function(){},  // Before the change operation
                    end     :function(){}   // After the change operation
                }, params );
                
                
                
                if (el === undefined)
                    return false;
                
                // Create A file Element
                let fileEl = document.createElement("input");
                fileEl.setAttribute("type", "file");
                fileEl.setAttribute("multiple", "multiple");
                // fileEl.setAttribute("name", "file_upload_el");
                fileEl.style.display = "none";
                
                let dataStoreObjectCreated = false;
                
                let inputDataStore = undefined;
                
                console.log("File Selector Element", el);
                
                if (el.getAttribute("accept") !== undefined) {
                    fileEl.setAttribute("accept", el.getAttribute("accept"));
                }
                
                
                
                
                
                // Choose Parent
                let p = el.parentNode;
                
                // Append the DOM element to the parent
                p.appendChild(fileEl);
                
                if (
                    el.dataset["store-obj"] !== undefined
                    && ( el.dataset["store-fixed"] !== undefined
                        && el.dataset["store-fixed"] === "true" ) )
                {
                    inputDataStore = document.createElement("input");
                    inputDataStore.setAttribute("type", "hidden");
                    inputDataStore.setAttribute("name", el.dataset["store-obj"]);
                    inputDataStore.value = "";
                    
                    if( el.hasAttribute("required") ){
                        inputDataStore.setAttribute("required", 'required');
                    }
                    
                    if( el.dataset["missing-info"] !== undefined  ){
                        inputDataStore.setAttribute("data-missing-info",el.dataset["missing-info"]);
                    }
                    
                    
                    p.appendChild(inputDataStore);
                    
                    dataStoreObjectCreated = true;
                }
                
                
                // Open Dialog with ?
                
                switch (params.open){
                    
                    case "click":
                        el.onclick = function () { fileEl.click(); };
                        break;
                    
                    case "quick":
                        fileEl.click();
                        break;
                    
                }
                
                
                
                let defaultVal = fileEl.files;
                
                fileEl.onclick = function (e) {
                    defaultVal = this.files;
                };
                
                
                fileEl.onchange = function (e) {
                    
                    params.start();
                    
                    let fileEl = this;
                    
                    setTimeout(function () {
                        
                        let finalResult = false, finalMessage;
                        
                        for(let i = 0; i < fileEl.files.length; i++){
                            
                            let file = fileEl.files[i].name, message = "", err = false;
                            
                            if( undefined !== file ){
                                
                                let
                                    ext     = file.split(".")[1],
                                    accept  = el.getAttribute("accept");
                                
                                accept = accept.replace(/\s|\.+/g, '');
                                accept = accept.split(",");
                                
                                
                                if (accept.indexOf(ext) < 0) {
                                    message = "Invalid file [" + file[i].name + "]" + "\n";
                                    err             = true;
                                    finalResult     = true;
                                    finalMessage    = "Invalid selected file(s)";
                                }
                                
                                if( undefined !== callback && typeof callback === "function" ){
                                    
                                    callback( !err, fileEl.files[i], message );
                                    
                                }
                                
                            }
                            
                        }
                        
                        
                        params.end();
                        
                    }, 500);
                    
                    
                    
                    
                    
                    /*if( params.open === "quick" ){
                                                fileEl.remove();
                                        }*/
                }
            }
            
            this.simpleUpload = function( params, callback ){
                
                
                let formData = new FormData();
                
                formData.append( "output", "json");
                formData.append( "file", params.file );
                formData.append( "dir", params.to );
                
                console.log("formData A:", params.file);
                
                
                $.ajax({
                    type: 'POST',
                    url: base_url + "/_Public/!/jQueryUpload",
                    data: formData,
                    /*xhr: function () {

                                        },*/
                    contentType: false,
                    // contentType: 'multipart/form-data',
                    processData: false,
                    cache: false,
                    success: function (dt) {
                        
                        
                        console.log("TEMPORARY AJAX UPLOAD RESULT,", dt);
                        
                        try {
                            if (typeof dt === "string" && JSON.parse(dt)) {
                                dt = JSON.parse(dt);
                            }
                            callback.call(dt);
                            
                        } catch (e) {
                            
                            
                            let ac = new $.tsoftx.alert(1000);
                            ac
                                .setTitle("Function Error")
                                .setType("danger")
                                .setMessage("Fehler aufgetreten")
                                .cancelAction("text", "Schließen")
                                .show();
                            
                            console.log("FUNCTION ERROR:", e);
                            
                            sendMail();
                            // cls.setErrorCallback(dt, dt, dt);
                            
                            
                        }
    
                        function sendMail() {
                            
                            window.location.href = "mailto:s.topaloglu@adler-gruppe.com"
                                + "?cc=myCCaddress@example.com"
                                + "&subject=11Meter Error" + escape("This is my subject")
                                + "&body=" + dt + "<br />" + e.message
                            ;
                        }
                        
                    },
                    
                    error: function (x,h,d) {
                        
                        console.log("Error ", x, h, d);
                    },
                    fail: function () {
                        alert("Fail");
                    }
                });
                
                
                
            }
            
            this.developerReport = function(message){
    
                this.init = function(message){
    
                    // document.write(message);
                    try{
        
                        let loader = new $.tsoftx.loader();
                        let httpRequest = new $.tsoftx.ajax();
                        httpRequest
                            .setCnt("_Public")
                            .setMtd("reportErrorToDeveloper")
                            // .setActivityIndicator(loader)
                            .setData({
                                message:message
                            })
                            .setProcessWithSession(false)
                            .execute(function (data) {
                
                
                                // let ac = L.deviceAlert();
                                // ac.setMessage(data.message);
                
                
                            });
        
                    } catch(e){
        
                        alert(e.message);
                    }
                    
                }
                
                
                
                
                this.init(message);
                
                
            }
            
            
            
        }($),
        
        sa_session: new function () {
            
            
            this.check = function (l, callback, errorCallback ) {
                
                let url = base_url + "/_Public/!/sessionUser";
                
               
                
                $.tsoftx.checkNetConnection(url, function () {
                
                
                    if (this) {
                        
                        try {
                            let data = {};
                            data.output = "json";
                            $.ajax({
                                method: "POST",
                                url: url,
                                data: data,
                                beforeSend: function () {
                                
                                },
                                complete: function () {
                                
                                },
                                success: function (dt) {
                                    
                                    
                                    if (typeof dt === "string") {
                                        dt = JSON.parse(dt);
                                    }
                                    
                                    console.log(dt.data[0] > 0);
                                    
                                    /*if(dt.data[0].error && dt.data[0].error === "TYPE_CRITICAL" ){
                                        
                                        let ac;
                                        
                                        if( DEVICE !== null ){
                                            
                                            ac = new $.tsoftx.alert();
                                            ac.setMessage(dt.data[0].message)
                                            ac.setTitle("Error");
                                            ac.show();
                                            
                                        } else {
    
                                            ac = new $.tsoftx.deviceAlert();
                                            ac.setMessage(dt.data[0].message)
                                            ac.setTitle("Error");
                                            ac.show();
                                        
                                        
                                        }
                                        
                                        
                                    }*/
                                    
                                    
                                    callback.call(dt.data[0] > 0);
                                },
                                error: function (request, status, error) {
                                    console.log(status);
                                },
                                fail: function (jqXHR, textStatus, errorThrown) {
                                    console.log(jqXHR);
                                }
                            });
                            
                        } catch (e) {
                            console.log(e);
                        }
                        
                        
                    } else {
                        
                        $.tsoftx.loaderObj.dismiss();
                        let ac = new $.tsoftx.alert(1011), closeAction = new $.tsoftx.alertAction();
                        ac
                            .setTitle("Connection")
                            .setType("danger", "white")
                            .setMessage("No Internet Connection")
                            .cancelAction("text", "Schließen")
                            .show();
                        
                        /*closeAction
                            .setTitle("Schließen")
                            .create()
                            .beforeClick(function () {
                                ac.loader("show");
                            })
                            .click(function () {
                                ac.dismiss();
                            })
                            .actionTo( ac.actions() );*/
                        
                        
                        errorCallback();
                        
                    }
                    
                    
                } );
                
                
            },
                
                this.processWithSession = function () {
                
                
                }
            
            
        }($),
        
        autoload: new function () {
            
            this.convert = function () {
                
                // Replace data attr with data
                
                
                return this;
            };
            
            this.datepicker = function () {
                
                
                try{
    
                    $("input[data-type=date]")
                        .datepicker({
                            format: "dd.mm.yyyy",
                            language: 'en',
                            autoclose: 1,
                            weekStart: 1,
                            // startView: 1,
                            todayBtn: 1,
                            todayHighlight: 1,
                            forceParse: 0,
                            // minView: 1,
                            pickerPosition: "bottom-left"
                        })
                        .mask("99.99.9999");
                    
                     
                } catch (e){
                    
                    console.log("X2.ui.js ->Autoload -> datepicker", e );
                    
                }
                
                return this;
                
            };
            
            this.popover = function () {
                
                $('[data-toggle="popover"]:not(".custom-content")').popover();
                
                return this;
            };
            
            this.tooltip = function () {
                
                
                $('[data-toggle="tooltip"]').tooltip();
                
                $('*').filter(function () {
                    return $(this).data("toggle") === "tooltip";
                }).tooltip();
                
                return this;
            };
            
            this.notifications = function (callback, delay) {
                
                process();
                
                function process() {
    
                    /*let db = new $.tsoftx.ajax();
                    db
                        .setCnt("User")
                        .setNsp("!")
                        .setMtd("fetch")
                        .setData({
                            cid: $("input[type=hidden]#cid").val()
                        })
                        .execute(function () {
            
                            let data = this;
                            console.log(data);
            
                            // Android.loginWithData(data);
            
            
            
                        })
                        .s_expired(function () {
            
            
                        });*/
                    
                }
                
                function process_() {
                    
                    let ajx = new $.tsoftx.ajax();
                    ajx
                        .setCnt("Notifications")
                        .setMtd("get")
                        .setNsp("!")
                        .error(function () {
                        
                        })
                        .setProcessWithSession(true)
                        .execute(function () {
                            // alert(JSON.stringify(this));
                            callback.call(this);
                            setTimeout(function () {
                                process();
                            }, delay * 1000);
                        });
                }
            };
            
            this.changeLanguageEvent = function () {
                
                return this;
            };
            
            this.resetForm = function () {
                
                $("a").filter(function () {
                    return $(this).data("type") === "reset";
                }).removeAttr("data-type").data("type", "reset")
                    .on("click", function () {
                        
                        $("form *").each(function () {
                            
                            switch ($(this)[0].nodeName) {
                                case "INPUT":
                                    
                                    if ($(this).val() !== "") $(this).val("");
                                    if ($(this).data("type") !== "date") $(this).focus();
                                    if ($(this).attr("type") !== "radio" || $(this).attr("type") !== "checkbox") $(this).prop("checked", false);
                                    
                                    break;
                                
                                case "SELECT":
                                    $(this).val($(this).find("option:first-child"));
                                    break;
                                
                                case "TEXTAREA":
                                    $(this).val("");
                                    break;
                            }
                            
                        });
                        
                    });
                
                return this;
                
            };
            
            this.panelEqualHeights = function () {
                
                $(".equal-height-panels .panel").matchHeight();
                
                return this;
            };
            
            this.showAbleInput = function () {
                
                $(".showable-input").showableInput({
                    on: "icon-eye",
                    off: "icon-eye-blocked"
                }, function () {
                
                });
                
                return this;
                
                
            };
            
            this.init = function () {
                
                // this.convert().datepicker().changeLanguageEvent().tooltip().popover().resetForm().panelEqualHeights().showAbleInput();
                this.convert().changeLanguageEvent().tooltip().popover().resetForm().panelEqualHeights().showAbleInput();
            };
            
            
        }($)
        
        
    });
    
    
})(jQuery);


(function (a) {
    a.fn.matchHeight = function (b) {
        if ("remove" === b) {
            let f = this;
            this.css("height", "");
            a.each(a.fn.matchHeight._groups, function (g, h) {
                h.elements = h.elements.not(f)
            });
            return this
        }
        if (1 >= this.length) {
            return this
        }
        b = "undefined" !== typeof b ? b : !0;
        a.fn.matchHeight._groups.push({elements: this, byRow: b});
        a.fn.matchHeight._apply(this, b);
        return this
    };
    a.fn.matchHeight._apply = function (b, g) {
        let h = a(b), f = [h];
        g && (h.css({
            display: "block",
            "padding-top": "0",
            "padding-bottom": "0",
            "border-top": "0",
            "border-bottom": "0",
            height: "100px"
        }), f = c(h), h.css({
            display: "",
            "padding-top": "",
            "padding-bottom": "",
            "border-top": "",
            "border-bottom": "",
            height: ""
        }));
        a.each(f, function (i, l) {
            let k = a(l), j = 0;
            k.each(function () {
                let m = a(this);
                m.css({display: "block", height: ""});
                m.outerHeight(!1) > j && (j = m.outerHeight(!1));
                m.css({display: ""})
            });
            k.each(function () {
                let m = a(this), n = 0;
                "border-box" !== m.css("box-sizing") && (n += e(m.css("border-top-width")) + e(m.css("border-bottom-width")), n += e(m.css("padding-top")) + e(m.css("padding-bottom")));
                m.css("height", j - n)
            })
        });
        return this
    };
    a.fn.matchHeight._applyDataApi = function () {
        let b = {};
        a("[data-match-height], [data-mh]").each(function () {
            let f = a(this), g = f.attr("data-match-height");
            b[g] = g in b ? b[g].add(f) : f
        });
        a.each(b, function () {
            this.matchHeight(!0)
        })
    };
    a.fn.matchHeight._groups = [];
    let d = -1;
    a.fn.matchHeight._update = function (b) {
        if (b && "resize" === b.type) {
            b = a(window).width();
            if (b === d) {
                return
            }
            d = b
        }
        a.each(a.fn.matchHeight._groups, function () {
            a.fn.matchHeight._apply(this.elements, this.byRow)
        })
    };
    a(a.fn.matchHeight._applyDataApi);
    a(window).bind("load resize orientationchange", a.fn.matchHeight._update);
    let c = function (b) {
        let f = null, g = [];
        a(b).each(function () {
            let i = a(this), k = i.offset().top - e(i.css("margin-top")),
                j = 0 < g.length ? g[g.length - 1] : null;
            null === j ? g.push(i) : 1 >= Math.floor(Math.abs(f - k)) ? g[g.length - 1] = j.add(i) : g.push(i);
            f = k
        });
        return g
    }, e = function (b) {
        return parseFloat(b) || 0
    }
})(jQuery);

(function (s) {
    
    s.fn.formControl = function (callback, errCallback) {
        $.tsoftx.formControl(this, callback, errCallback)
    };
    
    s.fn.inputCheck = function (callback) {
        $.tsoftx.inputCheck(this[0], callback)
    };
    
    s.fn.showableInput = function (params, callback) {
        $.tsoftx.showableInput(this, params, callback);
        return this;
    };
    
    s.fn.uploadManager = function (params, callback) {
        $.tsoftx.uploadManager(this[0], params, callback);
        return this;
    };
    
    
    s.fn.serializeContent = function (callback) {
        return $.tsoftx.serializeContent(this[0], callback);
    };
    s.fn.copyc = function (params, callback) {
        return $.tsoftx.copyc(this[0], params, callback);
    };
    
    s.fn.imagePreview = function (targetEl, succCallback, errCallback) {
        $.tsoftx.imagePreview(this[0], targetEl, succCallback, errCallback)
    }
    
    s.fn.fileSelector = function ( params, successCallback, errCallback) {
        $.tsoftx.fileSelector( this[0], params, successCallback, errCallback)
    }
    
    s.fn.formInput = function (event, callback) {
        $.tsoftx.formInput(this[0], event, callback);
        return this;
    }
    
    s.fn.inputFormat = function (event, callback) {
        $.tsoftx.inputFormat(this[0], event, callback);
        return this;
    }
    
    s.fn.processResultaWithView = function ( message, color ) {
        $.tsoftx.processResultaWithView( this[0], message, color );
    }
    
    
})(jQuery);



