const calendar = document.querySelector(".calendar"),
  date = document.querySelector(".date"),
  daysContainer = document.querySelector(".days"),
  prev = document.querySelector(".prev"),
  next = document.querySelector(".next"),
  todayBtn = document.querySelector(".today-btn"),
  gotoBtn = document.querySelector(".goto-btn"),
  dateInput = document.querySelector(".date-input"),
  eventDay = document.querySelector(".event-day"),
  eventDate = document.querySelector(".event-date"),
  eventsContainer = document.querySelector(".events"),
  addEventBtn = document.querySelector(".add-event"),
  addEventWrapper = document.querySelector(".add-event-wrapper "),
  addEventCloseBtn = document.querySelector(".close "),
  addEventTitle = document.querySelector(".event-name"),
  addEventFrom = document.querySelector(".event-time-from "),
  addEventTo = document.querySelector(".event-time-to "),
  addEventSubmit = document.querySelector(".add-event-btn ");

let today = new Date();
let activeDay;
let month = today.getMonth();
let year = today.getFullYear();

const months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];

// const eventsArr = [
//   {
//     day: 13,
//     month: 11,
//     year: 2022,
//     events: [
//       {
//         title: "Event 1 lorem ipsun dolar sit genfa tersd dsad ",
//         timeFrom: "10:00 AM",
//         timeTo: "11:00 AM"
//       },
//     ],
//   },
// ];


const eventsArr = [];
//getEvents();
//console.log(eventsArr);

//function to add days in days with class day and prev-date next-date on previous month and next month days and active on today
function initCalendar() {
  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);
  const prevLastDay = new Date(year, month, 0);
  const prevDays = prevLastDay.getDate();
  const lastDate = lastDay.getDate();
  const day = firstDay.getDay();
  const nextDays = 7 - lastDay.getDay() - 1;

  date.innerHTML = months[month] + " " + year;

  let days = "";

  for (let x = day; x > 0; x--) {
    days += `<div class="day prev-date">${prevDays - x + 1}</div>`;
  }

  for (let i = 1; i <= lastDate; i++) {
    //check if event is present on that day
    let event = false;
    eventsArr.forEach((eventObj) => {
      if (
        eventObj.day === i &&
        eventObj.month === month + 1 &&
        eventObj.year === year
      ) {
        event = true;
      }
    });
    if (
      i === new Date().getDate() &&
      year === new Date().getFullYear() &&
      month === new Date().getMonth()
    ) {
      activeDay = i;
      getActiveDay(i);
      updateEvents(i);
      if (event) {
        days += `<div class="day today active event">${i}</div>`;
      } else {
        days += `<div class="day today active">${i}</div>`;
      }
    } else {
      if (event) {
        days += `<div class="day event">${i}</div>`;
      } else {
        days += `<div class="day ">${i}</div>`;
      }
    }
  }

  for (let j = 1; j <= nextDays; j++) {
    days += `<div class="day next-date">${j}</div>`;
  }
  daysContainer.innerHTML = days;
  addListner();
}

//function to add month and year on prev and next button
function prevMonth() {
  month--;
  if (month < 0) {
    month = 11;
    year--;
  }
  initCalendar();
}

function nextMonth() {
  month++;
  if (month > 11) {
    month = 0;
    year++;
  }
  initCalendar();
}

prev.addEventListener("click", prevMonth);
next.addEventListener("click", nextMonth); ///////////////////////

initCalendar();

