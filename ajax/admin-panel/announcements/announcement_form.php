<h2>Prześlij nowość</h2>
<form id="upload_news" method="POST" enctype="multipart/form-data">
    <label for="title">Tytuł:</label><br>
    <input type="text" id="title" name="title"><br>
    
    <label for="text">Treść:</label><br>
    <textarea id="text" name="text" rows="4" cols="50"></textarea><br>
    
    <label for="image">Wybierz obraz:</label><br>
    <input type="file" id="image" name="image"><br>
    
    <input type="submit" value="Dodaj wiadomość">
</form>

<div id="info_output_news"></div>