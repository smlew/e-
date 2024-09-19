<?php 


include (dirname(__DIR__, 3).'/config.php');

?>
<h2>Lista mieszkańców</h2>
<form id="resident_search" action="">
    <input type="text" name="query" placeholder="Wyszukaj mieszkańca">
    <input type="submit" value="Szukaj">
</form>

<button onclick="residents_list()">Wyświetl wszystko</button>

<div id="resident_list_wrapper"></div>

<!--button onclick="document.getElementById('addModal').style.display='block',closeAddModal()">Dodaj mieszkańca</button-->

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-body">

            </div>
        </div>
        <div id="output_info_update"></div>
        
    </div>

<div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="addResidentToApartment" action="" method="post">
                Id mieszkańca: <input type="text" name="user_id"><br>
                Numer mieszkania: <input type="text" name="apartment_id"><br>
                <input type="submit" value="Dodaj mieszkanie">
            </form>
            <div id="output_info_add"></div>
        </div>
    </div>