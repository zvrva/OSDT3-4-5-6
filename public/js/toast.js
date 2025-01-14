document.getElementById('loadButton').addEventListener('click', function() {
    const toast = document.getElementById('toast');
    

    toast.classList.add('show');
    toast.style.display = 'block'; // Устанавливаем стиль, чтобы элемент был видимым
});

document.getElementById('okButton').addEventListener('click', function() {
    const toast = document.getElementById('toast');
    

    toast.classList.remove('show');
    toast.style.display = 'none'; 
});
