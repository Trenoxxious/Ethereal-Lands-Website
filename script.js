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
    if (document.getElementById('introaccountbutton')) {
        document.getElementById('introaccountbutton').addEventListener('click', function () {
            closeMenuButton.click();
        });
    }

    $(document).on('submit', 'form.complete-challenge-form', function (event) {
        event.preventDefault();
        let form = $(this);
        let challengeId = form.find('input[name="challenge_id"]').val();
        
        $.ajax({
            url: '../scripts/check_challenge.php',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    form.closest('.challenge-box').fadeOut(500, function() {
                        $(this).remove();
                    });

                    if (response.total_dailies_completed !== undefined) {
                        $('#total-dailies-completed').text(response.total_dailies_completed);
                    }

                    if (response.formatted_souls !== undefined) {
                        $('#ethereal-souls-amount').text(response.formatted_souls);
                    }

                    setTimeout(() => {
                        if ($('.challenge-box').length === 0) {
                            const finishedChallenges = document.createElement('h2');
                            finishedChallenges.textContent = 'You\'ve completed all your daily challenges! Check back soon for more!';
                            document.getElementById('challenges-container').appendChild(finishedChallenges);
                        }
                    }, 500);
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error completing challenge:', status, error);
                alert('An error occurred while completing the challenge. Please try again.');
            }
        });
    });

    function checkProgress() {
        if (window.location.href.includes('account/challenges') || (window.location.href.includes('account') && window.location.href.includes('character'))) {
            $.ajax({
                url: '../scripts/check_progress.php',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    data.forEach(function (challenge) {
                        var progressElement = $('#progress-' + challenge.id);
                        var buttonElement = $('#claim-button-' + challenge.id);
                        if (progressElement.length) {
                            progressElement.text('Progress: ' + challenge.value + ' / ' + challenge.fulfillment_amount);
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
    setInterval(checkProgress, 2000);
});