// prevent user from realoding page manually
window.addEventListener('keydown', function(event) {
    if ((event.key === 'F5') || (event.ctrlKey && event.key === 'r')) {
      event.preventDefault();
    }
  });

function resendCode() { // for resending 2FA and reset password codes
    location.reload();
}