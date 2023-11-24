document.addEventListener('DOMContentLoaded', function () {
    let isWeekly = true;
    const toggleButton = document.getElementById('toggleButton');
    toggleButton.addEventListener('click', toggleRanking);

    function toggleRanking() {
        //console.log('Button clicked');
        isWeekly = !isWeekly;
        showRanking();
    }

    function showRanking() {
        const weeklyElement = document.getElementById('rankingList');
        const totalElement = document.getElementById('totalRankingList');
        const titleElement = document.getElementById('rankingTitle');
        if (isWeekly) {
            weeklyElement.style.display = 'table';
            totalElement.style.display = 'none';
            titleElement.innerHTML = '週間ランキング';
        } else {
            weeklyElement.style.display = 'none';
            totalElement.style.display = 'table';
            titleElement.innerHTML = '総合ランキング';
        }
    }

    // 最初に週間売上を表示
    showRanking();
});
