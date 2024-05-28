document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('clearButton')) {
            clearContent(event);
        }
    });
    
    function clearContent(event) {
        var confirmClear = confirm("Are you sure you want to clear the content?");
        if (confirmClear) {
            var form = event.target.closest('form');
            var titleInput = form.querySelector('input[name="title"]');
            var contentInput = form.querySelector('textarea[name="content"]');
            
            titleInput.value = "";
            contentInput.value = "";
            titleInput.classList.remove('error');
            contentInput.classList.remove('error');
        }
    }
    
    var addPostForm = document.getElementById('addPostForm');
    addPostForm.addEventListener('submit', function(event) {
        var title = event.target.querySelector('input[name="title"]').value;
        var content = event.target.querySelector('textarea[name="content"]').value;
        
        if (title.trim() === "") {
            event.target.querySelector('input[name="title"]').classList.add('error');
        } else {
            event.target.querySelector('input[name="title"]').classList.remove('error');
        }
        
        if (content.trim() === "") {
            event.target.querySelector('textarea[name="content"]').classList.add('error');
        } else {
            event.target.querySelector('textarea[name="content"]').classList.remove('error');
        }
        
        if (title.trim() === "" || content.trim() === "") {
            alert("Please fill out all required fields.");
            event.preventDefault();
        }
    });
});