//function to add active on day
function addListner() {
  const days = document.querySelectorAll(".day");
  days.forEach((day) => {
    day.addEventListener("click", (e) => {
      getActiveDay(e.target.innerHTML);
      updateEvents(Number(e.target.innerHTML));
      activeDay = Number(e.target.innerHTML);
      //remove active
      days.forEach((day) => {
        day.classList.remove("active");
      });
      //if clicked prev-date or next-date switch to that month
      if (e.target.classList.contains("prev-date")) {
        prevMonth();
        //add active to clicked day afte month is change
        setTimeout(() => {
          //add active where no prev-date or next-date
          const days = document.querySelectorAll(".day");
          days.forEach((day) => {
            if (
              !day.classList.contains("prev-date") &&
              day.innerHTML === e.target.innerHTML
            ) {
              day.classList.add("active");
            }
          });
        }, 100);
      } else if (e.target.classList.contains("next-date")) {
        nextMonth();
        //add active to clicked day afte month is changed
        setTimeout(() => {
          const days = document.querySelectorAll(".day");
          days.forEach((day) => {
            if (
              !day.classList.contains("next-date") &&
              day.innerHTML === e.target.innerHTML
            ) {
              day.classList.add("active");
            }
          });
        }, 100);
      } else {
        e.target.classList.add("active");
      }
    });
  });
}

todayBtn.addEventListener("click", () => {
  today = new Date();
  month = today.getMonth();
  year = today.getFullYear();
  initCalendar();
});

dateInput.addEventListener("input", (e) => {
  dateInput.value = dateInput.value.replace(/[^0-9/]/g, "");
  if (dateInput.value.length === 2) {
    dateInput.value += "/";
  }
  if (dateInput.value.length > 7) {
    dateInput.value = dateInput.value.slice(0, 7);
  }
  if (e.inputType === "deleteContentBackward") {
    if (dateInput.value.length === 3) {
      dateInput.value = dateInput.value.slice(0, 2);
    }
  }
});

gotoBtn.addEventListener("click", gotoDate);

function gotoDate() {
  console.log("here");
  const dateArr = dateInput.value.split("/");
  if (dateArr.length === 2) {
    if (dateArr[0] > 0 && dateArr[0] < 13 && dateArr[1].length === 4) {
      month = dateArr[0] - 1;
      year = dateArr[1];
      initCalendar();
      return;
    }
  }
  alert("Invalid Date");
}

//function get active day day name and date and update eventday eventdate
function getActiveDay(date) {
  const day = new Date(year, month, date);
  const dayName = day.toString().split(" ")[0];
  eventDay.innerHTML = dayName;
  eventDate.innerHTML = date + " " + months[month] + " " + year;
}

//function update events when a day is active
function updateEvents(date) {
  let events = "";
  eventsArr.forEach((event) => {
    if (
      date === event.day &&
      month + 1 === event.month &&
      year === event.year
    ) {
      event.events.forEach((event) => {
        events += `<div class="event">
            <div class="title">
              <i class="fas fa-circle"></i>
              <h3 class="event-title">${event.motivo}</h3>
            </div>
            <div class="event-time">
              <span class="event-time">${event.time_from} - ${event.time_to}</span>
            </div>
        </div>`;
      });
    }
  });
  if (events === "") {
    events = `<div class="no-event">
            <h3>No Events</h3>
        </div>`;
  }
  eventsContainer.innerHTML = events;
}

//function to add event
addEventBtn.addEventListener("click", () => {
  addEventWrapper.classList.toggle("active");
});
///Removeeeeee
addEventCloseBtn.addEventListener("click", () => {
  addEventWrapper.classList.remove("active");
});

document.addEventListener("click", (e) => {
  if (e.target !== addEventBtn && !addEventWrapper.contains(e.target)) {
    addEventWrapper.classList.remove("active");
  }
});

//allow 50 chars in eventtitle
addEventTitle.addEventListener("input", (e) => {
  addEventTitle.value = addEventTitle.value.slice(0, 60);
});

// function defineProperty() {
//   var osccred = document.createElement("div");
//   osccred.innerHTML =
//     "A Project By <a href='https://www.youtube.com/channel/UCiUtBDVaSmMGKxg1HYeK-BQ' target=_blank>Open Source Coding</a>";
//   osccred.style.position = "absolute";
//   osccred.style.bottom = "0";
//   osccred.style.right = "0";
//   osccred.style.fontSize = "10px";
//   osccred.style.color = "#ccc";
//   osccred.style.fontFamily = "sans-serif";
//   osccred.style.padding = "5px";
//   osccred.style.background = "#fff";
//   osccred.style.borderTopLeftRadius = "5px";
//   osccred.style.borderBottomRightRadius = "5px";
//   osccred.style.boxShadow = "0 0 5px #ccc";
//   document.body.appendChild(osccred);
// }

