var startTime = 0;
var stopTime = 0;
var isActive = false;

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
            console.log('jest zero')

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
    console.log(time);
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