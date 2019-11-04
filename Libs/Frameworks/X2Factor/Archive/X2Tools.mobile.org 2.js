/*
 * Author          :suleymantopaloglu
 * File            :X2.Tools.ui.js
 * Product Name    :PhpStorm
 * Time            :15:45
 * Created at      :12.02.2019 15:45
 * Description     :X2 Smart Phone Tools
 */

let X2Tools = function () {
    
    let X2 = this;
    
    /*
    * Process From Device Requested
    * */
    this.fromDevice = function () {
        return typeof DEVICE !== undefined && typeof DEVICE !== null && DEVICE !== '';
    }
    
    this.TableView = function (Element, pars) {
        
        
        this.parameters = Object.assign({
            row: function (row, rows, ui) {
            },
            rows: function (rows, ui) {
            },
            search: function (TableViewEl, bodyRows, string, _class ) {
            },
            /*addRow:function( TableViewEl ){}*/
            // searchBar: false @deprecated instead of data-with attribute
        }, pars);
    
        
        
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
        
        
        this.init = function () {
            
            
            let moveEvent = false;
            
            let TableViewRow;
            let s = [];
            
            let bodyRows = [];
            
            // Find a Table View
            if ("undefined" === typeof TableView) {
                // Return a First Found Element
                TableView = document.querySelector("ul.x2-list");
                
                
            } else {
                
                try{
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
                    TableView.querySelector("li.x2-table-search") === null )
                {
                    
                    let searchBarWrapper = document.createElement("li");
                    searchBarWrapper.classList.add('section', 'x2-table-search');
                    
                    let searchBar = document.createElement("div");
                    searchBar.classList.add('d-table-cell');
                    
                    let searchBox = document.createElement("div");
                    searchBox.classList.add("w100");
                    
                    
                    let searchButton = document.createElement("button");
                    searchButton.classList.add("d-table-cell");
                    searchButton.innerText = "Search";
                    
                    searchButton.onclick = function () {
                        _class.parameters.search.call( searchEl.value, TableView, _class.TableRows, _class );
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
                
                
                _class.load();
                
            }
            
            
            return this;
            
        };
        
        this.load = function () {
    
            /**
             * Table Group Header
             * @type {null}
             */
            let groupHeader = null;
    
            /**
             * Cloned Row
             * @type {null}
             */
            let clonedRow   = null;
            
            
            let headerEl    = null;
            
            
            
            // Get All Rows
            _class.rows(function (rows) {
                
                
                try {
                    _class.parameters.rows(rows, _class);
                } catch (e) {
                    alert(e.message);
                }
                
                console.log("TableView Rows -------_> ", rows.length);
                
                for (let i = 0; i < rows.length; i++) {
                    
                    let row = rows[i];
                    
                    if (row.classList.contains("cell")) {
    
                        /**
                         * Row Group
                         */
                        function rowGroup(El){
    
                            // ADDED IN COMPANY
                            if( El.dataset.group !== undefined ){
        
                                // Find Exists Group Header
                                groupHeader = TableView.querySelector("li.section[data-group='" + El.dataset.group + "']");
                                // alert(groupHeader === null);
                                // Create group header
                                // alert(groupHeader);
                                if( groupHeader === null ) {
            
                                
                                    headerEl = document.createElement("li");
                                    headerEl.innerText = row.dataset.group;
                                    headerEl.dataset.group = row.dataset.group;
                                    headerEl.classList.add("section");
            
                                    TableView.append(headerEl);
    
                                    groupHeader = headerEl;
            
                                }
        
                                // Clone Row
                                clonedRow = row.cloneNode(true);
        
                                console.log("clonedRow", clonedRow);
                                
                                
        
                                // Find Cell in Group
                                let groupCell = TableView.querySelectorAll("li.cell[data-group='" + row.dataset.group + "']");
        
                                console.log("Element ", groupCell[ groupCell.length - 1 ].nextSibling);
        
                                if ( groupCell !== null ){
            
                                    TableView.insertBefore(clonedRow, groupCell[ groupCell.length - 1 ].nextSibling);
            
                                } else {
            
            
                                    // clonedRow.appendAfter(headerEl);
                                    if( null !== headerEl ){
                
                                        // TableView.insertAfter(clonedRow, headerEl);
                                        TableView.insertBefore(clonedRow, headerEl.nextSibling);
                
                                    }
                                }
                                row.remove();
                                
                                return  clonedRow;
                            }
                            
                            console.log("This", row);
                            
                            return row;
                        };
                        
                        row = rowGroup(row);
                        
                        // row row
                        // Children All Li Elements
                        // L ui All TableView Api
    
                       /* try{
    
                            let row_w = document.createElement("div");
                            row_w.classList.add("row-wrapper");
    
                            let row_b = document.createElement("div");
                            row_b.classList.add("row-body");
                            row_b.innerHTML = row.innerHTML;
    
                            let row_d = document.createElement("button");
                            row_d.classList.add("row-remove-button");
    
    
    
                            row_w.append(row_b);
                            row_w.append(row_d);
    
                            row.innerHTML = "";

                            row.append(row_w);
                            
                            row = row_b;
                            
                        } catch ( e ){
                        
                        
                        }*/
    
                        
                        
                        
                        
                        
                        
                        if( TableView.dataset !== undefined && ( undefined !== TableView.dataset.removeable || null !== TableView.dataset.removeable ) )  {
        
                        
        
                        }
                        
                        _class.parameters.row(row, rows, _class);
                        
                        console.log("TableView Row", row);
                        
                        _class.prepareTableRow(row);
                    }
                    
                }
                
                _class.TableRows = rows;
                
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
        
        this.addRow = function( row /*Indexed Array*/, callback){
    
            console.log(this.html);
            let _ = this;
            // Remove All Rows
            let rows = TableView.children.length;
            for(let i=0; i < rows ; i++){
        
                console.log("Row", i);
                let row = TableView.children[ TableView.children.length-1];
                if( row.classList.contains("cell") && !row.classList.contains("x2-table-search") ){
                    // row.remove();
                }
        
            }
    
            setTimeout(function () {
                try{
                    let rows = document.createRange().createContextualFragment(row);
                    TableView.append(rows);
                    
                    if( undefined !== callback && typeof callback === "function" ){
                        callback(_class);
                    }
                    
                }
                catch(e){
            
                }
            }, 10)
        
        
        
        };
        
        this.prepareTableRow = function (row) {
            
            
            let rowElements = row.children, label, input, select, moveEvent = false, targetEl = null;
    
            
            
            // Check With Subtitle
            if( undefined !== row.dataset.subTitle && !row.classList.contains("row-with-sub-title-created") ) {
    
                
                let subTitle = row.dataset.subTitle;
    
                // Check Row Has Label
                // data-sub-title
                let hasLabel    = row.querySelector("label:first-child");
                let hasSelect   = row.querySelector("select");
                let hasLink     = row.querySelector("a");
                
                console.log("hasLabel",hasLabel);
                
                // Set Default Target Element
                targetEl = row;
                
                
                // Check Has Label
                if( null !== hasLabel ){
                    targetEl = hasLabel;
                }
    
                // Check Has Select
                if( null !== hasSelect ){
                    targetEl = row;
        
                }
    
                // Check Has Select
                if( null !== hasLink ){
                    targetEl = hasLink;
                    
                }
                
    
                // Add New Content to Original Content
    
                // Create New Label Content with subTitle
                let labelNewContent         = document.createElement("div");
                labelNewContent.style.display = "table";
                labelNewContent.style.width = "100%";
    
                // labelNewContent Title
                let NewContentTitle    = document.createElement("span");
                NewContentTitle.style.display = "table-row";
                NewContentTitle.innerHTML = targetEl.innerHTML;
                
    
                // labelNewContent Title
                let NewContentSubTitle = document.createElement("span");
                NewContentSubTitle.style.display = "table-row";
                NewContentSubTitle.style.fontSize = "8px";
                NewContentSubTitle.innerText = subTitle;
    
    
                // Append All
                labelNewContent.append(NewContentTitle);
                labelNewContent.append(NewContentSubTitle);
    
                
    
                // Append to Row
                /*if( null !== hasSelect ){
                    
                    row.innerText = "";
                    row.append( labelNewContent );
                    
                } else if( null !== hasLink ){
    
                    alert(targetEl.nodeName)
                    targetEl.innerText = "";
                    targetEl.append(labelNewContent);
                    
                }*/
                targetEl.innerText = "";
                targetEl.append(labelNewContent);
                
                // set already created
                row.classList.add("row-with-sub-title-created");
                
                
            }
    
    
    
    
     
    
    
            
            
            
            // ACTION WITH A (To ViewController)
    
            /*let start = 0;
            row.ontouchstart = function(e){
                var touchObj = e.changedTouches[0]; // reference first touch point (ie: first finger)
                startx = parseInt(touchObj.clientX);
            }
            
            row.ontouchmove = function(e){
                row.innerText = "Moved:" + startx + " " + e.touches[0].clientX;
                row.style.marginLeft = -(startx - e.touches[0].clientX) + "px";
            };*/
    
    
            row.onmousemove = function(e){
                
                console.log("Cell Moved", e);
        
            }
            
            if (row.querySelector("a") !== null || row.querySelector("button") !== null) {
                
                
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
                if( !X2.fromDevice() ){
                    
                    if( null === actionElement.onclick ){
            
                        actionElement.onclick = function (e) {
                
                            alert("Click Event for Cell");
                            if (row.classList.contains("disabled")) return false;
                
                            if (null !== prevClickEvent) {
                                prevClickEvent();
                            }
                        };
            
                    }
                    
                    
                } else {
    
                    // TODO On Touch Start Event
                    if( actionElement.ontouchstart === null ){
        
                        actionElement.ontouchstart = function (e) {
    
                            
            
            
                            moveEvent = false;
                            if (row.classList.contains("disabled")) return false;
            
                            if (null !== prevTouchStartEvent) {
                                prevTouchStartEvent();
                            }
                            /*else {
                
                                if (this.dataset !== undefined && this.dataset.data !== undefined) {
                                    X2.presentViewControllerWithData(this.dataset.data);
                                }
                
                            }*/
            
                        };
        
                    }
    
                    // TODO On Touch End Event
                    if( actionElement.ontouchend === null ){
        
                        actionElement.ontouchend = function (e) {
            
                            // alert("TouchEnd Effect");
            
                            let El = this;
            
                            if (moveEvent) {
                                e.preventDefault();
                            } else {
                
                                if (row.classList.contains("disabled")) return false;
                
                                if (null !== prevTouchEndEvent) {
                                    // alert(prevTouchEndEvent);
                                    prevTouchEndEvent();
                                }
                                else {
                    
                                    if (this.dataset !== undefined && this.dataset.data !== undefined) {
                                        setTimeout(function () {
                                            X2.presentViewControllerWithData(El.dataset.data);
                                        }, 100);
                                    }
                    
                                }
                
                                e.preventDefault();
                            }
                        }
        
                    }
    
    
                    // TODO On Touch Move Event
                    if( actionElement.ontouchmove === null ){
        
                        actionElement.ontouchmove = function (e) {
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
                    return false;
                }
                
                let hasCheck = false;
                let hasRadio = false;
                let hasSwitch = false;
                let hasButton = false;
                
                
                for (let i = 0; i < rowElements.length; i++) {
                    
                    switch (rowElements[i].nodeName) {
                        
                        case "INPUT":
                            
                            
                            input = rowElements[i];
                            // console.log(input);
    
                            console.log("Input-->", input);
                            
                            if (row.classList.contains("required")) {
                                input.setAttribute("required", "required");
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
    
                                    
                                    console.log("Active");
                                    
                                    /*input.onfocus = function () {
                                        this.type="date";
                                    };*/
                                    
                                    /*input.onblur = function () {
                                        if( this.value === "" ){
                                            window.getComputedStyle(this, ":before").setPropertyValue("display", "none");
                                        }
                                    };*/
                                    
                                    /*input.onchange = function () {
                                        if( this.value === "" ){
                                            alert("Bios");
                                            this.type = "text";
                                        }
                                    };*/
    
                                    // input.type="text";
                                    
                                    break;
                            }
                            
                            break;
                        
                        case "BUTTON":
                            
                            hasButton = true;
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
                            select = rowElements[i];
                            console.log("Select El", select);
                            break;
                        
                        case "LABEL":
                            label = rowElements[i];
                            console.log("Label", label);
                            break;
                    }
                    
                }
                
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
                    
                }
                
                else {
                
                }
                
                console.log("row Switch", row.classList);
                
                /*
                * row Check is if(Tab over row this row is checked and present it with icon)
                * */
                if (hasRadio || hasCheck) {
                    
                    
                    if (!input.hasAttribute("disabled") && undefined !== label) {
                        
                        label.ontouchmove = function (e) {
                            moveEvent = true;
                            // console.log("Event", "ontouchmove" );
                        };
                        label.ontouchstart = function (e) {
                            moveEvent = false
                            console.log("Event", "ontouchstart");
                        };
    
                        label.removeEventListener("click", function () {});
                        
                        label.onclick = function (e) {
                            moveEvent = false;
                        };
                        
                        label.ontouchend = function (e) {
                            
                            if (moveEvent) {
                                e.preventDefault();
                            } else {
                                _class.switchRowEvent(TableView, row, this, e);
                            }
                            setTimeout(function () {
                                moveEvent = false;
                            }, 10);
                        }
                        
                    }
                    
                    
                }
                
                else if (hasButton) {
                    
                    let prevClickEvent = input.onclick;
                    let prevTouchEndEvent = input.ontouchend;
                    let prevTouchStartEvent = input.ontouchstart;
                    input.ontouchmove = function (e) {
                        moveEvent = true;
                    };
                    
                    // 1. Trigger ontouchstart Event (is exists) ( Ignore touchend if exists and click if exists )
                    input.ontouchstart = function (e) {
                        moveEvent = false;
                        
                        if (!this.hasAttribute("disabled") && null !== prevTouchStartEvent) {
                            prevTouchStartEvent();
                            e.preventDefault();
                        }
                    };
                    
                    // 2. Trigger ontouchend Event (is exists) ( If touchstart not exists Ignore click event if exists )
                    input.ontouchend = function (e) {
                        
                        if (!moveEvent && !this.hasAttribute("disabled") ) {
                            
                            // alert(prevTouchEndEvent);
                            
                            if( null !== prevTouchEndEvent ){
                                
                                prevTouchEndEvent();
                                e.preventDefault();
                                
                            } else {
    
                                // Input Type button zaten click event kapali
                                // if (row.classList.contains("disabled")) return false;
    
                                // alert(this.dataset.data);
                                if (this.dataset !== undefined && this.dataset.data !== undefined) {
                                    X2.presentViewControllerWithData(this.dataset.data);
                                }
    
                                e.preventDefault();
                                
                            }
                            
                            
                        }
                    };
                    
                    // 3. Trigger onclick Event (is exists) ( If touchstart not exists && click event not exists )
                    input.onclick = function (e) {
                        moveEvent = false;
                        console.log("Button click Event", prevClickEvent);
                        
                        if (!this.hasAttribute("disabled") && null !== prevClickEvent) {
                            prevClickEvent();
                            e.preventDefault();
                        }
                        
                    };
                    
                    
                }
                
                else if (hasSwitch /*|| row.classList.contains("switch")*/) {
                    
                    // Add Custom Switch Class For row
                    row.classList.add("switch");
                    
                    
                    console.log("row Switch", row);
                    // Find Switch
                    for (let d = 0; d < row.children.length; d++) {
                        
                        let _switch = undefined;
                        console.log("Switch Elements", row.children[d].classList);
                        if (row.children[d].classList.contains("switch")) {
                            _switch = row.children[d];
                        }
                        console.log("Found Switch Element", _switch);
                        
                        if (undefined !== _switch) {
                            
                            let _switchElements = row.children[d].children;
                            console.log("Found Switch Elements", _switchElements);
                            for (let k = 0; k < _switchElements.length; k++) {
                                
                                if (_switchElements[k].nodeName === "LABEL") {
                                    label = _switchElements[k];
                                    console.log("Target Switch Element", label);
                                }
                                
                            }
                            
                        }
                        
                    }
                    
                    label.ontouchmove = function (e) {
                        moveEvent = true;
                        // console.log("Event", "ontouchmove" );
                    };
                    label.ontouchstart = function (e) {
                        
                        X2.Vibrate();
                        label.click();
                        moveEvent = false;
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
                
                else {
                    
                    // Text, Textarea etc.
                    row.onclick = function (e) {
                        
                        let clickableEl = ["text", "password", "email", "time", "month", "number", "search", "tel", "color", "date"];
                        
                        for (let i = 0; i < rowElements.length; i++) {
                            
                            if (rowElements[i].nodeName === "INPUT") {
                                
                                if (row.classList.contains("in") && !row.classList.contains("disabled")) {
                                    row.classList.toggle("in");
                                }
                                
                                
                                if (clickableEl.indexOf(rowElements[i].type) > -1) {
                                    rowElements[i].focus();
                                    break;
                                }
                                
                                
                            }
                            
                            
                        }
                        
                        e.preventDefault();
                    }
                    
                }
                
                
            }
            
            
        };
        
        
        this.rowProperty = function (selector, rows /* Array Elements */, value) {
            
            console.log("rowProperty", rows);
            
            switch (selector) {
                
                case "disabled":
                    
                    rows.forEach(function (El) {
                        
                        console.log("rowProperty", El);
                        
                        if (value) {
                            
                            if (!El.classList.contains("disabled")) {
                                
                                El.classList.add("disabled");
                                
                                El.querySelectorAll("INPUT").forEach(function (E) {
                                    E.setAttribute("disabled", "disabled");
                                });
                                
                            }
                            
                        } else {
                            
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
                            
                            row.classList.remove("cell-active");
                            if (input.checked) {
                                row.classList.add("cell-active");
                            }
                            break;
                        
                        case "radio":
                            if (input.checked) {
                                
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
    
            this.init();
            
            if( undefined !== callback && typeof callback === "function" ){
                callback(TableView, _class);
    
            } else {
            
            
            }
            
            
            return this;
        };
        
        
        return this;
        
    };
    
    this.presentViewControllerWithData = function (data) {
        
        let dataJSONString = typeof data === "string" ? data : JSON.stringify(data);
        let parsedData = typeof data === "string" ? JSON.parse(data) : data;
        
        // ViewController
        let activity = parsedData.activity !== undefined && null !== parsedData ? parsedData.activity : ACTIVITY.ACTIVITY_1;
        location.href = DEVICE + "://" + activity + "?" + dataJSONString;
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
                data = "";
                location.href = DEVICE + "://" + ACTIVITY.ACTIVITY_UNWIND;
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
                        
                        
                    }
                    
                    else {
                        
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
                    
                    
                }
                
                
                else {
                    
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
        // let checkElements = ["checkbox", "radio"];
        
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
    
    
                if (name.indexOf("[]") > -1) {
        
                    name = name.replace(/[[]]/g, '');
        
                    console.log("Checkbox Multiple", name);
        
                    let isElExists = false;
                    for (let i = 0; i < jQueryArray.length; i++) {
                        
                        if (jQueryArray[i].name === name) {
                
                            console.log("Element found in Object ", jQueryArray[i].name + " -> " + name);
                            
                            isElExists = true;
                            
                            if ( ( this.type === "radio" || this.type === "checkbox" ) )
                            {
                                if( this.checked )
                                {
                                    jQueryArray[i].value.push(this.value)
                                }
                            
                            }
                            else {
                               
                                try{
                                    jQueryArray[i].value.push(this.value)
                                } catch(e){
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
    
                        if ( (this.type === "radio" || this.type === "checkbox") )
                        {
                            _.value = this.checked ? [this.value] : []
                            
                        }
                        else {
                            if( this.type === "hidden" ){
                                _.value = [this.value];
                            }
                            else {
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
                    if (this.hasAttribute("required") ) {
            
                        
                        if( this.type === "radio" || this.type === "checkbox" ){
                            
                            if(  !this.checked ){
    
                                console.log("Form will stop for ", this.name);
                                this.nextElementSibling.style.borderColor = "red";
                                this.nextElementSibling.onclick = function (El) {
                                    El.target.style.borderColor = "";
                                };
    
                                error = true;
                            }
                            
                            else {
    
                                _ = {
                                    name:this.name,
                                    type: this.type,
                                    value:this.checked
                                };
    
                                jQueryArray.push(_);
                                
                            }
                            
                        }
                        
                        else {
                            
                            if(  !this.value  ){
    
                                console.log("Form will stop for ", this.name);
                                error = true;
                                this.style.borderColor = "red";
                                
                            } else {
    
                                _ = {
                                    name:this.name,
                                    type: this.type,
                                    value:this.checked
                                };
    
                                jQueryArray.push(_);
                                
                            }
                            
                            
                            
                        }
                     
            
                    } else {
    
                        // alert(this.value);
                        _ = {
                            "name": this.name,
                            "type": this.type
                        };
                        
                        if ((this.type === "radio" && this.checked) || this.type === "checkbox") {
                            
                            _.value = this.checked;
                        
                        }
                        else {
                            
                            
                            _.value = this.value !== "" ? this.value : null;
                            
                        }
            
            
                        jQueryArray.push(_);
                        
                        
                        try {
                            if( this.type !== "hidden" ){
                                this.nextElementSibling.style.borderColor = "";
                            }
                        } catch (e) {
                
                        }
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
                        
                        if( El.type !== "hidden" ){
                            
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
                        
                        if( El.type !== "hidden" ){
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
    
    
    // Not Finish, For Every Request
    this.HttpRequest = function (animate) {
        
        
        let HttpRequest = this;
        HttpRequest.cnt = "";
        HttpRequest.nsp = "!";
        HttpRequest.mtd = "";
        HttpRequest.data = {};
        HttpRequest.URL = "";
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
            this.activityIndicator = $.tsoftx.loader();
            this.activityIndicator.show();
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
            this.data.output = "json";
            
            // Spinner
            if (this.getRequestWithAnimate()) {
                
                return this.executeWithAnimation(callback)
                
            }
            
            X2.log("Request Executed With URL" + this.URL);
            
            // Process with Session
            X2.session( function (active) {
                
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
                        
                        /*ac = new $.tsoftx.alert();
                        ac.setMessage(dt.data[0].message)
                        ac.setTitle("Error");
                        ac.show();*/
                        
                        // Browser Alert
                        // Reload Window
                        
                        
                    }
                    
                    
                } else {
                    
                    // Process 332;
                    
                    try {
                        
                        
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
                                
                                
                                try {
                                    if (typeof dt === "string" && JSON.parse(dt)) {
                                        dt = JSON.parse(dt);
                                    }
                                    callback.call(dt["data"][0]);
                                    
                                } catch (e) {
                                    
                                    
                                    let ac;
                                    if (X2.fromDevice()) {
                                        
                                        ac = new X2.AlertController();
                                        ac.setMessage(dt);
                                        ac.setTitle("Function Error");
                                        ac.addAction({
                                            title: "Ok",
                                            action: "", // Reload App
                                            style: ALERT_ACTION_STYLE.UIAlertActionStyleDestructive
                                        });
                                        ac.show();
                                        
                                    } else {
                                        
                                        // Browser Alert
                                        let ac = new $.tsoftx.alert(1015);
                                        ac
                                            .setTitle("Function Error")
                                            .setType("warning")
                                            .setMessage(JSON.stringify(dt) + "<br /> "+ e.message)
                                            .cancelAction("text", "Close")
                                            .show(function () {
                                            
                                            });
                                    }
                                }
                            },
                            error: function (request, status, error) {
                                
                                if (null !== HttpRequest.getActivityIndicator()) {
                                    HttpRequest.getActivityIndicator().dismiss();
                                }
                                alert("HttpRequest, error" + " " + error);
                                
                                console.log(request, status, error);
                                HttpRequest.setErrorCallback(request, status, error);
                            },
                            fail: function (jqXHR, textStatus, errorThrown) {
                                
                                if (null !== HttpRequest.getActivityIndicator()) {
                                    HttpRequest.getActivityIndicator().dismiss();
                                }
                                
                                alert("HttpRequest, fail" + " " + jqXHR);
                            }
                        });
                        
                        
                    } catch (e) {
                        
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
    
    this.session = function ( callback ) {
    
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
                
                
            }
            
            else {
                
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
    this.ActivityIndicator = new function () {
        
        let ActivityIndicator = this;
        let obj = null;
        
        this.vers = 1.2;
        ActivityIndicator.m = null;
        ActivityIndicator.le = null;
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
        
        ActivityIndicator.init = function () {
            this.bg().append(ActivityIndicator.loaderEl());
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
        return this;
        
    };
    
    /*
    * Mobile Original Alert Controller
    * */
    this.AlertController = function () {
        
        
        let AlertController = this;
        AlertController.title = "Title";
        AlertController.message = "Message";
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
        location.href = "vibrate" + "://1103";
        return this;
    }
    
    
    this.Button = function( El, options ){
    
        let _class = this;
        this._options = Object.assign({
            click:function(){},
            touchWith:"start", /* start or end */
            touch:function(){}
        }, options );
        
        this._touchstart = null;
        this._touchend = null;
        
        this.init = function(){
    

            
            this._touchstart    = El.ontouchstart;
            this._touchend      = El.ontouchend;
            
            
            if(X2.fromDevice()){
        
                if( El.getAttribute("disabled") )
                {
                    return false;
                }
                
                El.ontouchstart = function(){
                    
                    // Add First the class
                    El.classList.add("touched");
    
                    // Trigger the custom event (optional)
                    if( null !== _class._touchstart ){
                        _class._touchstart();
                    }
    
                    // Trigger the option event (optional)
                    if( _class._options.touchWith === "start" ){
                        _class._options.touch(El)
                    }
                    
                };
        
                El.ontouchend = function(){
                    
                    setTimeout(function () {
                        
                        // Remove First the class
                        El.classList.remove("touched");
                        
                        // Trigger the custom event (optional)
                        if( null !== _class._touchend ){
                            _class._touchend();
                        }
    
                        // Trigger the option event (optional)
                        if( _class._options.touchWith === "end" ){
                            _class._options.touch(El)
                        }
                        
                    }, 100)
                };
                
            } else {
        
                El.onmousedown = function(){
            
                    this.classList.add("touched");
                };
                El.onmouseup = function(){
                    setTimeout(function () {
                        El.classList.remove("touched");
                    }, 100)
            
                };
    
                El.onclick = function(){
                    // _class._options.click(El);
                    _class._options.touch(El)
                };
        
            }
            
            return this;
            
        }
        
        this.property = function( selector, value ){
            
            if( El !== null ){
    
                switch (selector) {
        
                    case "disabled":
                        if( value ){
                            El.addAttribute(selector, selector);
                        } else {
                            El.removeAttribute(selector);
                
                        }
                        break;
        
                    case "enabled":
                        if( !value ){
                            El.addAttribute(selector, selector);
                        } else {
                            El.removeAttribute(selector);
                
                        }
                        break;
        
                }
                
            }
      
        };
        
        
        this.refresh = function( callback ){
    
            if( undefined !== callback && typeof callback === "function" ){
                callback( El, _class )
            }
            
        };
        
        if( undefined !== El && null !== El ){
            this.init();
        }
        
        
        return El;
    }
    
    this.autoload = function () {
        
        this
            .TableView();
        
        
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
    
    
    this.autoload();
    
    
};