// defineProperty();

//allow only time in eventtime from and to
addEventFrom.addEventListener("input", (e) => {
  addEventFrom.value = addEventFrom.value.replace(/[^0-9:]/g, "");
  if (addEventFrom.value.length === 2) {
    addEventFrom.value += ":";
  }
  if (addEventFrom.value.length > 5) {
    addEventFrom.value = addEventFrom.value.slice(0, 5);
  }
});

addEventTo.addEventListener("input", (e) => {
  addEventTo.value = addEventTo.value.replace(/[^0-9:]/g, "");
  if (addEventTo.value.length === 2) {
    addEventTo.value += ":";
  }
  if (addEventTo.value.length > 5) {
    addEventTo.value = addEventTo.value.slice(0, 5);
  }
});

//function to add event to eventsArr
addEventSubmit.addEventListener("click", () => {
  const eventTitle = addEventTitle.value;
  const eventTimeFrom = addEventFrom.value;
  const eventTimeTo = addEventTo.value;
  if (eventTitle === "" || eventTimeFrom === "" || eventTimeTo === "") {
    alert("Please fill all the fields");
    return;
  }

  //check correct time format 24 hour
  const timeFromArr = eventTimeFrom.split(":");
  const timeToArr = eventTimeTo.split(":");
  if (
    timeFromArr.length !== 2 ||
    timeToArr.length !== 2 ||
    timeFromArr[0] > 23 ||
    timeFromArr[1] > 59 ||
    timeToArr[0] > 23 ||
    timeToArr[1] > 59
  ) {
    alert("Formato de hora inválido");
    return;
  }

  // Verificar si el evento ya existe
  let eventExist = false;
  eventsArr.forEach((event) => {
    if (
      event.day === activeDay &&
      event.month === month + 1 &&
      event.year === year
    ) {
      event.events.forEach((existingEvent) => {
        if (existingEvent.title === eventTitle) {
          eventExist = true;
        }
      });
    }
  });

  if (eventExist) {
    alert("El evento ya ha sido agregado");
    return;
  }

  // Crear el nuevo evento
  const newEvent = {
    motivo: eventTitle,
    time_from: eventTimeFrom,
    time_to: eventTimeTo,
    day: activeDay,
    month: month + 1,
    year: year
  };

  //Enviar el nuevo evento al servidor usando fetch
  fetch('/TC2005B_602_01/IngeniaLab/src/reservass/add-reserva.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(newEvent)
  })
  .then(response => response.text())
  .then(data => {
    console.log(data); // Mostrar la respuesta del servidor
    if (data.includes('Evento guardado correctamente')) {
      // Agregar el evento a eventsArr si se guardó correctamente en la base de datos
      let eventAdded = false;
      if (eventsArr.length > 0) {
        eventsArr.forEach((item) => {
          if (
            item.day === activeDay &&
            item.month === month + 1 &&
            item.year === year
          ) {
            item.events.push(newEvent);
            eventAdded = true;
          }
        });
      }

      if (!eventAdded) {
        eventsArr.push({
          day: activeDay,
          month: month + 1,
          year: year,
          events: [newEvent]
        });
      }

      // Limpiar formulario y actualizar la UI
      addEventWrapper.classList.remove("active");/////////////
      addEventTitle.value = "";
      addEventFrom.value = "";
      addEventTo.value = "";
      updateEvents(activeDay);

      // Agregar clase de evento al día activo si no se ha añadido
      const activeDayEl = document.querySelector(".day.active");
      if (!activeDayEl.classList.contains("event")) {
        activeDayEl.classList.add("event");
      }
    } else {
      alert("Error al guardar el evento. Inténtalo de nuevo.");
    }
  })
  .catch((error) => {
    console.error('Error:', error);
    alert("Error al guardar el evento. Inténtalo de nuevo.");
  });
});


