var startTime = 0;
var stopTime = 0;
var isActive = false;

function startStopTask() {
    countTime();
}

function countTime() {
    if (!isActive) {
        isActive = true;
        startTime = Date.now();

        setInterval(() => {
            if (isActive) {
                updateDisplayTime(Date.now() - startTime);
            }
        }, 1000);
    } else {
        if (getInput().length > 2) {
            isActive = false;
            stopTime = Date.now();
            addToPage(getInput(), parseTime(Date.now() - startTime));
            stopTime = 0;
            startTime = 0;
            updateDisplayTime(0);
            clearInput();
        } else {
            showErrorModal('Nazwa zadania musi mieć 3 znaki lub więcej');
        }
    }
}

function clearInput() {
    let inputEl = document.getElementsByClassName('tracker__task__name__input')[0];
    inputEl.value = '';
}

function getInput() {
    let inputEl = document.getElementsByClassName('tracker__task__name__input')[0];
    return inputEl?.value;
}

function updateDisplayTime(time) {
    time = parseTime(time);
    let timeEl = document.getElementsByClassName('tracker__task__time')[0];
    if (timeEl) {
        timeEl.innerText = time.toString();
    }
}

function parseTime(ms) {
    let seconds = (ms / 1000).toFixed(0);
    let minutes = Math.floor(seconds / 60);
    let hours = "";
    if (minutes > 59) {
        hours = Math.floor(minutes / 60);
        hours = (hours >= 10) ? hours : "0" + hours;
        minutes = minutes - (hours * 60);
        minutes = (minutes >= 10) ? minutes : "0" + minutes;
    }

    seconds = Math.floor(seconds % 60);
    seconds = (seconds >= 10) ? seconds : "0" + seconds;
    if (hours !== "") {
        return hours + ":" + minutes + ":" + seconds;
    }
    return minutes + ":" + seconds;
}

function addToPage(trackedName, trackedTime) {
    let taskUniqueId = Date.now();

    let trackerHistoryEl = document.getElementsByClassName('tracker__history')[0];
    let trackerHistoryHeader = document.getElementsByClassName('tracker__past')[0];
    let trackerHistoryDetailsWrapper = document.createElement('div');
    trackerHistoryDetailsWrapper.classList.add(taskUniqueId.toString());

    if (trackerHistoryEl) {
        let trackerHistoryName = document.createElement('div');
        trackerHistoryName.classList.add('tracker__history__name');
        trackerHistoryName.innerText = trackedName;

        let trackerHistoryTime = document.createElement('div');
        trackerHistoryTime.classList.add('tracker__history__time');
        trackerHistoryTime.innerText = trackedTime;

        let trackerHistoryDeleteButtonEl = document .createElement('button');
        trackerHistoryDeleteButtonEl.innerText = 'Usuń';
        trackerHistoryDeleteButtonEl.onclick = () => {
            deleteTask(taskUniqueId.toString());
        }

        trackerHistoryDetailsWrapper.appendChild(trackerHistoryName);
        trackerHistoryDetailsWrapper.appendChild(trackerHistoryTime);
        trackerHistoryDetailsWrapper.appendChild(trackerHistoryDeleteButtonEl);

        trackerHistoryEl.appendChild(trackerHistoryDetailsWrapper);
        trackerHistoryEl.style.visibility = 'visible';
    }

    if (trackerHistoryHeader) {
        trackerHistoryHeader.style.display = 'flex';
    }
}

function deleteTask(taskId) {
    if (taskId) {
        let task = document.getElementsByClassName(taskId)[0];
        task.parentNode.removeChild(task);
    }
}

function showErrorModal(errorText) {
    let errorModalEl = document.getElementsByClassName('tracker-error-wrapper')[0];
    errorModalEl.style.display = 'block';

    let errorModalText = document.getElementsByClassName('tracker-error__content')[0];
    errorModalText.innerText = errorText;
}

function closeErrorModal() {
    let errorModalEl = document.getElementsByClassName('tracker-error-wrapper')[0];
    errorModalEl.style.display = 'none';
}