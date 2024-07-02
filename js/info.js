// function infoOpen(id) {
//     if (id.classList.contains('hidden')) {
//         id.classList.remove('hidden');
//     } else {
//         id.classList.add('hidden');
//     }
// }

function infoOpen(id) {
    const detailRows = document.querySelectorAll('.detail-row');
    detailRows.forEach(row => {
        if (row !== id) {
            row.classList.add('hidden');
        }
    });

    id.classList.toggle('hidden');
}

function test(){
    alert("Test")
}