<h2>Lista mieszkań</h2>
<form id="searchForm" action="" method="get">
    <input type="text" name="query" placeholder="Wyszukaj mieszkanie">
    <input type="submit" value="Szukaj">
</form>
<button onclick="get_apartments_list('a')">Wyświetl wszystko</button>

<div id="apartments_list_wrapper"></div>


<button onclick="document.getElementById('addModal').style.display='block',closeAddModal()">Dodaj mieszkanie</button>
<div id="output_info_delete"></div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-body">
                <!-- Formularz edycji zostanie załadowany tutaj -->
            </div>
        </div>
        <div id="output_info_update"></div>
        
    </div>

    <!-- Modal do dodawania -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="addApartment" action="" method="post">
                Numer mieszkania: <input type="text" name="number"><br>
                Piętro: <input type="text" name="floor"><br>
                <input type="submit" value="Dodaj mieszkanie">
            </form>
            <div id="output_info_add"></div>
        </div>
    </div>



