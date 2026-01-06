document.addEventListener('DOMContentLoaded', function() {
    const countryLinks = document.querySelectorAll('.country-nav a');
    const storySections = document.querySelectorAll('.story-section');
    if (countryLinks.length > 1 && countryLinks[1].textContent === countryLinks[2].textContent) {
    }
    countryLinks.forEach((link, index) => {
        link.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                const nextIndex = (index + 1) % countryLinks.length;
                countryLinks[nextIndex].focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                const prevIndex = (index - 1 + countryLinks.length) % countryLinks.length;
                countryLinks[prevIndex].focus();
            }
        });
    });
    function switchContent(country) {
        storySections.forEach(section => {
            section.style.display = 'none';
            section.classList.remove('active');
        });
        const selectedSection = document.getElementById(`content-${country}`);
        if (selectedSection) {
            selectedSection.style.display = 'block';
            selectedSection.classList.add('active');
        }
        countryLinks.forEach(link => {
            if (link.dataset.country === country) {
                link.classList.add('active');
                link.setAttribute('aria-current', 'page');
            } else {
                link.classList.remove('active');
                link.removeAttribute('aria-current');
            }
        });
    }
    countryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const country = this.dataset.country;
            switchContent(country);
        });
        link.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const country = this.dataset.country;
                switchContent(country);
            }
        });
    });
    const dots = document.querySelectorAll('.dot');
    if (dots.length > 0) {
        function setActiveDot(index) {
            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.add('active');
                    dot.setAttribute('aria-current', 'page');
                } else {
                    dot.classList.remove('active');
                    dot.removeAttribute('aria-current');
                }
            });
            const countries = ['kazakhstan', 'american1', 'american2', 'germany', 'chinese', 'vinda'];
            if (index < countries.length) {
                switchContent(countries[index]);
            }
        }
        dots.forEach((dot, index) => {
            dot.addEventListener('click', function() {
                setActiveDot(index);
            });
            dot.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    const nextIndex = (index + 1) % dots.length;
                    dots[nextIndex].focus();
                    setActiveDot(nextIndex);
                } else if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    const prevIndex = (index - 1 + dots.length) % dots.length;
                    dots[prevIndex].focus();
                    setActiveDot(prevIndex);
                } else if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    setActiveDot(index);
                }
            });
        });
    }
});