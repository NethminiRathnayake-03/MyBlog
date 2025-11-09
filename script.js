// Confirm delete
function confirmDelete(event) {
    if(!confirm("Are you sure you want to delete this blog?")) {
        event.preventDefault();
    }
}

// Live preview in editor
const contentArea = document.getElementById('content');
const previewDiv = document.getElementById('preview');

if(contentArea) {
    contentArea.addEventListener('input', () => {
        previewDiv.innerHTML = contentArea.value.replace(/\n/g, "<br>");
    });
}
