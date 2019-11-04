/*
 * Author          :suleymantopaloglu
 * File            :X2.Tools.ui.js
 * Product Name    :PhpStorm
 * Time            :15:45
 * Created at      :12.02.2019 15:45
 * Description     :X2 Smart Phone Tools
 */

let lastOpenedActivityIndicator = null;

let X2Tools = function () {
    
    let X2 = this;

    this.setLastOpenedActivityIndicator = function(activityIndicator){
        lastOpenedActivityIndicator = activityIndicator;
    }
    
    this.getLastOpenedActivityIndicator = function(){
        return lastOpenedActivityIndicator;
    }
    
    /*
    * Process From Device Requested
    * */
    this.fromDevice = function () {
        return typeof DEVICE !== undefined && typeof DEVICE !== null && DEVICE !== '';
    }
    
    this.TableView = function (Element, pars) {
        
        let row_onclick, row_ontouchend, row_ontouchstart, row_ontouchmove;
        
        
        // alert("Loaded");
        try {
            // alert(Element.id + " " + JSON.stringify(pars));
        } catch (e) {
        
        }
        
        this.parameters = Object.assign({
            row: function (row, rows, ui) {
            },
            rows: function (rows, ui) {
            },
            search: function (TableViewEl, bodyRows, string, _class) {
            },
            sort: {
                render: false,
                dataGroupKey: "group", // Dataset for Group View
                dataSortKey: "sort",   // Dataset for Sort View
                badge: false,
                dataBadgeKey: "badge"
            },
            
            /*addRow:function( TableViewEl ){}*/
            // searchBar: false @deprecated instead of data-with attribute
        }, pars);
        
        this.selectedRow = null;
        
        this.setSelectedRow = function (row) {
            this.selectedRow = row;
        }
        
        this.getSelectedRow = function () {
            return this.selectedRow;
        }
        
        
        this.callbackRowTouch = function () {
        };
        
        this.callbackRowBeforeTouch = function () {
        };
        
        this.callbackRowClick = function () {
        };
        
        this.allChildren = [];
        
        this._children = function () {
        };
        
        this.searchEl = null;
        // this.childrenCallback = function(){};
        
        let _class = this;
        // let TableView = this;
        
        let TableView = Element;
        
        this.TableRows = [];
        
        this.selectedRow = null;
        
        this.scrolling = false;
        
        /**
         * Custom Event for Table Scroll
         * @param callback
         * @param timeout
         */
        $.fn.scrollEnd = function (callback, timeout) {
            $(this).scroll(function () {
                
                _class.isSrolling = true;
                
                var $this = $(this);
                if ($this.data('scrollTimeout')) {
                    clearTimeout($this.data('scrollTimeout'));
                }
                $this.data('scrollTimeout', setTimeout(callback, timeout));
            });
        };
        
        document.body.onscroll = function () {
            _class.isSrolling = true;
        }
        
        
        this.init = function (callback) {
            
            
            let moveEvent = false;
            
            let TableViewRow;
            let s = [];
            
            let bodyRows = [];
            let scrolling;
            
            // Find a Table View
            if ("undefined" === typeof TableView) {
                // Return a First Found Element
                TableView = document.querySelector("ul.x2-list");
                
                
            } else {
                
                try {
                    if (!TableView.classList.contains("x2-list")) {
                        TableView = undefined;
                        alert("No tableView Correctly found");
                        return false;
                    }
                } catch (e) {
                    TableView = undefined;
                }
                
            }
            
            console.log("TableView Ola", TableView);
            
            if (undefined !== TableView) {
                
                // if (_class.parameters.searchBar  ) {
                if (
                    TableView.dataset !== undefined &&
                    undefined !== TableView.dataset.with &&
                    TableView.dataset.with === "searchbar" &&
                    TableView.querySelector("li.x2-table-search") === null) {
                    
                    let searchBarWrapper = document.createElement("li");
                    searchBarWrapper.classList.add('section', 'x2-table-search');
                    
                    let searchBar = document.createElement("div");
                    searchBar.classList.add('d-table-cell');
                    
                    let searchBox = document.createElement("div");
                    searchBox.classList.add("w100");
                    
                    
                    let searchButton = document.createElement("button");
                    searchButton.classList.add("d-table-cell");
                    searchButton.innerText = "Search";
                    
                    searchButton.ontouchend = function () {
                        _class.parameters.search.call(searchEl.value, TableView, _class.TableRows, _class);
                    };
                    
                    let searchEl = document.createElement("input");
                    searchEl.setAttribute("placeholder", "Suche");
                    searchEl.classList.add("w100");
                    searchEl.type = "search";
                    searchEl.type = "text";
                    
                    
                    searchBox.append(searchEl);
                    searchBar.append(searchBox);
                    
                    searchBarWrapper.append(searchBar);
                    searchBarWrapper.append(searchButton);
                    
                    
                    TableView.prepend(searchBarWrapper);
                    
                    _class.searchEl = searchEl;
                    
                }
                
                
                // alert(4);
                // Check And Add Rows
                /*try{
                    alert(_class.parameters.addRow);
                    
                    _class.parameters.addRow( TableView );
                    
                    
                } catch (e) {
                
                }*/
                
                
                _class.load(function (rows) {
                    
                    _class.TableRows = rows;
                    
                    /**
                     * Cretae Function callback
                     */
                    if (undefined !== callback && "function" === typeof callback) {
                        
                        callback.call(TableView, rows)
                        
                    }
                    
                    
                    if (_class.parameters.sort.render) {
                        _class.sort(rows);
                    }
                    
                });
                
            }
            
            /*let event = document.createEvent("Event");
            event.initEvent("scrollEnd",true, true);
            
            
            window.addEventListener("scrollEnd", function(e){
        
                document.body.onscroll = function(El){
                    console.log("This--->", El);
            
                    if( El.target.body.dataset.scrollTimeout ){
                        clearTimeout(El.target.body.dataset.scrollTimeout);
                    }
                    console.log("Event", e);
                    // El.target.body.dataset.scrollTimeout = setTimeout(callback, timeout)
            
                }
        
        
            }, false );
            window.dispatchEvent(event);*/
            /*$(window).scrollEnd(function () {
                alert(1);
            }, 300);*/
            
            
            /*document.body.scrollEnd = function(){
                alert("Scroll End");
                
            };*/
            
            
            return this;
            
        };
        
        
        this.load = function (callback) {
            
            // Get All Rows
            _class.rows(function (rows) {
                
                try {
                    _class.parameters.rows(rows, _class);
                } catch (e) {
                    alert(e.message);
                }
                
                
                /*TableView.querySelectorAll("li.cell").forEach(function (El) {
                    El.remove();
                })*/
                
                for (let i = 0; i < rows.length; i++) {
                    
                    let row = rows[i];
                    
                    if (row.classList.contains("cell")) {
                        
                        
                        if (TableView.dataset !== undefined && (undefined !== TableView.dataset.removeable || null !== TableView.dataset.removeable)) {
                        
                        
                        }
                        
                        _class.parameters.row(row, rows, _class);
                        
                        // console.log("TableView Row", row);
                        
                        _class.prepareTableRow(row);
                    }
                    
                }
                
                
                if (undefined !== callback && typeof callback === "function") {
                    callback(rows);
                }
                
            });
            
            
        };
        
        /*
        * Collect All Table Row In Array
        * */
        this.rows = function (callback) {
            
            let rows = [];
            
            for (let i = 0; i < TableView.children.length; i++) {
                
                let row = TableView.children[i];
                
                if (!row.classList.contains("x2-table-search")) {
                    rows.push(row);
                }
            }
            
            if (undefined !== callback && typeof callback === "function") {
                callback(rows);
            }
            
        };
        
        
        this.addRow = function (row /*Indexed Array*/, callback) {
            
            // console.log(this.html);
            let _ = this;
            // Remove All Rows
            let rows = TableView.children.length;
            for (let i = 0; i < rows; i++) {
                
                console.log("Row", i);
                let row = TableView.children[TableView.children.length - 1];
                if (row.classList.contains("cell") && !row.classList.contains("x2-table-search")) {
                    // row.remove();
                }
                
            }
            
            setTimeout(function () {
                try {
                    let rows = document.createRange().createContextualFragment(row);
                    TableView.append(rows);
                    
                    // _class.TableRows = rows;
                    
                    
                    if (undefined !== callback && typeof HttpRequestcallback === "function") {
                        callback(_class);
                    }
                    
                } catch (e) {
                
                }
            }, 10)
            
            
        };
        
        
        this.removeRow = function( rows, callback ){
            
            
            if( !rows.length ){
                
                
                TableView.querySelectorAll("li.cell").forEach(function (El) {
                    El.remove();
                })
                
            } else {
                
                for(let row in rows){
                    rows[row].remove();
                }
                
                
            }
            
            if( undefined !== callback && "function" === typeof callback ){
                callback();
            }
            
            
            
        }
        
        this.prepareTableRow = function (row) {
            
            
            let rowElements = row.children,
                label,
                input,
                select,
                rowImage,
                // moveEvent = false,
                targetEl = null,
                removeable = row.classList.contains("removeable"),
                MoveStartPos = 0,
                MoveCurrentPos = 0,
                protect = row.dataset.removeableConfigured,
                isScrolling = false;
            
            
            $(document).scrollEnd(function () {
                // _class.isSrolling = isScrolling = false;
                // _class.scrolling = false;
                console.log("Scrolling Stopped");
                // document.querySelector("ul li:first-child").innerText = "Scrolling Stopped";
                }, 1000);
    
    
            document.onscroll = function(){
                // _class.isSrolling = isScrolling = true;
                _class.scrolling = true;
                // alert(12);
                // document.querySelector("ul li:first-child").innerText = "Scrolling";
                // console.log("Scrolling");
            }
    
            /**
             * New DISABLED ROW PROTECTION
             */
            if( row.classList.contains("disabled") ){
                // alert("Disabled");
                row.style.position = "relative";
                
                let protect = document.createElement("div");
                protect.style.width = "100%";
                protect.style.height = "100%";
                protect.style.zIndex = "99";
                protect.style.position = "absolute";
                protect.style.top = 0;
                protect.style.left = 0;
                protect.style.backgroundColor = "transparent";
                
                row.appendChild(protect);
                
                
            }
            
            
            row.addEventListener("isChecked", function () {
            }, true);
            
            
            // Check With Subtitle
            if (undefined !== row.dataset.subTitle && !row.classList.contains("row-with-sub-title-created")) {
                
                // alert(row.dataset.subTitle);
                
                let subTitle = row.dataset.subTitle;
                
                // Check Row Has Label
                // data-sub-title
                let hasLabel = row.querySelector("label:first-child");
                let hasSelect = row.querySelector("select");
                let hasLink = row.querySelector("a");
                
                console.log("hasLabel", hasLabel);
                
                // Set Default Target Element
                targetEl = row;
                
                
                // Check Has Label
                if (null !== hasLabel) {
                    targetEl = hasLabel;
                }
                
                // Check Has Select
                if (null !== hasSelect) {
                    targetEl = row;
                    
                }
                
                // Check Has Select
                if (null !== hasLink) {
                    targetEl = hasLink;
                    
                }
                
                
                // Add New Content to Original Content
                
                // Create New Label Content with subTitle
                let labelNewContent = document.createElement("div");
                labelNewContent.style.display = "table";
                labelNewContent.style.width = "100%";
                
                // labelNewContent Title
                let NewContentTitle = document.createElement("span");
                NewContentTitle.style.display = "table-row";
                NewContentTitle.dataset.role = "title";
                NewContentTitle.innerHTML = targetEl.innerHTML;
                
                
                // labelNewContent Title
                let NewContentSubTitle = document.createElement("span");
                NewContentSubTitle.style.display = "table-row";
                NewContentSubTitle.dataset.role = "sub-title";
                NewContentSubTitle.style.fontSize = "10px";
                if (subTitle === "") {
                    // NewContentSubTitle.style.display = "none";
                    
                }
                
                if( undefined !== row.dataset.subTitleHtml && row.dataset.subTitleHtml === "true" ){
                    NewContentSubTitle.innerHTML = subTitle;
                } else {
                    
                    NewContentSubTitle.innerText = subTitle;
                }
                
                if ( undefined !== row.dataset.subTitleColor && null !== row.dataset.subTitleColor ){
                    NewContentSubTitle.classList.add( row.dataset.subTitleColor );
                }
    
                // alert(row.innerText + " " + row.dataset.subTitleHtml);
                // alert(NewContentSubTitle.outerHTML);
                
                // Append All
                // NewContentTitle.append(NewContentSubTitle);
                
                
                labelNewContent.append(NewContentTitle);
                labelNewContent.append(NewContentSubTitle);
                
                
                // NewContentTitle Has Label El
                let NewContentTitleHasLabel = NewContentTitle.querySelector("label:first-child");
                if (null !== NewContentTitleHasLabel) {
                    NewContentTitleHasLabel.append(NewContentSubTitle);
                }
                
                targetEl.innerText = "";
                targetEl.append(labelNewContent);
                
                
                
                
                // set already created
                row.classList.add("row-with-sub-title-created");
                
                
            }
            
            /**
             * Remove able Row
             * option [protect], this row already configured, and stop again
             * Stop multiple configuration
             */
            
            if (removeable && !protect) {
                
                try {
                    
                    if (!protect) {
                        
                        let row_w = document.createElement("div");
                        row_w.classList.add("row-wrapper");
                        
                        let row_b = document.createElement("div");
                        row_b.classList.add("row-body");
                        row_b.innerHTML = row.innerHTML;
                        
                        let row_a = document.createElement("div");
                        row_a.classList.add("row-action");
                        
                        let a = document.createElement("button");
                        a.innerText = "Delete";
                        a.classList.add("bg-danger");
                        
                        let f = document.createElement("button");
                        f.classList.add("bg-info");
                        f.innerText = "Verbindung";
                        
                        let c = document.createElement("button");
                        c.classList.add("bg-warning");
                        c.innerText = "Info";
                        
                        // row_a.append(c);
                        row_a.append(f);
                        row_a.append(a);
                        
                        row_w.append(row_a);
                        row_w.append(row_b);
                        
                        row.innerHTML = "";
                        
                        // alert(1);
                        row.append(row_w);
                        
                        /**
                         * Add Data to Row for declare, that configured
                         * @type {boolean}
                         */
                        row.dataset.removeableConfigured = true;
                        
                        events(row_w, row_b, row_a, a);
                        
                    } else {
                        
                        // Only Events
                        let row_w = row.querySelector(".row-wrapper");
                        let row_b = row.querySelector(".row-body");
                        let row_a = row.querySelector(".row-action");
                        let a = row.querySelector(".row-action button");
                        events(row_w, row_b, row_a, a);
                        
                    }
                    
                    
                    /**
                     * Row Body RemoveAble Action
                     *
                     * @param rowWrapper
                     *
                     *
                     * @param rowBody
                     * @param rowAction
                     * @param actionEl
                     */
                    
                    function events(rowWrapper, rowBody, rowAction, actionEl) {
                        
                        let moving = false;
                        
                        row.onmousedown = function (e) {
                            /*console.log("OffsetX", e.offsetX);
                            console.log("ClientX", e.clientX);
                            console.log("PageX", e.pageX);
                            console.log("LayerX", e.layerX);
                            console.log("X", e.x);*/
                            
                            MoveStartPos = e.pageX;
                            
                            e.preventDefault();
                            
                        }
                        row.ontouchstart = function (e) {
                            MoveStartPos = e.pageX;
                            moving = false;
                            // e.preventDefault();
                            
                        };
                        
                        row.onmouseup = function (e) {
                            
                            MoveCurrentPos = e.pageX;
                            
                            // alert(rowAction.offsetWidth);
                            let res = MoveCurrentPos - MoveStartPos;
                            
                            if (res < -(rowAction.offsetWidth / 4)) {
                                
                                rowBody.style.left = -rowAction.offsetWidth + "px";
                                rowBody.classList.add("to-open");
                                rowBody.classList.remove("to-close");
                                
                            } else {
                                
                                rowBody.classList.remove("to-open");
                                rowBody.classList.add("to-close");
                                
                                setTimeout(function () {
                                    rowBody.style.left = 0;
                                }, 300);
                                
                                
                            }
                            
                            // e.preventDefault();
                            
                            
                        };
                        row.ontouchend = function (e) {
                            
                            
                            MoveCurrentPos = e.pageX;
                            
                            let res = MoveCurrentPos - MoveStartPos;
                            
                            if (res < -(rowAction.offsetWidth / 4)) {
                                
                                rowBody.style.left = -rowAction.offsetWidth + "px";
                                rowBody.classList.add("to-open");
                                rowBody.classList.remove("to-close");
                                
                            } else {
                                
                                rowBody.classList.remove("to-open");
                                rowBody.classList.add("to-close");
                                
                                setTimeout(function () {
                                    rowBody.style.left = 0;
                                }, 300);
                                
                                
                            }
                            
                            if (moving) {
                                // e.preventDefault();
                            }
                            
                            
                        };
                        
                        row.onmousemove = function (e) {
                            
                            if (rowBody.classList.contains("to-open")) return false;
                            
                            if (e.buttons || e.which) {
                                
                                MoveCurrentPos = e.clientX;
                                
                                if (
                                    rowBody.classList.contains("to-close") ||
                                    rowBody.classList.contains("to-open")
                                ) {
                                    rowBody.classList.remove("to-close");
                                    rowBody.classList.remove("to-open");
                                }
                                
                                
                                let res = MoveCurrentPos - MoveStartPos;
                                
                                if (res < -rowAction.offsetWidth) {
                                    return false;
                                }
                                
                                if (res > 0) {
                                    return false;
                                }
                                
                                // e.preventDefault();
                                
                                rowBody.style.left = res + "px";
                                
                                
                            }
                        };
                        row.ontouchmove = function (e) {
                            
                            moving = true;
                            
                            if (rowBody.classList.contains("to-open")) return false;
                            
                            MoveCurrentPos = e.pageX;
                            
                            if (
                                rowBody.classList.contains("to-close") ||
                                rowBody.classList.contains("to-open")
                            ) {
                                rowBody.classList.remove("to-close");
                                rowBody.classList.remove("to-open");
                            }
                            
                            
                            let res = MoveCurrentPos - MoveStartPos;
                            
                            // row_a.style.width = res + px;
                            if (res < -rowAction.offsetWidth) {
                                return false;
                            }
                            
                            
                            if (res > 0) {
                                return false;
                            }
                            
                            rowBody.style.left = res + "px";
                            
                            // e.preventDefault();
                            
                        };
                        
                        /**
                         * Remove Button Action
                         * @param e
                         */
                        actionEl.ontouchend = function (e) {
                            
                            row.style.marginTop = -row.offsetHeight + "px";
                            row.classList.add("to-remove");
                            setTimeout(function () {
                                row.remove();
                            }, 600);
                            e.preventDefault();
                            
                        };
                        actionEl.onclick = function (e) {
                            
                            row.previousElementSibling.classList.add("border-bottom");
                            row.style.marginTop = -row.offsetHeight + "px";
                            row.classList.add("to-remove");
                            setTimeout(function () {
                                row.previousElementSibling.classList.remove("border-bottom");
                                setTimeout(function () {
                                    row.remove();
                                }, 100);
                            }, 20000);
                            e.preventDefault();
                        };
                        
                        
                    }
                    
                    
                } catch (e) {
                    
                    alert("E.680", e.messaage);
                    
                    
                }
                
                
            }
            
            
            if (row.querySelector("a") !== null || row.querySelector("button") !== null)
            
            {
                // alert("A or Button For " + row.innerText);
                
                let actionElement = rowElements[0];
                
                
                // If A has Select than set it disabled
                try {
                    actionElement.querySelector("select").setAttribute("disabled", "disabled");
                } catch (e) {
                
                }
                
                
                let prevClickEvent = actionElement.onclick;
                let prevTouchEndEvent = actionElement.ontouchend;
                let prevTouchStartEvent = actionElement.ontouchstart;
                
                if (rowElements[0].nodeName === "BUTTON") {
                    
                    // let celButton = rowElements[0];
                    
                    // Add Custom Switch row Style
                    row.style.padding = "10px";
                    row.style.minHeight = "auto";
                    
                    rowElements[0].innerText = rowElements[0].innerText + " " + "'Please use this element as Input button'";
                    
                    
                }
                
                
                // TODO On Click Event
                if (!X2.fromDevice()) {
                    
                    if (null === actionElement.onclick) {
                        
                        actionElement.onclick = function (e) {
                            
                            // alert("Click Event for Cell");
                            if (row.classList.contains("disabled")) return false;
                            
                            if (null !== prevClickEvent) {
                                prevClickEvent();
                            }
                        };
                        
                    }
                    
                    
                } else {
                    
                    // TODO On Touch Start Event
                    if (actionElement.ontouchstart === null) {
                        
                        
                        actionElement.ontouchstart = function (e) {
                            
                            moveEvent = false;
                            
                            if (row.classList.contains("disabled")) return false;
                            
                            row.classList.add("touchstart");
                            row.classList.remove("touchend");
                            
                            if (null !== prevTouchStartEvent) {
                                prevTouchStartEvent();
                            }
                            
                        };
                        
                    }
                    
                    // TODO On Touch End Event
                    if (actionElement.ontouchend === null) {
                        
                        
                        actionElement.ontouchend = function (e) {
    
                            
                            
                            let El = this;
                            
                            if (moveEvent) {
                                e.preventDefault();
                            } else {
                                
                                if (row.classList.contains("disabled")) return false;
                                
                                row.classList.toggle("touchstart");
                                
                                
                                if (null !== prevTouchEndEvent) {
                                    // alert(prevTouchEndEvent);
                                    prevTouchEndEvent();
                                } else {
                                    
                                    if (this.dataset !== undefined && this.dataset.data !== undefined) {
                                        setTimeout(function () {
                                            
                                            // _class.selectedRow = row;
                                            _class.setSelectedRow(row);
                                            
                                            X2.presentViewControllerWithData(El.dataset.data);
                                        }, 100);
                                    }
                                    
                                }
                                
                                e.preventDefault();
                            }
                        }
                        
                    }
                    
                    
                    // TODO On Touch Move Event
                    if (actionElement.ontouchmove === null) {
                        
                        actionElement.ontouchmove = function (e) {
    
                            row.classList.remove("touchstart");
                            row.classList.add("touchend");
                            
                            moveEvent = true;
                        };
                        
                    }
                    
                    
                }
                
                
                // console.log("row Disabled", row.classList  );
                if (row.classList.contains("disabled")) {
                    
                    if (null !== row.querySelector("a")) {
                        row.querySelector("a").classList.add("disabled");
                    }
                    
                    if (null !== row.querySelector("button")) {
                        row.querySelector("button").classList.add("disabled");
                    }
                    
                }
                
                
            }
            
            // OTHER ELEMENTS
            else {
                
                
                // console.log("Disabled:", row.classList.contains("disabled"));
                // Not more than 2 Elements
                if (rowElements.length > 2) {
                    console.log("row elements can not more than 2 elements");
                    // return false;
                }
                
                let hasCheck = false;
                let hasRadio = false;
                let hasSwitch = false;
                let hasButton = false;
                let hasImage = false;
                let hasSelect = false;
                
                
                
                for (let i = 0; i < rowElements.length; i++) {
                    
                    // alert(rowElements[i].nodeName);
                    switch (rowElements[i].nodeName) {
                        
                        case "INPUT":
                            
                            
                            input = rowElements[i];
                            // console.log(input);
                            
                            console.log("Input-->", input);
                            
                            if (row.classList.contains("required")) {
                                input.setAttribute("required", "required");
                                // row.classList.add("hide");
                            }
                            
                            switch (input.type) {
                                
                                case "radio":
                                    hasRadio = true;
                                    break;
                                case "checkbox":
                                    hasCheck = true;
                                    break;
                                case "button":
                                    
                                    row.style.padding = "10px 0 10px 10px";
                                    row.style.minHeight = "auto";
                                    hasButton = true;
                                    break;
                                
                                case "text":
                                case "date":
                                    row.ontouchend = function (El) {
                                        El.querySelector("input").focus();
                                    }
                                    break;
                            }
                            
                            break;
                        
                        case "BUTTON":
                            
                            hasButton = true;
                            break;
    
                        case "IMG":
                            hasImage = true;
                            break;
    
                        case "SELECT":
                            hasSelect = true;
                            break;
                        
                        default:
                            
                            if (rowElements[i].classList.contains("switch")) {
                                hasSwitch = true;
                            }
                            break;
                        
                    }
                    
                }
                
                for (let i = 0; i < rowElements.length; i++) {
                    
                    
                    switch (rowElements[i].nodeName) {
                        case "INPUT":
                            input = rowElements[i];
                            console.log("Input", input);
                            
                            if (input.checked && input.type !== "radio") {
                                row.classList.add("cell-active");
                                break;
                            }
                            break;
                        
                        case "SELECT":
                            // alert(1);
                            select = rowElements[i];
                            console.log("Select El", select);
                            break;
                        
                        case "LABEL":
                            label = rowElements[i];
                            console.log("Label", label);
                            break;
    
                        case "IMG":
                            rowImage = rowElements[i];
                            console.log("Image", rowImage);
                            break;
                    }
                    
                }
                
                // alert("hasImage" + hasImage);
                
                if (label === undefined) {
                    // Ignore
                    console.log("No Label found for row " + row + ", please check out!");
                    // return false;
                }
                
                if (input === undefined) {
                    // Ignore
                    console.log("No Input found for row " + row + " please check out!");
                    // return false;
                }
                
                if (select === undefined) {
                    // Ignore
                    console.log("No select found for row " + row + " please check out!");
                    // return false;
                }
                
                // Action off if Row disabled
                if (row.classList.contains("disabled") || row.hasAttribute("disabled")) {
                    let el = input || select;
                    if (undefined !== el) {
                        el.setAttribute("disabled", "disabled");
                    }
                    
                    /*try{
                        input.setAttribute("disabled", "disabled");
                        select.setAttribute("disabled", "disabled");
                    } catch (e) {
                    
                    }*/
                    
                    
                }
                
                
                /*
                * row Check is if(Tab over row this row is checked and present it with icon)
                * */
                if (hasRadio || hasCheck) {
                    
                    
                    if (!input.hasAttribute("disabled") && undefined !== label) {
                        
                        /*
                        check operation with Label not more allow
                        Use instead of label on touch , row on touch
                         */
                        
                        // Remove Label for Attribute for securiry
                        label.removeAttribute("for");
                        
                        // Change Label with row
                        label = row;
                        
                        
                        label.ontouchmove = function (e) {
                            moveEvent = true;
                        };
                        label.ontouchstart = function (e) {
                            
                            
                            moveEvent   = false;
                            // if( _class.isSrolling ) return false;
                            // row.classList.add("touchanimation");
                            console.log("Event", "ontouchstart");
                            
                        };
                        
                        label.removeEventListener("click", function () {
                        
                        });
                        
                        label.onclick = function (e) {
                            // moveEvent = false;
                        };
                        
                        label.ontouchend = function (e) {
                            
                            // alert(_class.scrolling);
                            // alert(_class.isSrolling);
                            // if (_class.isSrolling) return false;
    
                            // document.querySelector("ul li:first-child").innerText = "Scrolling:" + _class.scrolling;
                            
                            
                            
                            /*setTimeout(function () {
                                _class.scrolling = false;
                            },1000);*/
                            
                            
                            // if ( _class.scrolling) return false;
                            
                            
                            // row.innerText = _class.isSrolling;
                            if (moveEvent) {
                                e.preventDefault();
                                return false;
                            } else {
    
                                // row.classList.add("touchanimation");
                                // row.classList.add("touchanimation");
                                // setTimeout(function () {
                                    // row.classList.remove("touchanimation");
                                // }, 100);
                                
                               setTimeout(function () {
                                   _class.switchRowEvent(TableView, row, this, e);
                                   
                               },100);
                                
                            }
                            
                        }
                        
                    }
                    
                    
                }
                
                if (hasButton) {
                    
                    
                    try{
                        let prevClickEvent = input.onclick;
                        let prevTouchEndEvent = input.ontouchend;
                        let prevTouchStartEvent = input.ontouchstart;
    
                        // input.style.backgroundColor = "red"
    
                        
                        
                        let rowPaddingL = row.style.paddingLeft;
                        let rowPaddingR = row.style.paddingRight;
                        let rowPaddingT = row.style.paddingTop;
                        let rowPaddingB = row.style.paddingBottom;
                        row.style.padding = 0;
    
                        input.style.paddingTop = rowPaddingT;
                        input.style.paddingBottom = rowPaddingB;
                        input.style.paddingLeft = rowPaddingL;
                        input.style.paddingRight = rowPaddingR;
    
                        // alert(rowPaddingL);
    
                        input.ontouchmove = function (e) {
                            moveEvent = true;
                            row.classList.add("touchend");
                            row.classList.remove("touchstart");
                        };
    
                        // 1. Trigger ontouchstart Event (is exists) ( Ignore touchend if exists and click if exists )
                        input.ontouchstart = function (e) {
                            
                            row.classList.add("touchstart");
                            row.classList.remove("touchend");
        
                            moveEvent = false;
        
                            /*if (!this.hasAttribute("disabled") && null !== prevTouchStartEvent && DEVICE === DEVICE_TYPE.IOS) {
                                prevTouchStartEvent();
                                e.preventDefault();
                            }*/
                        };
    
                        // 2. Trigger ontouchend Event (is exists) ( If touchstart not exists Ignore click event if exists )
                        input.ontouchend = function (e) {
    
                            row.classList.add("touchend");
                            row.classList.remove("touchstart");
        
                            if( moveEvent ){
                                return false;
                            }
    
                            if (null !== prevTouchEndEvent) {
        
                                prevTouchEndEvent();
                                e.preventDefault();
        
                            } else {
        
                                // Input Type button zaten click event kapali
                                // if (row.classList.contains("disabled")) return false;
        
                                // alert(this.dataset.data);
                                if (this.dataset !== undefined && this.dataset.data !== undefined  ) {
            
                                    // _class.selectedRow = row;
                                    _class.setSelectedRow(row);
            
                                    X2.presentViewControllerWithData(this.dataset.data);
            
            
                                }
        
                                e.preventDefault();
        
                            }
                        };
    
                        // 3. Trigger onclick Event (is exists) ( If touchstart not exists && click event not exists )
                        input.onclick = function (e) {
                            // moveEvent = false;
                            console.log("Button click Event", prevClickEvent);
        
                            if (!this.hasAttribute("disabled") && null !== prevClickEvent && DEVICE === DEVICE_TYPE.ANDROID) {
                                prevClickEvent();
                                e.preventDefault();
                            }
        
                        };
                    }
                    catch (e){
                        alert(e.message);
                    }
                    
                    
                }
                
                if (hasSwitch /*|| row.classList.contains("switch")*/) {
                    
                    // alert(row.innerText)
                    // Add Custom Switch Class For row
                    row.classList.add("switch");
                    
                    // alert(1);
                    
                    console.log("row Switch", row);
                    // Find Switch
                    for (let d = 0; d < row.children.length; d++) {
                        
                        let _switch = undefined;
                        console.log("Switch Elements", row.children[d].classList);
                        if (row.children[d].classList.contains("switch")) {
                            console.log("Switch Element %i %s", d, row.children[d].classList);
                            _switch = row.children[d];
                        }
                        // console.log("Found Switch Element %o", _switch);
                        
                        if (undefined !== _switch) {
                            
                            let _switchElements = row.children[d].children;
                            // console.log("Found Switch Elements", _switchElements);
                            for (let k = 0; k < _switchElements.length; k++) {
                                
                                if (_switchElements[k].nodeName === "LABEL") {
                                    label = _switchElements[k];
                                    // console.log("Target Switch Element", label);
                                }
                                
                            }
                            
                        }
                        
                    }
    
                    
                    
                    
                    label.ontouchmove = function (e) {
                        // moveEvent = true;
                        // console.log("Event", "ontouchmove" );
                    };
                    label.ontouchstart = function (e) {
                        
                        X2.Vibrate();
                        label.click();
                        // moveEvent = false;
                        e.preventDefault();
                        console.log("Event", "ontouchstart");
                        return false;
                    };
                    /*label.onclick = function(e){
                        moveEvent = false;
                        _class.switchRowEvent( TableView, row, this, e );
                        // console.log("Event", "onclick" );
                    };*/
                    label.ontouchend = function (e) {
                        /*if( moveEvent ){
                            e.preventDefault();
                        } else {
                            // alert(1);
                            label.click();
                            e.preventDefault();
                        }*/
                    }
                    /*}*/
                    
                    
                }

                if (hasImage) {
                    
                    // Wrap Image into div
                    let imageWrapper = document.createElement("div");
                    imageWrapper.classList.add("row-image");
                    wrap( rowImage, imageWrapper );
    
                    function wrap(el, wrapper) {
                        el.parentNode.insertBefore(wrapper, el);
                        wrapper.appendChild(el);
                    }
                    
                    
                    
                }
                
                /*else {
                    alert(2);
                    /!**
                     * Burda bi aksilik var
                     * Androidde Datepicker acilmiyor.
                     *!/
                    
                    // Text, Textarea etc.
                    // row.onclick = function (e) {
                    //
                    //     let clickableEl = ["text", "password", "email", "time", "month", "number", "search", "tel", "color", "date"];
                    //
                    //     for (let i = 0; i < rowElements.length; i++) {
                    //
                    //         if (rowElements[i].nodeName === "INPUT") {
                    //
                    //             if (row.classList.contains("in") && !row.classList.contains("disabled")) {
                    //                 row.classList.toggle("in");
                    //             }
                    //
                    //
                    //             if (clickableEl.indexOf(rowElements[i].type) > -1) {
                    //                 rowElements[i].focus();
                    //                 break;
                    //             }
                    //
                    //
                    //         }
                    //
                    //
                    //     }
                    //
                    //     e.preventDefault();
                    // }
                    
                }*/
                
                /*if( hasSelect ){
    
                    if(row.classList.contains("disabled")){
    
                        alert(23);
                        select.classList.add("disabled");
                        select.setAttribute("disabled", "disabled");
        
                    }
                    
                    
                }*/
                
                
            }
            
            
        };
        
        this.updateRowSubTitle = function ( row, value ) {
    
            if( undefined !== row.dataset.subTitleHtml && row.dataset.subTitleHtml === "true" ){
                
                row.querySelector("a span[data-role=sub-title]").innerHTML = value;
            }
            
            else {
                
                row.querySelector("a span[data-role=sub-title]").innerText = value;
                
            }
            
            
            return this;
            
        }
        
        this.sort = function (rows) {
            
            
            let sortedObj = [];
            let childrenCount = TableView.children.length;
            let sortedItmIndex = 0;
            let mixedGroups = [];
            let groupHeader;
            
            
            // for (let row in rows ){
            
            TableView.querySelectorAll("li").forEach(function (El) {
                
                // console.log("El",El);
                
                // let El = rows[row];
                
                if (Object.keys(sortedObj).indexOf(El.dataset[_class.sort.dataGroupKey]) < 0) {
                    
                    // console.log("_class.parameters.sort.dataGroupKey",_class.parameters.sort.dataGroupKey);
                    
                    let sortedBlockChildren = {};
                    let sortedBlockChildrenKeys = [];
                    let blockChildren = TableView.querySelectorAll("li.cell[data-" + _class.parameters.sort.dataGroupKey + "='" + El.dataset[_class.parameters.sort.dataGroupKey] + "']");
                    
                    // console.log("blockChildren",blockChildren);
                    
                    blockChildren.forEach(function (El) {
                        
                        // console.log("El.dataset[_class.parameters.sort.dataGroupKey]",El.dataset[_class.parameters.sort.dataGroupKey]);
                        if (
                            El.dataset[_class.parameters.sort.dataSortKey] === null &&
                            El.dataset[_class.parameters.sort.dataSortKey] === undefined) {
                            
                            sortedBlockChildren[El.innerText] = El;
                        } else {
                            
                            sortedBlockChildren[El.dataset[_class.parameters.sort.dataSortKey]] = El;
                            
                            
                        }
                        
                    });
                    
                    // console.log("sortedBlockChildren",sortedBlockChildren);
                    
                    
                    sortedBlockChildrenKeys = Object.keys(sortedBlockChildren).sort();
                    
                    console.log("sortedBlockChildrenKeys", sortedBlockChildrenKeys);
                    
                    let doNewObject = [];
                    
                    for (let i in sortedBlockChildrenKeys) {
                        
                        doNewObject.push(sortedBlockChildren[sortedBlockChildrenKeys[i]]);
                        
                        
                        // console.log("doNewObject",doNewObject);
                        
                        sortedObj[El.dataset[_class.parameters.sort.dataGroupKey]] = {
                            count: doNewObject.length,
                            items: doNewObject
                        };
                    }
                    
                    
                }
                
            });
            
            console.log("sortedObj", sortedObj);
            
            
            for (let group in sortedObj) {
                mixedGroups.push({
                    group: group,
                    delegates: sortedObj[group].items,
                    count: sortedObj[group].count,
                });
            }
            ;
            
            mixedGroups.sort(function (a, b) {
                var _a = a.group.toUpperCase(); // Upper -/Lower ignore
                var _b = b.group.toUpperCase(); // Upper -/Lower ignore
                if (_a < _b) {
                    return -1;
                }
                if (_a > _b) {
                    return 1;
                }
                return 0;
            });
            
            for (let group in mixedGroups) {
                console.log("Group", group);
                
                groupHeader = document.createElement("li");
                // groupHeader.innerText = mixedGroups[group].group;// + " " + mixedGroups[group].count;
                groupHeader.dataset.group = mixedGroups[group].group;
                groupHeader.classList.add("section");
                groupHeader.classList.add("group-header");
                TableView.append(groupHeader);
                // alert(_class.parameters.dataBadgeKey)
                
                let lbl = document.createElement("label");
                lbl.innerText = mixedGroups[group].group;
                groupHeader.append(lbl);
                
                if (_class.parameters.badge) {
                    
                    groupHeader.setAttribute("data-" + _class.parameters.dataBadgeKey, mixedGroups[group].count);
                    groupHeader.classList.add("x2-badge");
                }
                
                /*
                let ghostHeader = headerEl.cloneNode(true);
                ghostHeader.classList.add("hide");
                ghostHeader.classList.add("ghost");
                ghostHeader.classList.add("fix-top");
                ghostHeader.style.zIndex = group + 1;
                ghostHeader.style.top = headerEl.offsetTop + "px";
                parent.insertBefore(ghostHeader, headerEl.nextSibling);
                */
                
                for (let item in mixedGroups[group].delegates) {
                    let o = mixedGroups[group].delegates[item];
                    TableView.append(o);
                    sortedItmIndex++;
                }
                
                if (sortedItmIndex === childrenCount) {
                    // TableView.classList.add("show");
                }
            }
            ;
            
            
        }
        
        this.rowProperty = function (selector, rows /* Array Elements */, value) {
            
            
            console.log("rowProperty", rows);
            
            switch (selector) {
                
                case "disabled":
                    
                    rows.forEach(function (El) {
                        
                        console.log("rowProperty", El);
                        
                        
                        if (value) {
                            
                            if (!El.classList.contains(selector)) {
                                
                                El.classList.add(selector);
                                
                                El.querySelectorAll("INPUT").forEach(function (E2) {
                                    E2.setAttribute(selector, selector);
                                });
                                
                                El.querySelectorAll("TEXTAREA").forEach(function (E2) {
                                    E2.setAttribute(selector, selector);
                                });
    
                                El.querySelectorAll("SELECT").forEach(function (E2) {
                                    E2.setAttribute(selector, selector);
                                });
                            }
                            
                        } else {
                            
                            // alert(selector + " " + value + " " + El.nodeName );
                            
                            El.classList.remove(selector);
                            El.querySelectorAll("input").forEach(function (E2) {
                                E2.removeAttribute(selector);
                            });
    
                            El.querySelectorAll("TEXTAREA").forEach(function (E2) {
                                E2.removeAttribute(selector);
                            });
    
                            El.querySelectorAll("SELECT").forEach(function (E2) {
                                E2.removeAttribute(selector);
                            });
                        }
                        
                    });
                    
                    break;
                
                
                case "enabled":
                    
                    rows.forEach(function (El) {
                        
                        if (!value) {
                            
                            if (!El.classList.contains("disabled")) {
                                
                                El.classList.add("disabled");
                                
                                El.querySelectorAll("INPUT").forEach(function (E) {
                                    E.setAttribute("disabled", "disabled");
                                });
                                
                            }
                            
                        } else {
                            
                            // alert(El.innerText + " " + selector + " -> " + value);
                            El.classList.remove("disabled");
                            
                            El.querySelectorAll("INPUT").forEach(function (E) {
                                E.removeAttribute("disabled");
                            });
                        }
                        
                    });
                    
                    break;
                
                
                default:
                    break;
                
            }
            
            
        }
        
        this.children = function (callback) {
            if (undefined !== callback && typeof callback === "function") {
                _class._children = callback;
            }
            return this;
        };
        
        this.refresh = function () {
            
            /*TableView.querySelectorAll("a").forEach(function (El) {
                El.removeEventListener("touchstart", function(){});
                El.removeEventListener("touchend", function(){});
                El.removeEventListener("touchmove", function(){});
            });*/
            
            
            this.load();
            
            return this;
            
        }
        
        /**
         * @deprecated
         * @param event
         * @param callback
         * @returns {X2Tools}
         */
        this.on = function (event, callback) {
            
            switch (event) {
                
                case "cell.before.touch":
                    this.callbackRowBeforeTouch = callback;
                    break;
                case "cell.touch":
                    this.callbackRowTouch = callback;
                    break;
                case "cell.click":
                    this.callbackRowClick = callback;
                    break;
                
            }
            
            return this;
            
            
        };
        
        /*
        * Switch Elements Radio Checkbox
        * */
        this.switchRowEvent = function (TableView, row, Label, Event) {
            
            if (!(DEVICE === "")) {
                // El.click();
            }
            if (null !== Event) {
                Event.preventDefault();
            }
            
            
            let input = null;
            let rowElements = row.children;
            for (let i = 0; i < rowElements.length; i++) {
                if (rowElements[i].nodeName === "INPUT") {
                    
                    input = rowElements[i];
                    
                    
                    let prevClickEvent = input.onclick;
                    let prevTouchEndEvent = input.ontouchend;
                    let prevTouchStartEvent = input.ontouchstart;
                    
                    input.click();
                    
                    // console.log("input",input);
                    switch (input.type) {
                        case "checkbox":
                            
                            // input.checked   = !input.checked;
                            row.removeEventListener("click", function () {
                            });
                            
                            
                            row.classList.remove("cell-active");
                            if (input.checked) {
                                
                                row.classList.add("cell-active");
                                
                                try {
                                    
                                    if (undefined !== row.isChecked && typeof row.isChecked === "function") {
                                        row.isChecked();
                                    }
                                    
                                    
                                } catch (e) {
                                    alert(e.message)
                                }
                                
                            }
                            break;
                        
                        case "radio":
                            
                            // row.dataset.selected = false;
                            
                            if (input.checked) {
                                
                                // row.dataset.selected = true;
                                row.classList.toggle("cell-active");
                                
                                try {
                                    
                                    
                                    if (undefined !== prevTouchEndEvent && null !== prevTouchEndEvent) {
                                        prevTouchEndEvent();
                                    }
                                    
                                    if (undefined !== prevClickEvent && null !== prevClickEvent) {
                                        prevClickEvent();
                                    }
                                    
                                    if (undefined !== prevTouchStartEvent && null !== prevTouchStartEvent) {
                                        prevTouchStartEvent();
                                    }
                                    
                                } catch (e) {
                                    
                                    alert(e.message);
                                    
                                }
                                
                                row.classList.toggle("cell-active");
                                _class.callbackRowBeforeTouch.call(Label, TableView, row) || _class.callbackRowTouch.call(Label, TableView, row) || _class.callbackRowClick.call(Label, TableView, row);
                                
                            }
                            break;
                    }
                    break;
                }
            }
            
            return this;
        };
        
        this.checkedSerialize = function (TableView) {
            
            let tv = null;
            let s = [];
            if ("undefined" === typeof tv) {
                tv = document.querySelectorAll("ul.x2-list input:checked");
                tv.forEach(function (El) {
                    s.push(El.value)
                });
                
            } else {
                if (TableView.classList.contains("x2-list")) {
                    
                    
                    for (let i = 0; i < TableView.children.length; i++) {
                        
                        let row = TableView.children[i];
                        if (row.classList.contains("cell-check")) {
                            let rowElements = row.children;
                            console.log(rowElements.length);
                            for (let x = 0; x < rowElements.length; x++) {
                                let rowEl = rowElements[x];
                                if (rowEl.nodeName === "INPUT" && rowEl.checked) {
                                    s.push(rowEl.value);
                                }
                                
                            }
                            
                        }
                        
                    }
                    
                }
            }
            
            
            r = {};
            r.object = s;
            r.json = JSON.stringify(s);
            
            return r;
            
        };
        
        this.checkedCallback = function (callback) {
            
            let tv = null;
            let s = [];
            if ("undefined" === typeof tv) {
                tv = document.querySelectorAll("ul.x2-list input:checked");
                tv.forEach(function (El) {
                    s.push(El.value)
                });
                
            } else {
                if (TableView.classList.contains("x2-list")) {
                    
                    
                    for (let i = 0; i < TableView.children.length; i++) {
                        
                        let row = TableView.children[i];
                        if (row.classList.contains("cell-check")) {
                            let rowElements = row.children;
                            console.log(rowElements.length);
                            for (let x = 0; x < rowElements.length; x++) {
                                let rowEl = rowElements[x];
                                if (rowEl.nodeName === "INPUT" && rowEl.checked) {
                                    s.push(rowEl.value);
                                }
                                
                            }
                            
                        }
                        
                    }
                    
                }
            }
            
            
            r = {};
            r.object = s;
            r.json = JSON.stringify(s);
            
            return r;
            
        };
        
        this.create = function (callback) {
            
            if (Element === null) return false;
            
            // alert("Table View Create");
            this.init(function ( /*this Table View*/ rows) {
                
                if (undefined !== callback && typeof callback === "function") {
                    
                    callback( this, rows, _class);
                }
                
            });
            
            
            return this;
        };
        
        return this;
        
    };
    
    this.presentViewControllerWithData = function (data) {
        
        
        
        try{
            
            let parsedData      = typeof data === "string" ? JSON.parse(data) : data;
            
            // Determine Activity
            let activity = parsedData.activity !== undefined && null !== parsedData ? parsedData.activity : ACTIVITY.ACTIVITY_1;
            
            // Remove Activity el from object
            if( undefined !== parsedData.activity ){
                delete parsedData.activity;
            }
            
            // Convert to JSON string
            let dataJSONString  = typeof parsedData === "string" ? parsedData : JSON.stringify(parsedData);
            
            // Load WebElement
            location.href = DEVICE + "://" + activity + "?" + dataJSONString;
            
    
    
        } catch (e) {
            alert(e.message);
        }
        // location.href = DEVICE + "://" + activity + "?" + dataJSONString;
        
    }
    
    this.dismissViewController = function (data) {
        try {
            
            if (undefined !== data && null !== data && "" !== data) {
                if (Object.keys(data).length > 0) {
                    data = JSON.stringify(data);
                }
                location.href = DEVICE + "://" + ACTIVITY.ACTIVITY_UNWIND + "?" + data;
            } else {
                location.href = DEVICE + "://" + ACTIVITY.ACTIVITY_UNWIND + "?{}";
            }
            
        } catch (e) {
            alert(e.message);
        }
    };
    
    // Not Finish, Serialize the Form
    this.serializeContentV1 = function (el, callback) {
        
        let nodeName = el.nodeName;
        let jQueryArray = [], _ = {};
        let error = false;
        let postableElements = ["INPUT", "TEXTAREA", "SELECT"];
        let checkElements = ["checkbox", "radio"];
        
        let acceptNode = ["FORM", "DIV", "UL"];
        
        // alert(nodeName);
        
        if (acceptNode.indexOf(nodeName) > -1) {
            
            
            document.querySelectorAll("ul.x2-list li.cell").forEach(function (el) {
                
                let row = el
                
                console.log("Form row", row);
                
                if (row.classList.contains("required")) {
                    
                    
                    let rowElements = row.children;
                    for (let x = 0; x < rowElements.length; x++) {
                        
                        let rowElement = rowElements[x];
                        if (rowElement.nodeName === "INPUT") {
                            
                            let clickableEl = ["text", "password", "email", "time", "month", "number", "search", "tel", "color", "date"];
                            
                            switch (rowElement.type) {
                                
                                case "text":
                                case "password":
                                case "email":
                                case "time":
                                case "month":
                                case "number":
                                case "search":
                                case "tel":
                                case "color":
                                case "date":
                                    // Again Other
                                    if (rowElement.value === "") {
                                        row.classList.toggle("in", "out");
                                        // row.classList.add("out");
                                    }
                                    
                                    break;
                                
                                case "radio":
                                
                                case "checkbox":
                                    break;
                                
                            }
                        }
                        
                    }
                    
                    
                }
                
            });
            
            
            $(el).find('*').filter(function () {
                return $(this).attr("name") !== undefined && postableElements.indexOf(this.nodeName) > -1;
            }).each(function () {
                
                // Element Name
                let name = this.name;
                
                if (checkElements.indexOf(this.type) > -1) {
                    
                    if (name.indexOf("[]") > -1) {
                        
                        name = name.replace(/[[]]/g, '');
                        
                        console.log("Checkbox Multiple", name);
                        
                        let isElExists = false;
                        for (let i = 0; i < jQueryArray.length; i++) {
                            if (jQueryArray[i].name === name) {
                                
                                console.log("Checkbox is ", jQueryArray[i].name + " -> " + name);
                                isElExists = true;
                                if (this.checked) {
                                    jQueryArray[i].value.push(this.value)
                                }
                            }
                        }
                        
                        if (!isElExists) {
                            console.log("Element not found!");
                            
                            // Add first one
                            _ = {
                                "name": name,
                                "value": this.checked ? [this.value] : [],
                                "type": this.type
                            }
                            
                            jQueryArray.push(_);
                            
                        } else {
                            console.log("Element exits!");
                        }
                        
                        
                    } else {
                        
                        // console.log("Checkbox Single", this.name);
                        if (this.hasAttribute("required") && !this.checked) {
                            
                            console.log("Form will stop for ", this.name);
                            this.nextElementSibling.style.borderColor = "red";
                            this.nextElementSibling.onclick = function (El) {
                                El.target.style.borderColor = "";
                            }
                            
                            error = true;
                            
                        } else {
                            
                            if ((this.type === "radio" && this.checked) || this.type !== "radio") {
                                _ = {
                                    "name": this.name,
                                    "value": this.checked,
                                    "type": this.type
                                };
                            }
                            
                            
                            jQueryArray.push(_);
                            try {
                                this.nextElementSibling.style.borderColor = "";
                            } catch (e) {
                            
                            }
                        }
                        
                    }
                    
                    
                } else {
                    
                    if (this.hasAttribute("required") && this.value === "") {
                        
                        console.log("Form will stop for ", this.name);
                        error = true;
                        this.style.borderColor = "red";
                        
                        
                    } else {
                        
                        _ = {
                            "name": this.name,
                            "value": this.value !== "" ? this.value : null,
                            "type": this.type
                        };
                        
                        jQueryArray.push(_);
                        // this.style.borderColor = "";
                    }
                    
                    
                }
                
                
                this.onclick = function (El) {
                    // El.target.style.borderColor = "";
                }
                
            });
            
            
        } else {
            alert("Object must be [" + acceptNode.join(", ") + "] element!");
            return false;
        }
        
        
        console.log("jQueryArray", jQueryArray);
        
        
        let new_arr = {};
        for (let i = 0; i < jQueryArray.length; i++) {
            
            let totalElInForm = 1;
            if (typeof jQueryArray[i].value === "object" && jQueryArray[i].value !== null) {
                
                // Total El in form
                
                totalElInForm = document.getElementsByName(jQueryArray[i].name + "[]");
                if (totalElInForm.length && !jQueryArray[i].value.length) {
                    
                    console.log("Error for Required checkbox", jQueryArray[i].name);
                    document.getElementsByName(jQueryArray[i].name + "[]").forEach(function (El) {
                        // console.log("Parent of Checkbox", El.nextElementSibling );
                        El.nextElementSibling.style.borderColor = "red";
                        El.onclick = function () {
                            // this.nextElementSibling.style.borderColor = "";
                            document.getElementsByName(jQueryArray[i].name + "[]").forEach(function (El) {
                                El.nextElementSibling.style.borderColor = "";
                            });
                        }
                    });
                    error = true;
                } else {
                    document.getElementsByName(jQueryArray[i].name + "[]").forEach(function (El) {
                        El.nextElementSibling.style.borderColor = "";
                    });
                    
                }
                
            }
            
            // console.log("Type of Value -> ", jQueryArray[i].name + " " + typeof jQueryArray[i].value + " Total:"+ totalElInForm );
            
            
            new_arr[jQueryArray[i].name] = jQueryArray[i].value;
            // }
        }
        
        console.log("new_arr", new_arr);
        
        if (error) {
            
            if (undefined !== callback && "function" === typeof callback) {
                console.log("Form No Array");
                callback.call({});
                return false;
            }
            
            
        }
        
        if (undefined !== callback && "function" === typeof callback) {
            callback.call(new_arr);
        }
        
        
        return new_arr;
        
        
    };
    
    // Not Finish, Serialize the Form
    this.serializeContent = function (el, callback) {
        
        
        let nodeName = el.nodeName;
        let jQueryArray = [], _ = {};
        let error = false;
        let postableElements = ["INPUT", "TEXTAREA", "SELECT"];
        let requiredElements = [];
        let focused = false;
        // let checkElements = ["checkbox", "radio"];
        
        let acceptNode = ["FORM", "DIV", "UL"];
        
        // alert(nodeName);
        
        if (acceptNode.indexOf(nodeName) > -1) {
            
            
            document.querySelectorAll("ul.x2-list li.cell").forEach(function (el) {
                
                let row = el;
                
                console.log("Form row", row);
                
                if (row.classList.contains("required")) {
                    
                    
                    let rowElements = row.children;
                    for (let x = 0; x < rowElements.length; x++) {
                        
                        let rowElement = rowElements[x];
                        
                        if (rowElement.nodeName === "INPUT") {
                            
                            let clickableEl = ["text", "password", "email", "time", "month", "number", "search", "tel", "color", "date"];
    
                            rowElement.classList.remove("disabled");
                            rowElement.removeAttribute("disabled");
                            
                            if( row.classList.contains("disabled") || row.hasAttribute("disabled") ){
                                rowElement.classList.add("disabled");
                                rowElement.setAttribute("disabled", "disabled");
                            }
                            
                            
                            switch (rowElement.type) {
                                
                                case "text":
                                case "password":
                                case "email":
                                case "time":
                                case "month":
                                case "number":
                                case "search":
                                case "tel":
                                case "color":
                                case "date":
                                    
                                    // Again Other
                                    if (rowElement.value === "") {
                                        if (!row.classList.contains("disabled") && !row.hasAttribute("disabled")) {
                                            row.classList.add("show");
                                            error = true;
                                            requiredElements.push(rowElement);
                                        }
                                    } else {
                                        row.classList.remove("show");
                                    }
                                    
                                    rowElement.onblur = function () {
                                        if( this.value.trim().length ){
                                            row.classList.remove("show");
                                        }
                                    };
                                    
                                    break;
                                
                                case "radio":
                                case "checkbox":
                                    break;
                                
                            }
                        }
                        
                        else if(rowElement.nodeName === "TEXTAREA"){
                            
                            // Again Other
                            if (rowElement.value === "") {
                                // row.classList.remove("hide");
                                if (!row.classList.contains("disabled") && !row.hasAttribute("disabled")) {
                                    row.classList.add("show");
                                    error=true;
                                    requiredElements.push(rowElement);
                                }
                            } else {
                                row.classList.remove("show");
                            }
                            
                            rowElement.onblur = function () {
                                if( this.value.trim().length ){
                                    row.classList.remove("show");
                                }
                            }
                            
                        }

                        else if(rowElement.nodeName === "SELECT"){
    
                            // Again Other
                            if(!row.classList.contains("disabled")){
                                
                                if ( parseInt(rowElement.value) === 0  ) {
                                    error = true;
                                    requiredElements.push(rowElement);
                                }
                                
                            }
    
                            
                            
                        }
                        
                    }
                    
                    
                }
                
            });
    
    
    
            
            
            $(el).find('*').filter(function () {
                return $(this).attr("name") !== undefined && postableElements.indexOf(this.nodeName) > -1;
            })
                .each(function () {
                    
                    
                    // Element Name
                    let name = this.name;
                    
                    
                    
                    if (name.indexOf("[]") > -1) {
                        
                        
                        
                        name = name.replace(/[[]]/g, '');
                        
                        console.log("Checkbox Multiple", name);
                        
                        let isElExists = false;
                        for (let i = 0; i < jQueryArray.length; i++) {
                            
                            if (jQueryArray[i].name === name) {
                                
                                console.log("Element found in Object ", jQueryArray[i].name + " -> " + name);
                                
                                isElExists = true;
                                
                                if ((this.type === "radio" || this.type === "checkbox")) {
                                    if (this.checked) {
                                        jQueryArray[i].value.push(this.value)
                                    }
                                    
                                } else {
                                    
                                    try {
                                        jQueryArray[i].value.push(this.value)
                                    } catch (e) {
                                        console.log("Problem For", this.nodeName + " " + this.value + " " + e.message);
                                    }
                                    
                                }
                                
                            }
                            
                        }
                        
                        if (!isElExists) {
                            
                            // Add first one
                            
                            console.log("Element not found Adding first element !");
                            
                            _ = {
                                "name": name,
                                "type": this.type
                            };
                            
                            if ((this.type === "radio" || this.type === "checkbox")) {
                                _.value = this.checked ? [this.value] : []
                                
                            } else {
                                if (this.type === "hidden") {
                                    _.value = [this.value];
                                } else {
                                    _.value = this.value;
                                }
                            }
                            
                            jQueryArray.push(_);
                            
                            
                        } else {
                            console.log("Element already added in Object !");
                        }
                        
                        
                    }
                    
                    
                    else {
                        
                        
                        // console.log("Checkbox Single", this.name);
                        if (this.hasAttribute("required") && (!this.hasAttribute("disabled") || !this.classList.contains("disabled") )) {
    
                            // alert(name + " " + this.nodeName);
                            
                            try{
    
                                if (this.type === "radio" || this.type === "checkbox") {
    
                                    /*if (!this.checked) {
                                        error = true;
        
                                    } else {
        
                                        _ = {
                                            name: this.name,
                                            type: this.type,
                                            value: this.checked
                                        };
        
                                        jQueryArray.push(_);
        
        
                                    }*/
    
                                    // alert("Göründü");
                                    _ = {
                                        name: this.name,
                                        type: this.type,
                                        value: this.checked
                                    };
    
                                    jQueryArray.push(_);
        
                                } else {
    
                                    
                                    if ( this.value.trim() === "" ) {
                                        // return false;
                                        // console.log("Form will stop for ", this.name);
                                        error = true;
                                        // this.style.borderColor = "red";
                                        
            
                                    } else {
            
                                        if (this.hasAttribute === "invalid") {
                
                                            error = true;
                                            alert("invalid");
                
                                        } else {
                
                                            _ = {
                                                name: this.name,
                                                type: this.type,
                                                value: this.value
                                            };
                
                                            jQueryArray.push(_);
                
                                        }
            
                                    }
        
        
                                }
                                
                                
                                
                            } catch (e) {
                                alert(e.message + "\n\n" + e.stack );
                            }
                            
                            
                        } else {
    
                            
                            try {
                                
                                _ = {
                                    "name": this.name,
                                    "type": this.type
                                };
                                
                                if ( this.type === "radio" || this.type === "checkbox") {
                                    _.value = this.checked;
                                } else {
                                    _.value = this.value.trim().length ? this.value : null;
                                }
                                
                                jQueryArray.push(_);
                                
                                if (this.type !== "hidden") {
                                    this.nextElementSibling.style.borderColor = "";
                                }
                            } catch (e) {
                                // alert(e.message);
                            }
    
                            
                        }
                        
                    }
                    
                    
                    // this.onclick = function (El) {
                        // El.target.style.borderColor = "";
                    // }
                    
                });
            
            
        } else {
            alert("Object must be [" + acceptNode.join(", ") + "] element!");
            return false;
        }
    
        // return false;
        
        console.log("jQueryArray", jQueryArray);
        
        
        let new_arr = {};
        for (let i = 0; i < jQueryArray.length; i++) {
            
            let totalElInForm = 1;
            if (typeof jQueryArray[i].value === "object" && jQueryArray[i].value !== null) {
                
                // Total El in form
                
                totalElInForm = document.getElementsByName(jQueryArray[i].name + "[]");
                if (totalElInForm.length && !jQueryArray[i].value.length) {
                    // alert(1232);
                    console.log("Error for Required checkbox", jQueryArray[i].name);
                    document.getElementsByName(jQueryArray[i].name + "[]").forEach(function (El) {
                        
                        if (El.type !== "hidden") {
                            
                            El.nextElementSibling.style.borderColor = "red";
                            El.onclick = function () {
                                document.getElementsByName(jQueryArray[i].name + "[]").forEach(function (El) {
                                    El.nextElementSibling.style.borderColor = "";
                                });
                            }
                            
                        }
                        
                    });
                    error = true;
                } else {
                    document.getElementsByName(jQueryArray[i].name + "[]").forEach(function (El) {
                        
                        if (El.type !== "hidden") {
                            El.nextElementSibling.style.borderColor = "";
                        }
                        
                    });
                    
                }
                
            }
            
            // console.log("Type of Value -> ", jQueryArray[i].name + " " + typeof jQueryArray[i].value + " Total:"+ totalElInForm );
            
            
            new_arr[jQueryArray[i].name] = jQueryArray[i].value;
            // }
        }
        
        console.log("new_arr", new_arr);
        
        // alert(JSON.stringify(new_arr));
        if (error) {
            
            if (undefined !== callback && "function" === typeof callback) {
                console.log("Form No Array");
    
                callback.call(new_arr, error);
                
                setTimeout(function () {
                    requiredElements[0].focus();
                    requiredElements = [];
                },300);
                
                /*
    
                for(let i in requiredElements){
                    if( requiredElements[i].value === "" ){
                        requiredElements[i].focus();
                        requiredElements[i].focus();
                        break;
                    }
                }*/
                
                return false;
            }
            
        }
        
        if (undefined !== callback && "function" === typeof callback) {
            callback.call(new_arr, false);
        }
        
        
        return new_arr;
        
        
    };
    
    // Not Finish, For Every Request
    this.HttpRequest = function (animate) {
        
        
        let HttpRequest = this;
        HttpRequest.cnt = "";
        HttpRequest.nsp = "!";
        HttpRequest.mtd = "";
        HttpRequest.data = {};
        HttpRequest.URL = "";
        HttpRequest.contentType = "json";
        HttpRequest.requestAnimate = undefined === animate ? false : animate;
        HttpRequest.activityIndicator = null;
        HttpRequest.completedCallback = function () {
        };
        // HttpRequest.l = new $.tsoftx.loader();
        HttpRequest.processWithSession = true;
        HttpRequest.setErrorCallback = function (request, status, error) {
        };
        HttpRequest.sessionExpiredCallback = function () {
        };
        HttpRequest.beforeSendCallback = function () {
        };
        HttpRequest.setContentType = function (contentType) {
            HttpRequest.contentType = contentType;
            return HttpRequest;
        }
        HttpRequest.getContentType = function () {
            return HttpRequest.contentType;
        }
        
        /**
         * set the external Indicator
         * @param indicator Indicator Object
         * @returns {HttpRequest}
         */
        HttpRequest.setActivityIndicator = function (indicator) {
            this.activityIndicator = indicator;
            return this;
        };
        
        /**
         * Get ActivityIndicator Success Ich setted the outside Indicator with setActivityIndicator Method
         * @returns Indicator Object
         */
        HttpRequest.getActivityIndicator = function () {
            return this.activityIndicator;
        };
        
        /**
         * this Method Create And Run Animate Before Request send
         * @returns {HttpRequest}
         */
        HttpRequest.setLocalActivityIndicator = function () {
            this.activityIndicator = X2.ActivityIndicator();
            return this;
        };
        
        /**
         * @param val Boolean -> with true Forward the execute to animate method
         * @returns {HttpRequest}
         */
        HttpRequest.setRequestWithAnimate = function (val) {
            this.requestAnimate = val;
            return this;
        };
        /**
         * Return Boolean Using by Execute operation
         * @returns {*}
         */
        HttpRequest.getRequestWithAnimate = function () {
            return this.requestAnimate;
        };
        
        
        /**
         * Request Controller
         */
        HttpRequest.setController = function (val) {
            this.cnt = val;
            return this;
        };
        
        /**
         * Request Namespace default !
         */
        HttpRequest.setNamespace = function (val) {
            this.nsp = val;
            return this;
        };
        
        /**
         * Request Method
         */
        HttpRequest.setMethod = function (val) {
            this.mtd = val;
            return this;
        };
        
        /**
         * Send Parameter for Request with method
         */
        HttpRequest.setData = function (arrData) {
            
            if (typeof arrData === "string") {
                arrData = JSON.parse(arrData);
            }
            this.data = arrData;
            return this;
        };
        
        /**
         * Set Completed Callback
         * @param callback
         * @returns {X2Tools}
         */
        HttpRequest.setCompletedCallback = function (callback) {
            this.completedCallback = callback;
            return this;
        };
        
        /**
         * Get Completed Callback
         */
        HttpRequest.getCompletedCallback = function () {
            return this.completedCallback();
        };
        
        /**
         * Request Execute
         *
         * Need check From 835 Line
         * than ready for check
         */
        HttpRequest.execute = function (callback) {
            
            
            // Create URL
            this.URL = "/" + this.cnt + "/" + this.nsp + "/" + this.mtd;
            
            // Add Default Data
            // alert(HttpRequest.getContentType());
            this.data.output = HttpRequest.getContentType();
            
            // Spinner
            if (this.getRequestWithAnimate()) {
                
                return this.executeWithAnimation(callback)
                
            }
            
            X2.log("Request Executed With URL" + this.URL);
    
    
            /**
             * Function witout session check while
             * Alnlamsiz bi sekilde
             * Session siliniyor
             * sanirim cok fazla attack var
             */
            run();
            
            function run(){
    
                try {
        
                    if( null !== HttpRequest.activityIndicator ){
                        HttpRequest.activityIndicator.show(function () {
                            f();
                        })
                    } else {
                        f();
                    }
        
        
        
                    function f() {
                        $.ajax({
                            method: "POST",
                            url: HttpRequest.URL,
                            data: HttpRequest.data,
                            beforeSend: function () {
                                HttpRequest.beforeSendCallback();
                            },
                            complete: function () {
                    
                                // Indicator dismiss when active
                                if (null !== HttpRequest.getActivityIndicator()) {
                                    HttpRequest.getActivityIndicator().dismiss();
                                }
                                HttpRequest.getCompletedCallback();
                    
                            },
                            success: function (dt) {
                    
                                console.log("TEMPORARY AJAX RESULTA,", dt);
                    
                                /*ac = new $.tsoftx.alert(1022);
                                ac
                                    .setTitle("Function Error")
                                    // .setType("danger")
                                    .setMessage(dt)
                                    .cancelAction("text", "Close")
                                    .show(function () {
            
                                    });*/
                                
                                
                                // alert(dt);
                    
                                try {
                                    if (typeof dt === "string" && JSON.parse(dt)) {
                                        dt = JSON.parse(dt);
                                    }
                                    callback.call(dt["data"][0]);
                        
                                } catch (e) {
                        
                                    // alert(e.message);
                        
                                    let ac;
                                    if (X2.fromDevice()) {
                            
                                        /*ac = new X2.AlertController();
                                        ac.setMessage(dt);
                                        ac.setTitle("Critical Error");
                                        ac.addAction({
                                            title: "Ok",
                                            action: "", // Reload App
                                            style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                                        });
                                        ac.show();*/
                            
                                        // alert(JSON.stringify(dt));
                            
                                        X2.presentErrorViewControllerWithErrorContent("JS HttpRequest",false, dt );
                            
                            
                            
                            
                            
                                    } else {
                            
                                        // Browser Alert
                                        let ac = new $.tsoftx.alert(1015);
                                        ac
                                            .setTitle("Function Error")
                                            .setType("warning")
                                            .setMessage(JSON.stringify(dt) + "<br /> " + e.message)
                                            .cancelAction("text", "Close")
                                            .show(function () {
                                    
                                            });
                                    }
                                }
                    
                    
                                function sendReport(string) {
                        
                                    // let httpRequest = X2.HttpRequest();
                        
                        
                                }
                    
                    
                            },
                            error: function (request, status, error) {
                    
                                if (null !== HttpRequest.getActivityIndicator()) {
                                    HttpRequest.getActivityIndicator().dismiss();
                                }
                                alert("HttpRequest, error" + " " + error);
                    
                                // console.log(request, status, error);
                                if( X2.getLastOpenedActivityIndicator() !== null ){
                                    X2.getLastOpenedActivityIndicator().dismiss();
                                }
                    
                                X2.presentErrorViewControllerWithErrorContent(request, status, error);
                    
                                HttpRequest.setErrorCallback(request, status, error);
                            },
                            fail: function (jqXHR, textStatus, errorThrown) {
                    
                                if (null !== HttpRequest.getActivityIndicator()) {
                                    HttpRequest.getActivityIndicator().dismiss();
                                }
                    
                                alert("HttpRequest, fail" + " " + jqXHR);
                            }
                        });
                    }
        
        
        
        
        
        
                }
    
                catch (e) {
        
                    // if( null !== HttpRequest.getActivityIndicator() ){
                    //     HttpRequest.getActivityIndicator().dismiss();
                    // }
        
        
                    let ac;
                    if (X2.fromDevice()) {
            
                        ac = new X2.AlertController();
                        ac.setMessage(e.message);
                        ac.setTitle("HttpRequest");
                        ac.addAction({
                            title: "Ok",
                            action: "", // Reload App
                            style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                        });
                        ac.show();
            
                    } else {
            
            
                        // Browser Alert
                        try {
                
                            ac = new $.tsoftx.alert(1022);
                            ac
                                .setTitle("Function Error")
                                // .setType("danger")
                                .setMessage(e.message)
                                .cancelAction("text", "Close")
                                .show(function () {
                        
                                });
                
                        } catch (e) {
                
                            alert(e.message);
                
                
                        }
                    }
                }
                
            }
            
            
            
            
            // Process with Session
            /**
             * Deprecated
             * Anlamsiz bir sekilde
             * Session siliniyor
             * Ve cok fazla attack oluyor
             *
             */
            
            /*
            X2.session(function (active)
            {
                
                // Log
                X2.log("Request Session is:[" + active + "] Request absolute With Session:[" + HttpRequest.getProcessWithSession() + "]");
                
                if (!active && HttpRequest.getProcessWithSession()) {
                    
                    let ac;
                    if (X2.fromDevice()) {
                        
                        ac = new X2.AlertController();
                        ac.setMessage("Session expired");
                        ac.setTitle("Warning");
                        ac.addAction({
                            title: "Ok",
                            action: "", // Reload App
                            style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                        });
                        ac.show();
                        
                    } else {
                    
                        
                        
                    }
                    
                    
                } else {
                    
                    
                    try {
                        
                        if( null !== HttpRequest.activityIndicator ){
                            HttpRequest.activityIndicator.show(function () {
                                f();
                            })
                        } else {
                            f();
                        }
                        
                        
                        
                        function f() {
                            $.ajax({
                                method: "POST",
                                url: HttpRequest.URL,
                                data: HttpRequest.data,
                                beforeSend: function () {
                                    HttpRequest.beforeSendCallback();
                                },
                                complete: function () {
            
                                    // Indicator dismiss when active
                                    if (null !== HttpRequest.getActivityIndicator()) {
                                        HttpRequest.getActivityIndicator().dismiss();
                                    }
                                    HttpRequest.getCompletedCallback();
            
                                },
                                success: function (dt) {
            
                                    console.log("TEMPORARY AJAX RESULTA,", dt);
            
                                    // ac = new $.tsoftx.alert(1022);
                                    // ac
                                    //     .setTitle("Function Error")
                                    //     // .setType("danger")
                                    //     .setMessage(dt)
                                    //     .cancelAction("text", "Close")
                                    //     .show(function () {
                                    //
                                    //     });
            
                                    try {
                                        if (typeof dt === "string" && JSON.parse(dt)) {
                                            dt = JSON.parse(dt);
                                        }
                                        callback.call(dt["data"][0]);
                
                                    } catch (e) {
                
                                        // alert(e.message);
                
                                        let ac;
                                        if (X2.fromDevice()) {
                    
                                            // ac = new X2.AlertController();
                                            // ac.setMessage(dt);
                                            // ac.setTitle("Critical Error");
                                            // ac.addAction({
                                            //     title: "Ok",
                                            //     action: "", // Reload App
                                            //     style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                                            // });
                                            // ac.show();
                                            
                                            // alert(JSON.stringify(dt));
                                            
                                            X2.presentErrorViewControllerWithErrorContent("JS HttpRequest",false, dt );
                                            
                                            
                                            
                                            
                    
                                        } else {
                    
                                            // Browser Alert
                                            let ac = new $.tsoftx.alert(1015);
                                            ac
                                                .setTitle("Function Error")
                                                .setType("warning")
                                                .setMessage(JSON.stringify(dt) + "<br /> " + e.message)
                                                .cancelAction("text", "Close")
                                                .show(function () {
                            
                                                });
                                        }
                                    }
            
            
                                    function sendReport(string) {
                
                                        // let httpRequest = X2.HttpRequest();
                
                
                                    }
            
            
                                },
                                error: function (request, status, error) {
            
                                    if (null !== HttpRequest.getActivityIndicator()) {
                                        HttpRequest.getActivityIndicator().dismiss();
                                    }
                                    // alert("HttpRequest, error" + " " + error);
            
                                    // console.log(request, status, error);
                                    if( X2.getLastOpenedActivityIndicator() !== null ){
                                        X2.getLastOpenedActivityIndicator().dismiss();
                                    }
                                    
                                    X2.presentErrorViewControllerWithErrorContent(request, status, error);
                                    
                                    HttpRequest.setErrorCallback(request, status, error);
                                },
                                fail: function (jqXHR, textStatus, errorThrown) {
            
                                    if (null !== HttpRequest.getActivityIndicator()) {
                                        HttpRequest.getActivityIndicator().dismiss();
                                    }
            
                                    alert("HttpRequest, fail" + " " + jqXHR);
                                }
                            });
                        }
                        
                        
                        
                        
                        
                        
                    }
                    
                    catch (e) {
                        
                        // if( null !== HttpRequest.getActivityIndicator() ){
                        //     HttpRequest.getActivityIndicator().dismiss();
                        // }
                        
                        
                        let ac;
                        if (X2.fromDevice()) {
                            
                            ac = new X2.AlertController();
                            ac.setMessage(e.message);
                            ac.setTitle("HttpRequest");
                            ac.addAction({
                                title: "Ok",
                                action: "", // Reload App
                                style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                            });
                            ac.show();
                            
                        } else {
                            
                            
                            // Browser Alert
                            try {
                                
                                ac = new $.tsoftx.alert(1022);
                                ac
                                    .setTitle("Function Error")
                                    // .setType("danger")
                                    .setMessage(e.message)
                                    .cancelAction("text", "Close")
                                    .show(function () {
                                    
                                    });
                                
                            } catch (e) {
                                
                                alert(e.message);
                                
                                
                            }
                        }
                    }
                    
                    
                }
                
                
                
                
            });
            */
            
            
            return HttpRequest;
            
        };
        
        
        /**
         * @deprecated
         * @returns {X2Tools}
         */
        HttpRequest.executeWithAnimation = function () {
            
            HttpRequest.data.output = "json";
            
            /*let ai = new L.ActivityIndicator();
            
            ai.show(function () {
    
                try {
        
                    $.ajax({
                        method: "POST",
                        url: url,
                        data: HttpRequest.data,
                        beforeSend: function () {
                
                            HttpRequest.beforeSendCallback();
                        },
                        complete: function () {
                            ai.dismiss();
                        },
                        success: function (dt) {
                
                
                            console.log("TEMPORARY AJAX RESULTA,", dt);
                
                            try {
                    
                                // ai.dismiss();
                    
                                if (typeof dt === "string" && JSON.parse(dt)) {
                                    dt = JSON.parse(dt);
                                }
                                callback.call(dt);
                    
                    
                            } catch (e) {
                    
                                let ac = new $.tsoftx.alert(1038);
                                ac
                                    .setTitle("Function Error")
                                    .setType("danger")
                                    .setMessage(dt + "<br />" + e.message)
                                    .cancelAction("text", "Close")
                                    .show(function () {
                                        ai.dismiss();
                                    });
                    
                    
                                HttpRequest.setErrorCallback(dt, dt, dt);
                    
                            }
                        },
                        error: function (request, status, error) {
                            console.log(request, status, error);
                            HttpRequest.setErrorCallback(request, status, error);
                            ai.dismiss();
                        },
                        fail: function (jqXHR, textStatus, errorThrown) {
                            alert(jqXHR);
                            ai.dismiss();
                        }
                    });
        
        
                }
                
                catch (e) {
                    console.log(e);
                }
                
                
                
            });*/
            
            
            return HttpRequest;
            
        }
        
        /**
         * @deprecated
         * @param callback
         * @returns {X2Tools}
         */
        HttpRequest.error = function (callback) {
            
            
            if (undefined !== callback && typeof callback === "function") {
                HttpRequest.setErrorCallback = callback;
            }
            
            return HttpRequest;
            
        };
        
        
        /**
         * @deprecated
         * @param callback
         * @returns {X2Tools}
         */
        HttpRequest.s_expired = function (callback) {
            
            if (undefined !== callback && typeof callback === "function") {
                this.sessionExpiredCallback = callback;
            }
            
            return this;
            
        };
        
        this.setProcessWithSession = function (val) {
            this.processWithSession = val;
            return this;
        };
        
        this.getProcessWithSession = function () {
            return this.processWithSession;
        };
        
        this.beforeSend = function (callback) {
            
            if (undefined !== callback && typeof callback === "function") {
                HttpRequest.beforeSendCallback = callback;
            }
            return HttpRequest;
            
        };
        
        
        return this;
        
    };
    
    this.session = function (callback) {
        
        let url = "/_Public/!/sessionUser";
        
        X2.ConnectivityManager(url, function (connected) {
            
            if (connected) {
                
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
                            
                            X2.log("Session Data from Backend:" + dt.data);
                            
                            callback(dt.data[0] > 0);
                        },
                        error: function (request, status, error) {
                            alert("Error");
                            console.log(status);
                        },
                        fail: function (jqXHR, textStatus, errorThrown) {
                            alert("Fail");
                            console.log(jqXHR);
                        }
                    });
                    
                } catch (e) {
                    console.log(e);
                }
                
                
            } else {
                
                if (DEVICE !== null) {
                    
                    let alert = new X2.AlertController();
                    alert.setTitle("Connection")
                        .setMessage("No Internet Connection")
                        .addAction({
                            title: "Ok",
                            action: "",
                            style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                        })
                        
                        /*.addAction({
                            title: "Report",
                            action: "javascript:$.tsoftx.developerReport('" + dt + "');",
                            style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault
                        })*/
                        .show();
                    
                    
                } else {
                    
                    // Browser Alert
                    
                    
                }
                
                
            }
            
            
        })
        
    };
    
    /**
     * @return {boolean}
     */
    this.ConnectivityManager = function (url, callback) {
        
        let connected = false;
        
        try {
            
            jQuery.ajaxSetup({async: false});
            // $.get(url, {subins: r}, function (d) {
            $.get(url, null, function (d) {
                connected = true;
            }).error(function (e) {
                connected = false;
            });
            
            if (undefined !== callback && "function" === typeof callback) {
                callback(connected);
            }
            
        } catch (e) {
            
            if (DEVICE !== null) {
                
                let alert = new X2.AlertController();
                alert.setTitle("ConnectivityManager")
                    .setMessage(e.message)
                    .addAction({
                        title: "Ok",
                        action: "",
                        style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                    })
                    
                    /*.addAction({
                        title: "Report",
                        action: "javascript:$.tsoftx.developerReport('" + dt + "');",
                        style: ALERT_ACTION_STYLE.UIAlertActionStyleDefault
                    })*/
                    .show();
                
                
            } else {
                
                // Browser Alert
                
                
            }
            
        }
        
        
        return connected;
    };
    
    // Not Finish, For every Action JQuery Based
    this.ActivityIndicator = function (withString) {
        
        let ActivityIndicator = this;
        let obj = null;
        
        
        ActivityIndicator.m = null;
        ActivityIndicator.le = null;
        ActivityIndicator.lt = null;
        let showInAnotherEl = false;
        ActivityIndicator.transparent = false;
        
        
        ActivityIndicator.bg = function () {
            
            ActivityIndicator.m = $("div#loader");
            if (!ActivityIndicator.m.length) {
                
                let $w = $("<div>");
                $w.attr("id", "loader");
                if (!ActivityIndicator.transparent) {
                    $w.addClass("modal fade");
                    $w.data("role", "loader");
                } else {
                    $w.addClass("modal-transparent");
                }
                document.getElementsByTagName("html")[0].appendChild($w[0]);
                ActivityIndicator.m = $w;
                
            }
            
            return ActivityIndicator.m;
            
        };
        
        // Transparent Loader
        ActivityIndicator.setTransparent = function () {
            
            // ActivityIndicator.m.css("background-color", "transparent", "important");
            ActivityIndicator.transparent = true;
            return this;
            
        };
        
        ActivityIndicator.loaderEl = function () {
            
            if (!ActivityIndicator.transparent) {
                let $c = new $("<div>");
                $c.addClass("tsoftx-loader");
                $c.attr("id", Math.floor(Math.random() * 99));
                ActivityIndicator.le = $c;
                return ActivityIndicator.le;
            }
            
        };
        
        ActivityIndicator.loaderText = function () {
            
            if (!ActivityIndicator.transparent) {
                /*let $c = new $("<div>");
                $c.addClass("tsoftx-loader-text");
                $c[0].innerText = withString;
                ActivityIndicator.lt = $c;*/
                
                let loaderTextElWrapper = document.createElement("div");
                let loaderTextEl = document.createElement("label");
                
                loaderTextElWrapper.classList.add("tsoftx-loader-text-wrapper");
                loaderTextEl.classList.add("tsoftx-loader-text");
                loaderTextEl.innerText = withString;
                
                loaderTextElWrapper.appendChild(loaderTextEl);
                
                ActivityIndicator.lt = loaderTextElWrapper;
                
                
                return ActivityIndicator.lt;
            }
            
        };
        
        ActivityIndicator.init = function () {
            this.bg().append(ActivityIndicator.loaderEl());
            if (undefined !== withString) {
                this.bg().append(ActivityIndicator.loaderText());
            }
        };
        
        ActivityIndicator.showIn = function (el) {
            showInAnotherEl = true;
            el.append($(ActivityIndicator.loaderEl()));
            
            $(ActivityIndicator.loaderEl()).css("margin-left", "").css("margin-right", "").css("margin-top", "");
        };
        
        ActivityIndicator.show = function (callback) {
            
            if (!ActivityIndicator.loaderExists()) {
                
                if (!showInAnotherEl) {
                    ActivityIndicator.init();
                }
                
                if (!ActivityIndicator.transparent) {
                    // $(ActivityIndicator.m).modal("show");
                    let s = $(ActivityIndicator.m).modal({
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
        
        ActivityIndicator.loaderExists = function () {
            return $("div").filter(function () {
                return $(this).data("role") === "loader";
            }).length;
        };
        
        ActivityIndicator.dismiss = function (callback) {
            
            
            if (!showInAnotherEl) {
                
                if (!ActivityIndicator.transparent) {
                    
                    $(ActivityIndicator.m).modal("hide");
                    setTimeout(function () {
                        $(ActivityIndicator.m).remove();
                        ActivityIndicator.loaderEl().remove();
                        if ($("body").find(".modal-backdrop").length) {
                            $("body").find(".modal-backdrop").remove();
                        }
                    }, 100);
                    
                } else {
                    ActivityIndicator.m.remove();
                }
                
                if (undefined !== callback && typeof callback === "function") {
                    callback();
                }
            } else {
                
                alert($(ActivityIndicator.le)[0]);
                ActivityIndicator.loaderEl().remove();
            }
            // showInAnotherEl = false;
            
        };
        
        // this.init();
        
        // $.tsoftx.loaderObj = cls;
        
        this.setLastOpenedActivityIndicator(ActivityIndicator);
        
        return this;
        
    };
    
    
    this.presentErrorViewControllerWithErrorContent = function (request, status, error) {
    
        let hr = new X2Tools().HttpRequest();
        hr
            .setController("Error")
            .setMethod("jsHttpRequestViewControllerData")
            // .setNamespace("!")
            .setData({
                message:error
            })
            .execute(function () {
            
                try{
                    X2.getLastOpenedActivityIndicator().dismiss();
                
                    new X2Tools().presentViewControllerWithData(this);
                } catch (e) {
                    alert(e.message);
                }
            })
        
        
    }
    
    /*
    * Mobile Original Alert Controller
    * */
    this.AlertController = function () {
        
        
        let AlertController = this;
        AlertController.title = "Title";
        AlertController.message = "Message";
        AlertController.textField = false;
        AlertController.actions = [];
        
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
        
        this.setWithTextField = function (value) {
            this.textField = value;
        }
        
        this.getWithTextField = function () {
            return this.textField;
        }
        
        this.getMessage = function () {
            return this.message;
        };
        
        this.addAction = function (action) {
            this.actions.push(action);
            return this;
        };
        
        this.getActions = function () {
            return this.actions;
        };
        
        this.show = function () {
            
            let dataJSON = {};
            dataJSON.title = AlertController.getTitle();
            dataJSON.message = AlertController.getMessage();
            dataJSON.actions = AlertController.getActions();
            dataJSON.withTextField = AlertController.getWithTextField();
            
            let dataJSONString = JSON.stringify(dataJSON);
            
            // alert(DEVICE + "://" + ACTIVITY.ACTIVITY_ALERT_VIEW + "?" + dataJSONString);
            
            location.href = DEVICE + "://" + ACTIVITY.ACTIVITY_ALERT_VIEW + "?" + dataJSONString;
            
            
        };
        
        
        return this;
        
    }
    
    /*
  * Mobile Original Alert Controller
  * */
    this.Vibrate = function () {
        location.href = DEVICE + "://" + ACTIVITY.ACTIVITY_VIBRATE + "?code=1103";
        return this;
    }
    
    this.Button = function (El, options) {
        
        let _class = this;
        this._options = Object.assign({
            click: function () {
            },
            touchWith: "start", /* start or end */
            touch: function () {
            },
            active: true
        }, options);
        
        this._touchstart = null;
        this._touchend = null;
        
        this.init = function () {
            
            
            this._touchstart = El.ontouchstart;
            this._touchend = El.ontouchend;
            
            if (!_class._options.active) {
                El.ontouchstart = function () {
                };
                El.ontouchend = function () {
                };
                El.ontouchmove = function () {
                };
                El.onmousedown = function () {
                };
                El.onmouseup = function () {
                };
                El.onclick = function () {
                };
                
                return false;
            }
            
            if (X2.fromDevice()) {
                
                
                El.ontouchstart = function () {
    
                    if( El.classList.contains("disabled")) return false;
                    
                    // Add First the class
                    El.classList.add("touched");
                    
                    // Trigger the custom event (optional)
                    if (null !== _class._touchstart) {
                        _class._touchstart();
                    }
                    
                    // Trigger the option event (optional)
                    if (_class._options.touchWith === "start") {
                        _class._options.touch(El)
                    }
                    
                };
                
                El.ontouchend = function () {
                    
                    if( El.classList.contains("disabled")) return false;
                    
                    setTimeout(function () {
                        
                        // Remove First the class
                        El.classList.remove("touched");
                        
                        // Trigger the custom event (optional)
                        if (null !== _class._touchend) {
                            _class._touchend();
                        }
                        
                        // Trigger the option event (optional)
                        if (_class._options.touchWith === "end") {
                            _class._options.touch(El)
                        }
                        
                    }, 100)
                };
                
            } else {
                
                El.onmousedown = function () {
                    
                    this.classList.add("touched");
                };
                El.onmouseup = function () {
                    setTimeout(function () {
                        El.classList.remove("touched");
                    }, 100)
                    
                };
                
                El.onclick = function () {
                    // _class._options.click(El);
                    _class._options.touch(El)
                };
                
            }
            
            return this;
            
        }
        
        this.property = function (selector, value) {
            
            if (El !== null) {
                
                switch (selector) {
                    
                    case "disabled":
                        
                        _class._options.active = !value;
                        
                        if (value) {
                            // El.removeAttribute(selector);
                            El.setAttribute(selector, selector);
                        } else {
                            El.removeAttribute(selector);
                            
                        }
                        break;
                    
                    case "enabled":
                        
                        _class._options.active = value;
                        
                        if (!value) {
                            El.setAttribute("disabled", "disabled");
                        } else {
                            El.removeAttribute("disabled");
                            
                        }
                        break;
                    
                }
                
            }
            
        };
        
        
        this.refresh = function (callback) {
            
            if (undefined !== callback && typeof callback === "function") {
                callback(El, _class)
            }
            
            return this;
            
        };
        
        if (undefined !== El && null !== El) {
            this.init();
        }
        
        
        return this;
    }
    
    this.autoload = function () {
        
        this
            .TableView();
        
        
    };
    
    this.setCookie = function (cname, cvalue, inMinute) {
        
        /*try{
            let stores = document.cookie;
            stores = stores.split(";");
            let objectCookie = [];
            for(let store in stores ){
                let s = stores[store].split("=");
                objectCookie.push([s[0]] + "=" + s[1]);
            }
            objectCookie.push( key + "=" + value );
            document.cookie = objectCookie.join(";");
            
        } catch (e) {
            alert(e.message);
        }*/
        
        let exdays = 10;
        let d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        if (inMinute !== undefined) {
            d.setTime(d.getTime() + (inMinute * 60 * 1000));
        }
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        
        // return this;
    };
    
    this.getCookie = function (cname) {
        
        /*let stores = document.cookie;
        stores = stores.split(";");
        let objectCookie = {};
        for(let store in stores ){
            let s = stores[store].split("=");
            objectCookie[s[0]] = s[1];
        }
        if( undefined !== key ){
            return objectCookie[key];
        }
        return objectCookie;*/
        
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    };
    
    
    this.log = function (k, m) {
        
        if (undefined !== m) {
            console.log(k, m);
            return false;
        }
        // Key As Message;
        m = k;
        console.log(m);
        
    };
    
    /**
     * Trigged with onblur
     * @param El
     * @returns {boolean}
     */
    this.validate = function (El) {
        
        
        if (undefined === El) {
            return false;
        }
        
        if (El.value === "") {
            El.parentNode.classList.remove("show"); // Like required
            El.removeAttribute("invalid");
            return false;
        }
        let valid = true;
        let pattern = "";
        
        switch (El.dataset.type) {
            
            case "email":
                
                pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                valid = null !== El.value.match(pattern);
                
                break;
            
            case "http":
                
                pattern = /https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,}/
                valid = null !== El.value.match(pattern);
                
                break;
        }
        
        if (!valid) {
            El.parentNode.classList.add("show"); // Like required
            El.setAttribute("invalid")
        } else {
            El.parentNode.classList.remove("show"); // Like required
            El.removeAttribute("invalid")
        }
        
        
    }
    
    
    this.autoload();
    
    
};