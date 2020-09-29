function func_note_button(div, cours) {
    let elementCalendrier7Day = document.getElementById(div);

    let calendrier7Day = new FullCalendar.Calendar(elementCalendrier7Day, {
        plugins: ['dayGrid', 'timeGrid', 'bootstrap'],
        themeSystem: 'bootstrap',
        bootstrapFontAwesome: {
            close: 'fa-times',
            prev: 'fa-chevron-left',
            next: 'fa-chevron-right',
            prevYear: 'fa-angle-double-left',
            nextYear: 'fa-angle-double-right'
        },
        defaultView: 'timeGridWeek',
        locale: 'fr',
        header: {
            left: 'today',
            center: 'title',
            right: 'prev,next'
        },
        buttonText: {
            today: 'Aujourd\'hui',
            month: 'Mois',
            week: 'Semaine'
        },
        events: cours,
        nowIndicator: true,
        allDaySlot: false,
        hiddenDays: [0],
        minTime: "08:00:00",
        maxTime: "19:00:00",
        slotDuration: "00:15:00",
        contentHeight: "auto",
        windowResizeDelay: 500
    });
    calendrier7Day.render();

}