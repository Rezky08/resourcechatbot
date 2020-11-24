
    function updateMobileClass(screenSize, target) {
        if (screenSize < 765) {
            target.classList.remove('show')
        } else {
            target.classList.add('show')
        }
    }

    window.addEventListener('resize', function() {
        let sidebar = document.getElementById('sidebar')
        screenSize = this.innerWidth;
        updateMobileClass(screenSize, sidebar)
    })
    window.addEventListener('load', function() {
        let sidebar = document.getElementById('sidebar')
        screenSize = this.innerWidth;
        updateMobileClass(screenSize, sidebar)
    })