// Cargar eventos desde el servidor al cargar la página
document.addEventListener("DOMContentLoaded", () => {
    fetch('/TC2005B_602_01/IngeniaLab/src/reservass/add-reserva.php')
        .then(response => response.json()) // Aquí se espera un JSON, no texto
        .then(data => {
            eventsArr.push(...data);
            initCalendar(); // Inicia el calendario con los eventos obtenidos
        })
        .catch(error => console.error('Error al cargar eventos:', error));
});



//function to delete event when clicked on event
eventsContainer.addEventListener("click", (e) => {
  const eventElement = e.target.closest(".event");
  if (eventElement) {
    if (confirm("¿Seguro que quieres eliminar este evento?")) {
      const eventTitle = eventElement.querySelector(".event-title").innerHTML;
      
      // Encontrar el evento en eventsArr
      let eventIndex = -1;
      eventsArr.forEach((event, index) => {
        if (
          event.day === activeDay &&
          event.month === month + 1 &&
          event.year === year
        ) {
          eventIndex = index;
          event.events.forEach((item, itemIndex) => {
            if (item.motivo === eventTitle) {
              // Eliminar evento de la base de datos
              fetch('/TC2005B_602_01/IngeniaLab/src/reservass/eliminar-reserva.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                  day: activeDay,
                  month: month + 1,
                  year: year,
                  motivo: eventTitle
                })
              })
              .then(response => response.text())
              .then(data => {
                console.log(data); // Mostrar la respuesta del servidor

                if (data.includes('Evento eliminado correctamente')) {
                  // Eliminar evento de eventsArr
                  event.events.splice(itemIndex, 1);
                  if (event.events.length === 0) {
                    eventsArr.splice(eventIndex, 1);
                    // Quitar la clase de evento del día si no hay eventos restantes
                    const activeDayEl = document.querySelector(".day.active");
                    if (activeDayEl && activeDayEl.classList.contains("event")) {
                      activeDayEl.classList.remove("event");
                    }
                  }
                  updateEvents(activeDay); // Actualizar la interfaz
                } else {
                  alert("Error al eliminar el evento. Inténtalo de nuevo.");
                }
              })
              .catch((error) => {
                console.error('Error:', error);
                alert("Error al eliminar el evento. Inténtalo de nuevo.");
              });
            }
          });
        }
      });
    }
  }
});

// Función para guardar eventos en la base de datos
function saveEvents() {
  const formData = new FormData();
  formData.append('eventsArr', JSON.stringify(eventsArr));

  // fetch('/TC2005B_602_01/IngeniaLab/src/reservass/add-reserva.php', {
  //   method: 'POST',
  //   body: formData,
  // })
  // .then(response => response.text())
  // .then(data => {
  //   console.log(data); // Muestra la respuesta del servidor
  // })
  // .catch((error) => {
  //   console.error('Error:', error);
  // });
  
}


//function to get events from local storage
function getEvents() {
  
  fetch('/TC2005B_602_01/IngeniaLab/src/reservass/add-reserva.php')
  .then(response => response.json())
  .then(data => {
    eventsArr.push(...data);
    initCalendar(); // Inicia el calendario con los eventos obtenidos
  })
  .catch((error) => {
    console.error('Error:', error);
  });
}


function convertTime(time) {
  //convert time to 24 hour format
  let timeArr = time.split(":");
  let timeHour = timeArr[0];
  let timeMin = timeArr[1];
  let timeFormat = timeHour >= 12 ? "PM" : "AM";
  timeHour = timeHour % 12 || 12;
  time = timeHour + ":" + timeMin + " " + timeFormat;
  return time;
}
