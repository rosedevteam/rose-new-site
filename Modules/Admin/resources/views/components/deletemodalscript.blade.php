<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.body.addEventListener('click', (event) => {
            if (event.target.matches('#delete-button')) {
                const id = event.target.getAttribute('data-id');
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `{{ $model }}/${id}`;
            }
        });
    });
</script>
