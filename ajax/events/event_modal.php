<div id="eventModal" style="display:none;">
    <div>
        <span id="closeModal">&times;</span>
        <h2>Dodaj wydarzenie</h2>
        <label>Data (YYYY-MM-DD):</label>
        <input type="text" id="dateInput" placeholder="Wpisz datę"><br>
        <label>Nazwa:</label>
        <input type="text" id="nameInput" placeholder="Wpisz nazwę wydarzenia"><br>
        <label>Czas początku (HH:MM):</label>
        <input type="text" id="startTimeInput" placeholder="Wpisz czas początku"><br>
        <label>Czas zakończenia (HH:MM) - opcjonalnie:</label>
        <input type="text" id="endTimeInput" placeholder="13:00"><br>
        <div id="errorMessage" style="color: red;"></div>
        <button id="submitEvent">Dodaj wydarzenie</button>
    </div>
</div>