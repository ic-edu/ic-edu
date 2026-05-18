const STORAGE_KEY = 'icedu_exam_view';

document.addEventListener('DOMContentLoaded', () => {
    const gridContainer = document.getElementById('exam-grid-container');
    const btnGrid = document.getElementById('btn-grid-view');
    const btnList = document.getElementById('btn-list-view');

    if (!gridContainer || !btnGrid || !btnList) return;

    function setView(mode) {
        const isGrid = mode === 'grid';

        gridContainer.classList.toggle('view-grid', isGrid);
        gridContainer.classList.toggle('view-list', !isGrid);

        gridContainer.querySelectorAll('.ec__card').forEach(
            card => card.classList.toggle('ec__card--list', !isGrid)
        );

        btnGrid.classList.toggle('active', isGrid);
        btnList.classList.toggle('active', !isGrid);

        localStorage.setItem(STORAGE_KEY, mode);
    }

    const savedView = localStorage.getItem(STORAGE_KEY) || 'grid';
    setView(savedView);

    btnGrid.addEventListener('click', () => setView('grid'));
    btnList.addEventListener('click', () => setView('list'));
});
