function closeModal() {
    document.getElementById('eventModal').style.display = 'none';

}
window.onclick = function(event) {
    var modal = document.getElementById("myModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}