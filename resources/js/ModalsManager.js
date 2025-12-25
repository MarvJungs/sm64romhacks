export default class ModalsManager
{
    constructor() {
        const modal = document.getElementById('modal-confirm');
        modal.addEventListener('show.bs.modal', (e) => {
            const button = e.relatedTarget;

            modal.querySelector('#modal-title').innerText = button.getAttribute('data-bs-title') ?? 'Confirm Action';
            modal.querySelector('#modal-text').innerText = button.getAttribute('data-bs-text') ?? 'Are you sure you want to proceed? This action cannot be undone...';
            modal.querySelector('#modal-form').setAttribute('action', button.getAttribute('data-bs-route'));
            modal.querySelector('#modal-form-method').value = button.getAttribute('data-bs-method');
        });
    }
}