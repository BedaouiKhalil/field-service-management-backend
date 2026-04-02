import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: 'toast-top-right',
    timeOut: 4000
};

export function initToastr() {
    const flashSuccess = document.querySelector('#flash-success');
    if (flashSuccess) {
        const message = flashSuccess.value || flashSuccess.textContent;
        toastr.success(message);
    }

    const flashSuccessDelete = document.querySelector('#flash-success-delete');
    if (flashSuccessDelete) {
        const message = flashSuccessDelete.value || flashSuccessDelete.textContent;
        toastr.success(message);
    }

    const flashError = document.querySelector('#flash-error');
    if (flashError) {
        const message = flashError.value || flashError.textContent;
        toastr.error(message);
    }
}
