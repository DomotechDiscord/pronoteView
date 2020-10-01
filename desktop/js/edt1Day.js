function func_get_EDT1D(div, cours, height) {
    let elementCalendrier1Day = document.getElementById(div);

    let calendrier1Day = new FullCalendar.Calendar(elementCalendrier1Day, {
        plugins: ['dayGrid', 'timeGrid', 'bootstrap'],
        themeSystem: 'bootstrap',
        bootstrapFontAwesome: {
            close: 'fa-times',
            prev: 'fa-chevron-left',
            next: 'fa-chevron-right',
            prevYear: 'fa-angle-double-left',
            nextYear: 'fa-angle-double-right'
        },
        defaultView: 'timeGridDay',
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
    calendrier1Day.render();
    calendrier1Day.updateSize();
}

function func_get_AjaxEdt1(div, idEquiPronote) {
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
            func_get_EDT1D(div, data.result.EDT,height);
        }
    });
}