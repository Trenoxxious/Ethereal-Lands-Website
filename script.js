document.addEventListener('DOMContentLoaded', function () {
    let topLogo = document.getElementById('toplogo');
    let expandMenuButton = document.getElementById('menuexpand');
    let closeMenuButton = document.getElementById('menuclose');
    let expandedMenu = document.getElementById('expandedmenu');
    let buySoulsButton = document.getElementById('buysouls');
    let menuOpen = false;

    if (topLogo) {
        topLogo.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    if (expandMenuButton) {
        expandMenuButton.addEventListener('click', () => {
            if (!menuOpen) {
                menuOpen = true;
                expandedMenu.style.transform = "translateX(0px)";
            }
        });
    }

    if (closeMenuButton) {
        closeMenuButton.addEventListener('click', () => {
            if (menuOpen) {
                menuOpen = false;
                expandedMenu.style.transform = "translateX(300px)";
            }
        });
    }

    if (buySoulsButton) {
        buySoulsButton.addEventListener('click', function () {
            window.location.href = 'buysouls';
        });
    }

    // Handle Claim Souls form submission asynchronously
    $('form.complete-challenge-form').on('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        let form = $(this);
        let challengeId = form.find('input[name="challenge_id"]').val();

        $.ajax({
            url: 'scripts/check_challenge.php',
            type: 'POST',
            data: form.serialize(),
            success: function (response) {
                window.location.reload(); // Refresh the page
            },
            error: function (xhr, status, error) {
                console.error('Error completing challenge:', status, error);
            }
        });
    });

    function checkProgress() {
        // Check if the current page URL contains 'challenges'
        if (window.location.href.includes('account/challenges')) {
            $.ajax({
                url: 'scripts/check_progress.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    data.forEach(function (challenge) {
                        var progressElement = $('#progress-' + challenge.id);
                        var buttonElement = $('#claim-button-' + challenge.id);
                        if (progressElement.length) {
                            progressElement.text(challenge.value + ' / ' + challenge.fulfillment_amount);
                        }
                        if (buttonElement.length) {
                            if (challenge.value >= challenge.fulfillment_amount) {
                                buttonElement.prop('disabled', false);
                            } else {
                                buttonElement.prop('disabled', true);
                            }
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching progress:', status, error);
                }
            });
        }
    }

    // Initial check
    checkProgress();

    // Check progress every 5 seconds
    setInterval(checkProgress, 5000);
});