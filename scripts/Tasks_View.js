function sortList(ul, mode){
    cell = 1;
    flag = false;
    var new_ul = ul.cloneNode(false);
    var lis = [];
    for(var i = 0;i < ul.childNodes.length; i++){
        if(ul.childNodes[i].nodeName === 'LI')
            lis.push(ul.childNodes[i]);
    }
    switch(mode)
    {
        case("name"):
        {
            cell = 0;
            flag = sorterNameFlag;
            break;
        }
        case("date"):
        {
            cell = 4;
            flag = sorterDateFlag;
            break;
        }
        case("type"):
        {
            cell = 6;
            flag = sorterTypeFlag;
            break; 
        }
    }
    lis.sort(function(a, b){
        if(flag == false)
        {
            if(a.childNodes[cell].value > b.childNodes[cell].value) {return -1;} 
            if(a.childNodes[cell].value < b.childNodes[cell].value) {return 1;}
        }
        else
        {
            if(a.childNodes[cell].value > b.childNodes[cell].value) {return 1;} 
            if(a.childNodes[cell].value < b.childNodes[cell].value) {return -1;}
        }
        return 0;
    });

    switch(mode)
    {
        case("name"):
        {
            sorterNameFlag = !sorterNameFlag;
            break;
        }
        case("date"):
        {
            sorterDateFlag = !sorterDateFlag;
            break;
        }
        case("type"):
        {
            sorterTypeFlag = !sorterTypeFlag;
            break; 
        }
    }

    for(var i = 0; i < lis.length; i++)
        new_ul.appendChild(lis[i]);
    ul.parentNode.replaceChild(new_ul, ul);
}

//childNodes[0] - nazwa taska
//childNodes[5] - nazwa projektu
//childNodes[6] - nazwa klienta

function filterList(ul, filter, type = 0) {
    var new_ul = ul.cloneNode(false);
    var lis = [];
    for(var i = 0;i < ul.childNodes.length; i++){
        if(ul.childNodes[i].nodeName === 'LI')
            lis.push(ul.childNodes[i]);
    }
    for(var i = 0; i < lis.length; i++)
    {if(lis[i].childNodes[type].value.indexOf(filter) == -1)
            lis[i].classList.add("hidden");
        else
            lis[i].classList.remove("hidden");
    }
    for(var i = 0; i < lis.length; i++)
        new_ul.appendChild(lis[i]);
    ul.parentNode.replaceChild(new_ul, ul);
}

let sorterNameFlag = false;
let sorterDateFlag = false;
let sorterTypeFlag = false;

document.getElementById("sorter-name").addEventListener("click", function() {
    sortList(document.getElementById("tasks-list"), "name");
});

document.getElementById("sorter-date").addEventListener("click", function() {
    sortList(document.getElementById("tasks-list"), "date");
});

document.getElementById("sorter-type").addEventListener("click", function() {
    sortList(document.getElementById("tasks-list"), "type");
});

document.getElementById("filter-name").addEventListener("input", function(){
    console.log('name');
    filterList(document.getElementById("tasks-list"), this.value, 0);
})

document.getElementById("filter-client").addEventListener("input", function(){
    console.log('client');
    filterList(document.getElementById("tasks-list"), this.value, 6);
})

document.getElementById("filter-project").addEventListener("input", function(){
    console.log('project');
    filterList(document.getElementById("tasks-list"), this.value, 5);
})