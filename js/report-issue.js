document.getElementById('reportIssueForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        if (this.status == 200) {
            document.getElementById('errorMessage').innerText = this.response;
        } else {
            document.getElementById('errorMessage').innerText = 'Nie udało się wysłać zgłoszenia';
        }
    };
    xhttp.open('POST', '/ajax/reports/report_issue.php', true);
    xhttp.send(formData);
})