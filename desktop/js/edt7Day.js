function func_get_EDT7D(div, cours, height) {
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
        stickyFooterScrollbar: true,
        minTime: "08:00:00",
        maxTime: "19:00:00",
        slotDuration: "00:15:00",
        contentHeight: height,
        windowResizeDelay: 1500
    });
    calendrier7Day.render();
    calendrier7Day.updateSize();
}

function func_get_AjaxEdt7(div, idEquiPronote) {
   $.ajax({
        type: 'POST',
        url: 'plugins/pronoteView/core/ajax/pronoteView.ajax.php',
        data: {
            action: 'getajaxEDT',
            idEquiPronote: idEquiPronote
        },
        dataType: 'json',
        error: function (request, status, error) {
            handleAjaxError(request, status, error, $('#div_VerifParam'));
        },
        success: function (data) {
            var height = data.result.height
            if (height !== "auto") {
                height = parseInt(height);
                height = height-(height/10);
            }
            func_get_EDT7D(div, data.result.EDT,height);
        }
    });
}