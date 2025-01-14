const modals = Array.from(document.querySelectorAll('.modal'));

let currentIndex = 0; 


function nextModal() {
    hideCurrentModal();
    currentIndex = (currentIndex + 1) % modals.length;
    showModal(currentIndex);
}


function previousModal() {
    hideCurrentModal();
    currentIndex = (currentIndex - 1 + modals.length) % modals.length;
    showModal(currentIndex);
}


function hideCurrentModal() {
    const currentModal = modals[currentIndex];
    $(currentModal).modal('hide');
}


function showModal(index) {
    const modalToShow = modals[index];
    $(modalToShow).modal('show');
}


window.addEventListener('keydown', event => {
    switch(event.key) {
        case 'Escape': 
            closeAllModals();
            break;
        case 'ArrowUp':
            previousModal();
            break;
        case 'ArrowDown':
            nextModal();
            break;
    }
});


$('.close').on('click', closeAllModals);


function closeAllModals() {
    modals.forEach(modal => $(modal).modal('hide'));
}


$(modals[0]).modal('show');