document.addEventListener("DOMContentLoaded", function () {
    const containers = document.querySelectorAll('.Container');

    containers.forEach(container => {
        const boxContainer = container.querySelector('.Box-Container');
        const leftArrow = container.querySelector('.Arrow.left');
        const rightArrow = container.querySelector('.Arrow.right');
        const scrollAmount = 1400;

        leftArrow.addEventListener('click', function () {
            scroll(boxContainer, -1);
        });

        rightArrow.addEventListener('click', function () {
            scroll(boxContainer, 1);
        });

        function scroll(boxContainer, direction) {
            const containerWidth = container.offsetWidth;
            const maxScrollAmount = boxContainer.offsetWidth - containerWidth;
            const currentScrollAmount = Math.abs(parseInt(boxContainer.style.transform.split('(')[1])) || 0;
            const newScrollAmount = direction === -1 ? Math.max(currentScrollAmount - scrollAmount, 0) :
                Math.min(currentScrollAmount + scrollAmount, maxScrollAmount);
            boxContainer.style.transform = 'translateX(-' + newScrollAmount + 'px)';
            updateArrowVisibility(newScrollAmount, maxScrollAmount, leftArrow, rightArrow);
        }

        function updateArrowVisibility(scrollAmount, maxScrollAmount, leftArrow, rightArrow) {
            if (scrollAmount === 0) {
                leftArrow.classList.add('Hide');
            } else {
                leftArrow.classList.remove('Hide');
            }

            if (scrollAmount === maxScrollAmount) {
                rightArrow.classList.add('Hide');
            } else {
                rightArrow.classList.remove('Hide');
            }
        }
    });
});
