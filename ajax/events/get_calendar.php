

    <div class="modal" id="eventModal" tabindex="-1" role="dialog" style="display: none; z-index:8">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventTitle"></h5>
                </div>
                <div class="modal-body">
                    <p><strong>Start:</strong> <span id="eventStart"></span></p>
                    <p><strong>Koniec:</strong> <span id="eventEnd"></span></p>
                    <p><strong>Opis:</strong> <span id="eventDescription"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Zamknij</button>
                </div>
            </div>
        </div>
    </div>

<div id="calendar-container">
    <!-- Контейнер для календаря -->
    <div id="calendarEl"></div>
</div>
