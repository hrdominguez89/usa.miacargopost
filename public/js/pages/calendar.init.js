let start_date = document.getElementById("event-start-date");
let timepicker1 = document.getElementById("timepicker1");
let timepicker2 = document.getElementById("timepicker2");
let date_range = null;
let T_check = null;

function flatPickrInit() {
    let config = {
        enableTime: true,
        noCalendar: true,
    };
    let date_range = flatpickr(
        start_date, {
            enableTime: false,
            mode: "range",
            minDate: "today",
            onChange: function (selectedDates, dateStr, instance) {

            },
        });
    flatpickr(timepicker1, config);
    flatpickr(timepicker2, config);

}

function flatpicekrValueClear() {
    start_date.flatpickr().clear();
    timepicker1.flatpickr().clear();
    timepicker2.flatpickr().clear();
}


function eventClicked() {
    document.getElementById('form-event').classList.add("view-event");
    document.getElementById("event-title").classList.replace("d-block", "d-none");
    document.getElementById("event-category").classList.replace("d-block", "d-none");
    document.getElementById("event-start-date").parentNode.classList.add("d-none");
    document.getElementById("event-start-date").classList.replace("d-block", "d-none");
    document.getElementById('event-time').setAttribute("hidden", "true");
    document.getElementById("timepicker1").parentNode.classList.add("d-none");
    document.getElementById("timepicker1").classList.replace("d-block", "d-none");
    document.getElementById("timepicker2").parentNode.classList.add("d-none");
    document.getElementById("timepicker2").classList.replace("d-block", "d-none");
    document.getElementById("event-location").classList.replace("d-block", "d-none");
    document.getElementById("event-description").classList.replace("d-block", "d-none");
    document.getElementById("event-start-date-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-timepicker1-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-timepicker2-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-location-tag").classList.replace("d-none", "d-block");
    document.getElementById("event-description-tag").classList.replace("d-none", "d-block");
    document.getElementById('btn-save-event').setAttribute("hidden", "true");
}

function editEvent(data) {
    let data_id = data.getAttribute("data-id");
    if (data_id === 'new-event') {
        document.getElementById('modal-title').innerHTML = "";
        document.getElementById('modal-title').innerHTML = "Crear Evento";
        document.getElementById("btn-save-event").innerHTML = "Crear Evento";
        eventTyped();
    } else if (data_id === 'edit-event') {
        data.innerHTML = "Cancelar";
        data.setAttribute("data-id", 'cancel-event');
        document.getElementById("btn-save-event").innerHTML = "Actualizar evento";
        data.removeAttribute("hidden");
        eventTyped();
    } else {
        data.innerHTML = "Editar";
        data.setAttribute("data-id", 'edit-event');
        eventClicked();
    }
}

function eventTyped() {
    document.getElementById('form-event').classList.remove("view-event");
    document.getElementById("event-title").classList.replace("d-none", "d-block");
    document.getElementById("event-category").classList.replace("d-none", "d-block");
    document.getElementById("event-start-date").parentNode.classList.remove("d-none");
    document.getElementById("event-start-date").classList.replace("d-none", "d-block");
    document.getElementById("timepicker1").parentNode.classList.remove("d-none");
    document.getElementById("timepicker1").classList.replace("d-none", "d-block");
    document.getElementById("timepicker2").parentNode.classList.remove("d-none");
    document.getElementById("timepicker2").classList.replace("d-none", "d-block");
    document.getElementById("event-location").classList.replace("d-none", "d-block");
    document.getElementById("event-description").classList.replace("d-none", "d-block");
    document.getElementById("event-start-date-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-timepicker1-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-timepicker2-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-location-tag").classList.replace("d-block", "d-none");
    document.getElementById("event-description-tag").classList.replace("d-block", "d-none");
    document.getElementById('btn-save-event').removeAttribute("hidden");
}

// upcoming Event
function upcomingEvent(a) {
    a.sort(function (o1, o2) {
        return (new Date(o1.start)) - (new Date(o2.start));
    });
    document.getElementById("upcoming-event-list").innerHTML = null;
    Array.from(a).forEach(function (element) {
        let title = element.title;
        let e_dt = element.end ? element.end : null;
        if (e_dt === "Invalid Date" || e_dt === undefined) {
            e_dt = null;
        } else {
            e_dt = new Date(e_dt).toLocaleDateString('en', {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric'
            });
        }
        let st_date = str_dt(element.start);
        let ed_date = str_dt(element.end);
        if (st_date === ed_date) {
            e_dt = null;
        }
        let startDate = element.start;
        if (startDate === "Invalid Date" || startDate === undefined) {
            startDate = null;
        } else {
            startDate = new Date(startDate).toLocaleDateString('en', {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric'
            });
        }

        let end_dt = (e_dt) ? " to " + e_dt : '';
        let category = (element.className).split("-");
        let description = (element.description) ? element.description : "";
        let e_time_s = tConvert(getTime(element.start));
        let e_time_e = tConvert(getTime(element.end));
        if (e_time_s === e_time_e) {
            let e_time_s = "Full day event";
            let e_time_e = null;
        }
        e_time_e = (e_time_e) ? " to " + e_time_e : "";

        let u_event = "<div class='card mb-3'>\
                        <div class='card-body'>\
                            <div class='d-flex mb-3'>\
                                <div class='flex-grow-1'><i class='mdi mdi-checkbox-blank-circle me-2 text-" + category[2] + "'></i><span class='fw-medium'>" + startDate + end_dt + " </span></div>\
                                <div class='flex-shrink-0'><small class='badge badge-soft-primary ms-auto'>" + e_time_s + e_time_e + "</small></div>\
                            </div>\
                            <h6 class='card-title fs-16'> " + title + "</h6>\
                            <p class='text-muted text-truncate-two-lines mb-0'> " + description + "</p>\
                        </div>\
                    </div>";
        document.getElementById("upcoming-event-list").innerHTML += u_event;
    });
}

function getTime(params) {
    params = new Date(params);
    if (params.getHours() != null) {
        let hour = params.getHours();
        let minute = (params.getMinutes()) ? params.getMinutes() : 0o0;
        return hour + ":" + minute;
    }
}

function tConvert(time) {
    let t = time.split(":");
    let hours = t[0];
    let minutes = t[1];
    let newformat = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    return (hours + ':' + minutes + ' ' + newformat);
}

let str_dt = function formatDate(date) {
    let monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    let d = new Date(date),
        month = '' + monthNames[(d.getMonth())],
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [day + " " + month, year].join(',');
};