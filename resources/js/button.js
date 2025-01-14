const toastTrigger = document.getElementById('load-button')
    const toastLiveExample = document.getElementById('toast-1')
    if (toastTrigger) {
        toastTrigger.addEventListener('click', () => {
            const toast = new bootstrap.Toast(toastLiveExample)

            toast.show()
            // Скрытие Toasta через 3 секунды
            setTimeout(() => {
                toast.hide()
            }, 3000);
        })
    }