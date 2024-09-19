<form id="reportIssueForm" enctype="multipart/form-data">
    <textarea name="description" placeholder="Opis usterki" required></textarea>
    <input type="file" name="images[]" multiple accept="image/*">
    <button type="submit">Zgłoś usterkę</button>
</form>
<div id="errorMessage"></div>

<script src="/js/report-issue.js"></script>