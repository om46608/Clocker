var startTime = 0;
var stopTime = 0;
var isActive = false;
var isAdvancedSort = true;

function startStopTask(id = 0) {
    countTime(id);
}

function getStartingTime(id) {
    let timeEl = document.querySelectorAll('#tracker__task__time-' + id)[0];
    var p = timeEl.value.split(':'),
        s = 0, m = 1;

    while (p.length > 0) {
        s += m * parseInt(p.pop(), 10);
        m *= 60;
    }

    return s*1000;

}

function countTime(id = 0) {
    var startingTime = getStartingTime(id);
    if (!isActive) {
        isActive = true;
        if(startingTime === 0) {
            startTime = Date.now();
            setInterval(() => {
                if (isActive) {
                    updateDisplayTime(Date.now() - startTime, id);
                }
            }, 1000);
        } else {
            startTime = Date.now();
            setInterval(() => {
                if (isActive) {
                    updateDisplayTime(startingTime + Date.now() - startTime, id);
                }
            }, 1000);
        }
    } else {
        isActive = false;
        stopTime = Date.now();
        addToDatabase(startingTime  + Date.now() - startTime, id);
        stopTime = 0;
        startTime = 0;
    }
}


function updateDisplayTime(time, id = 0) {
    time = parseTimeDb(time);
    let timeEl = document.querySelectorAll('#tracker__task__time-' + id)[0];
    if (timeEl) {
        timeEl.value = time.toString();
    }
}

function parseTimeDb(ms) {
    return (new Date(ms).toISOString().slice(11,19)).toString();
}

function addToDatabase(trackedTime, task_id) {
    let trackedTimeFormInput = document.querySelector("#trackedTimeFormInput-" + task_id);
    trackedTimeFormInput.value = task_id + ":::" +parseTimeDb(trackedTime);

    let trackedTimeForm = document.querySelector("#addTimeToDb-" + task_id);
    trackedTimeForm.submit();

}

function closeErrorModal() {
    let errorModalEl = document.getElementsByClassName('tracker-error-wrapper')[0];
    errorModalEl.style.display = 'none';
}

function updateTaskName(id) {
    let taskNameInputFieldEl = document.querySelector('#task_name_input-' + id)
    var task_name = taskNameInputFieldEl.value;

    let updateTaskNameFormInput = document.querySelector("#updateTaskNameFormInput-" + id);
    updateTaskNameFormInput.value = id + ":::" + task_name;

    let updateTaskNameForm = document.querySelector("#updateTaskName-" + id);

    if (task_name.length > 2) {
        updateTaskNameForm.submit();
    }
}

function advancedSort() {
    let filters = document.querySelectorAll(".filter");

    if (filters) {
        isAdvancedSort = !isAdvancedSort;
      filters.forEach((filter) => {
         if (isAdvancedSort) {
             filter.classList.add("d-none");
         } else {
             filter.classList.remove("d-none");
         }
      });
    }
}