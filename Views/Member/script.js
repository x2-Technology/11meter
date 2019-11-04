/**
 * Created by tSoftX on 12/02/2017.
 */

$(function () {
    new Layout()
        .init();
});

let
    GlobalTableViewApi,
    Layout = function () {
        
        let L = this;
        
        this.init = function () {
            
            if (DEVICE !== "") {
            
            }
            
            document.querySelectorAll("a").forEach(function (El) {
                El.onclick = function () {
                    let data = this.dataset.data;
                    // alert(data);
                    data = JSON.parse(data.replace(/[\\]/g, ""));
                    L.loadActivityWithData(data);
                }
            });
            
            
            // this.buttons();
            if (mtd === "performance") {
                this.performance();
            }
            
            if( nsp === "role" && mtd === "cellDocument" ){
                
                new X2Tools().TableView().create();
            }
            
            
            
            
            return this;
        };
        
        this.buttons = function () {
            
            
            return this;
        };
        
        
        // View Role
        this.dismissViewController = function () {
            
            if (nsp === "role") {
                
                let checkedItem = [];
                document.querySelectorAll("input:checked").forEach(function (El) {
                    checkedItem.push(El.value);
                });
                
                $(".x2-list").serializeContent(function () {
                    
                    this.unwindFrom = "role";
                    L.setUnwindDataFromJSONString(JSON.stringify(this));
                    dismissViewController(L.getUnwindDataStore());
                    
                    
                })
                
                
            }
            
            
        };
        
        
        this.testAction = function(){
    
    
            L.setUnwindDataStore("unwindFrom", "season_");
            L.setUnwindDataStore("season_id", 0);
    
            new X2Tools().dismissViewController(L.getUnwindDataStore());
            
            
        }
        
        
        
        
        
        this.performance = function () {
            
            let i = 0;
            let x = [98.5, 65, 29]; // 100% for all circle
            let val = [99, 21, 90];
            let d = [500, 1000, 1300];
            // let d       = [0,0,0];
            
            let totalPerformanceEl = document.getElementById("totalPerformance");
            
            // Animation speed as Css for Circle el for 100% 3ms
            let circleAnimationDuration = totalPerformanceEl.dataset.count * 3 / 100;
            
            document.querySelectorAll(".circle").forEach(function (El) {
                
                
                setTimeout(function () {
                    El.style.visibility = "visible";
                    // El.setAttribute("stroke-dasharray", x[i] + ", 100");
                    // El.style.strokeDasharray = ( val[i] * x[i] / 100 ) + ", 100";
                    El.style.strokeDasharray = (El.dataset.value * x[i] / El.dataset.full) + ", 100";
                    El.classList.add("circle-animate");
                    El.style.animationDuration = circleAnimationDuration + "s";
                    // alert(circleAnimationDuration);
                    i++;
                }, d[i]);
                
            });
            
            totalPerformanceEl.innerHTML = 0 + totalPerformanceEl.dataset["operator"];// totalPerformanceEl.dataset["start-value"];
            setTimeout(function () {
                L.performanceCounter(totalPerformanceEl, 0);
            }, d[0]);
            // this.performanceStarts( document.getElementById("totalPerformance").dataset.count, 1, 1 );
            
            
        };
        
        this.performanceCounter = function (El, v) {
            
            // console.log("Value Of Rating -> %" +  parseInt(v));
            
            let count = El.dataset.count;
            let operator = El.dataset.operator;
            /*if( !v ){
                El.innerHTML    = El.dataset["start-value"];
            }*/
            
            El.innerHTML = v + "" + operator;
            if (v < count) {
                setTimeout(function () {
                    
                    v++;
                    // console.log("Value Of Rating %", val);
                    
                    
                    L.performanceStarts(count, v, 0);
                    
                    L.performanceCounter(El, v);
                    
                    
                }, 30);
            }
            
            
        }
        
        this.performanceStarts = function (userPerformance, v, retID) {
            
            
            let targetPerformance = 10;
            let startPerformance = userPerformance * targetPerformance / 100;
            // console.log("Value Of Rating %: " + v + " 20 ye bolumden kalan " + Math.floor(v / 20) + " Artik ->" + Math.floor(v / 10) % 2 );
            
            let ratingElID = Math.ceil(v / 20);
            let isFull = v / 10 % 2 === 0;
            let isHalf = v / 10 % 2 > .5;
            
            console.log("Rating Element ID:" + ratingElID + " isFull:" + isFull + " value:" + v + " Bolunen:" + (v / 10) + " Kalan->:" + v / 10 % 2);
            
            document.querySelectorAll(".rating").forEach(function (e) {
                
                if (ratingElID > 0 && parseInt(e.dataset.rating) === ratingElID) {
                    
                    if (isFull) {
                        e.classList.remove("icon-star-empty");
                        e.classList.remove("icon-star-half");
                        e.classList.add("icon-star-full");
                    } else if (!isFull) {
                        // console.log("Must Half sein for " + ratingElID);
                        // e.classList.remove("icon-star-empty");
                        if (isHalf) {
                            e.classList.remove("icon-star-empty");
                            e.classList.remove("icon-star-full");
                            e.classList.add("icon-star-half");
                        }
                    }
                    
                    
                    /*if( val < startPerformance ){
                        setTimeout(function () {
                            if( !(val % 2) ){
                                retID++;
                            }
                            L.performanceStarts( userPerformance, val+1, retID );
                        },100);
                    }*/
                    
                }
            });
            
            
            /*let i = 0;
            let s = setInterval(function() {
                let r = Math.floor(Math.random()*(countInner/50));
                if (i+r <= countInner) {
                    i += r;
                    El.innerHTML = i + "" + operator;
                } else {
                    El.innerHTML = countInner + "" + operator;
                    clearInterval(s);
                }
            }, 1);*/
            
        }
        
        this.loadActivityWithData = function (data) {
            
            let activity = data.activity;
            // alert(activity);
            let dataJSONString = JSON.stringify(data);
            if (activity === undefined) {
                activity = ACTIVITY.ACTIVITY_1
            }
            // alert(DEVICE + "://" + activity + "?" + dataJSONString);
            location.href = DEVICE + "://" + activity + "?" + dataJSONString;
            
        };
        
        
        this.setUnwindDataStore = function (k, v) {
            unwindDataStore[k] = v;
        };
        this.setUnwindDataFromJSONString = function (data) {
            
            if (typeof data !== "object") {
                unwindDataStore = JSON.parse(data);
            } else {
                unwindDataStore = data
            }
            return this;
        };
        this.getUnwindDataStore = function () {
            
            data = JSON.stringify(unwindDataStore);
            return data;
        };
        this.updateAvailability = function () {
            
            
            try {
                let obj = this.getUnwindDataStore();
                
                if (typeof obj !== "object") {
                    obj = JSON.parse(obj);
                }
                
                
                if (nsp === "_notification") {
                    
                    
                    try {
                        
                        let pickerEl = document.querySelector("input[data-role='plan-picker'][name='" + obj["plan-picker"] + "']");
                        
                        let lastPlanValue = [];
                        lastPlanValue.push(parseInt(obj["d"]));
                        lastPlanValue.push(parseInt(obj["h"]));
                        lastPlanValue.push(parseInt(obj["m"]));
                        pickerEl.value = JSON.stringify(lastPlanValue);
                        // alert(JSON.stringify(lastPlanValue));
                        // pickerEl.parentNode.innerText = obj["plan"];
                        pickerEl.parentNode.childNodes.forEach(function (El) {
                            if (El.nodeName === "LABEL") {
                                El.innerText = obj["plan"];
                            }
                            console.log(El.nodeName);
                        })
                        
                    } catch (e) {
                        alert("232" + e.message + " " + mtd);
                        
                    }
                }
                
                
            } catch (e) {
                // alert(e.message);
            }
            
            
        };
        
        
        return this;
        
    }
    , unwindDataStore = {},
    // This action calling from Native Content data Post from Native Content And Need Absolute
    unwindAction = function (data) {
        
        
        switch (data.unwindFrom) {
    
            case "season":
                try{
                    Layout().updateCellRoleSeason(data);
                } catch (e){
                    alert(e.message);
                }
                break;
        
        
            case "club":
            
                Layout().updateCellRoleClub(data);
            
                break;
    
            case "addTeam":
                
                Layout().updateCellRoleTeam(data);
        
                break;
        
                case "club_assistant":
                
                alert(JSON.stringify(data));
        
                break;
        
        
        }
       
        
        
        /*new Layout()
            .setUnwindDataFromJSONString(data)
            .updateAvailability();
        
        
        alert(nsp);*/
        
    };

